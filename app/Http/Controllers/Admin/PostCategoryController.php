<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeaturedPostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PostCategoryController extends Controller
{
    private const WP_API_ENDPOINT = '/categories?_embed&per_page=100';

    private const CACHE_KEY_CATEGORIES = 'wp_categories_cache';

    private const CACHE_KEY_LAST_FETCH = 'wp_categories_last_fetch';

    private function getApiConfig()
    {
        return [
            'base_url' => config('app.wp_api_base_url'),
            'rate_limit_calls' => (int) env('WP_API_RATE_LIMIT_CALLS', 30),
            'rate_limit_minutes' => (int) env('WP_API_RATE_LIMIT_MINUTES', 60),
        ];
    }

    private function isRateLimited()
    {
        $config = $this->getApiConfig();
        $lastFetch = Cache::get(self::CACHE_KEY_LAST_FETCH, []);

        if (empty($lastFetch)) {
            return false;
        }

        // Count API calls in the current window
        $now = time();
        $windowStart = $now - ($config['rate_limit_minutes'] * 60);

        $recentCalls = array_filter($lastFetch, fn ($timestamp) => $timestamp > $windowStart);

        return count($recentCalls) >= $config['rate_limit_calls'];
    }

    private function recordApiCall()
    {
        $config = $this->getApiConfig();
        $lastFetch = Cache::get(self::CACHE_KEY_LAST_FETCH, []);

        // Clean up old timestamps outside the window
        $now = time();
        $windowStart = $now - ($config['rate_limit_minutes'] * 60);
        $lastFetch = array_filter($lastFetch, fn ($timestamp) => $timestamp > $windowStart);

        // Add current timestamp
        $lastFetch[] = $now;

        // Cache for the rate limit window duration
        Cache::put(self::CACHE_KEY_LAST_FETCH, $lastFetch, $config['rate_limit_minutes'] * 60);
    }

    private function fetchCategoriesFromApi()
    {
        $config = $this->getApiConfig();
        $apiUrl = $config['base_url'].self::WP_API_ENDPOINT;

        try {
            $response = Http::timeout(10)->get($apiUrl);
            $categories = $response->json();

            Cache::forever(self::CACHE_KEY_CATEGORIES, $categories);
            $cachedAt = now()->toDateTimeString();
            Cache::forever(self::CACHE_KEY_CATEGORIES.'_at', $cachedAt);
            $this->recordApiCall();

            return [
                'categories' => $categories,
                'from_cache' => false,
                'cached_at' => Carbon::parse($cachedAt),
            ];
        } catch (\Exception $e) {
            return [
                'categories' => [],
                'from_cache' => false,
                'cached_at' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    private function getCategories($forceRefresh = false)
    {
        $cachedCategories = Cache::get(self::CACHE_KEY_CATEGORIES, []);
        $cachedAtRaw = Cache::get(self::CACHE_KEY_CATEGORIES.'_at');
        $cachedAt = null;

        if (is_string($cachedAtRaw) || is_int($cachedAtRaw) || is_float($cachedAtRaw)) {
            try {
                $cachedAt = Carbon::parse($cachedAtRaw);
            } catch (\Throwable $e) {
                $cachedAt = null;
            }
        } elseif ($cachedAtRaw instanceof Carbon) {
            $cachedAt = $cachedAtRaw;
        }

        $isCachedFresh = $cachedAt && $cachedAt->gt(now()->subDay());

        if ($forceRefresh) {
            if ($this->isRateLimited()) {
                return [
                    'categories' => $cachedCategories,
                    'from_cache' => true,
                    'cached_at' => $cachedAt,
                    'rate_limited' => true,
                    'error' => 'Rate limit reached. Showing cached data.',
                ];
            }

            return $this->fetchCategoriesFromApi();
        }

        if ($isCachedFresh) {
            return [
                'categories' => $cachedCategories,
                'from_cache' => true,
                'cached_at' => $cachedAt,
            ];
        }

        $result = $this->fetchCategoriesFromApi();

        if (! $result['categories'] && $cachedCategories) {
            return [
                'categories' => $cachedCategories,
                'from_cache' => true,
                'cached_at' => $cachedAt,
                'error' => $result['error'] ?? null,
            ];
        }

        return $result;
    }

    public function index()
    {
        $data = $this->getCategories(request()->has('refresh'));

        $featuredCategories = FeaturedPostCategory::orderBy('position')->get();
        $featuredSlugs = $featuredCategories->pluck('slug')->toArray();

        return view('admin.post-categories.index', [
            'wpCategories' => $data['categories'],
            'featuredCategories' => $featuredCategories,
            'featuredSlugs' => $featuredSlugs,
            'fromCache' => $data['from_cache'] ?? false,
            'cachedAt' => $data['cached_at'] ?? null,
            'rateLimited' => $data['rate_limited'] ?? false,
            'error' => $data['error'] ?? null,
        ]);
    }

    public function refresh()
    {
        $data = $this->getCategories(true);

        if (! empty($data['rate_limited'])) {
            return redirect()->route('admin.post-categories.index')
                ->with('error', $data['error'] ?? 'Rate limit reached. Showing cached data.');
        }

        if (! empty($data['error'])) {
            return redirect()->route('admin.post-categories.index')
                ->with('error', $data['error']);
        }

        return redirect()->route('admin.post-categories.index')
            ->with('success', 'Categories refreshed.');
    }

    public function toggleFeatured(Request $request)
    {
        $validated = $request->validate([
            'slug' => ['required', 'string'],
            'is_featured' => ['required', 'boolean'],
        ]);

        if ($validated['is_featured']) {
            $count = FeaturedPostCategory::count();
            if ($count >= 6) {
                return back()->with('error', 'Maximum 6 categories can be marked as featured.');
            }

            FeaturedPostCategory::updateOrCreate(
                ['slug' => $validated['slug']],
                ['position' => $count + 1]
            );

            return back()->with('success', 'Category marked as featured.');
        } else {
            FeaturedPostCategory::where('slug', $validated['slug'])->delete();
            FeaturedPostCategory::where('position', '>', 0)->get()->each(function ($cat, $idx) {
                $cat->update(['position' => $idx + 1]);
            });

            return back()->with('success', 'Category removed from featured.');
        }
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'order' => ['required', 'array'],
        ]);

        foreach ($validated['order'] as $index => $slug) {
            FeaturedPostCategory::where('slug', $slug)
                ->update(['position' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
