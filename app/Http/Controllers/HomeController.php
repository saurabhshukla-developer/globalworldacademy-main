<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\FeaturedPostCategory;
use App\Models\Material;
use App\Models\QuizCategory;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::active()->get();
        $materials = Material::active()->get();
        $settings = SiteSetting::pluck('value', 'key');
        $categories = QuizCategory::with(['activeTopics.activeQuestions'])->active()->get();
        $quizData = $this->buildQuizData($categories);

        return view('welcome', compact('courses', 'materials', 'settings', 'quizData', 'categories'));
    }

    public function quiz()
    {
        $settings = SiteSetting::pluck('value', 'key');
        $categories = QuizCategory::with(['activeTopics.activeQuestions'])->active()->get();
        $quizData = $this->buildQuizData($categories);

        return view('quiz', compact('settings', 'quizData', 'categories'));
    }

    public function tutorials()
    {
        $settings = SiteSetting::pluck('value', 'key');
        $featuredCategories = FeaturedPostCategory::orderBy('position')->get();
        $wpCategories = $this->fetchWpCategoriesBySlugs($featuredCategories->pluck('slug')->all());
        $blogPosts = $this->fetchLatestBlogPosts();
        $wpBySlug = [];
        foreach ($wpCategories as $item) {
            if (! empty($item['slug'])) {
                $wpBySlug[$item['slug']] = $item;
            }
        }

        $featuredCategories = $featuredCategories->map(function ($category) use ($wpBySlug) {
            $wpData = $wpBySlug[$category->slug] ?? null;

            return [
                'slug' => $category->slug,
                'position' => $category->position,
                'name' => $wpData['name'] ?? ucwords(str_replace('-', ' ', $category->slug)),
                'link' => $wpData['link'] ?? '#',
                'has_wp' => ! empty($wpData),
            ];
        });

        return view('blog', compact('settings', 'featuredCategories', 'blogPosts'));
    }

    private function fetchLatestBlogPosts(): array
    {
        return Cache::remember('wp_latest_blog_posts_category_5', now()->addMinutes(30), function () {
            $baseUrl = config('app.wp_api_base_url');
            $response = Http::timeout(10)->get($baseUrl.'/posts', [
                'categories' => 5,
                'per_page' => 6,
                '_embed' => true,
            ]);

            if (! $response->successful()) {
                return [];
            }

            return collect($response->json())->map(function ($post) {
                $title = $this->cleanWpText(data_get($post, 'title.rendered', 'Untitled tutorial'));
                $excerpt = $this->cleanWpText(data_get($post, 'excerpt.rendered', ''));
                $media = data_get($post, '_embedded.wp:featuredmedia.0', []);

                return [
                    'title' => $title,
                    'excerpt' => Str::limit($excerpt, 130),
                    'link' => data_get($post, 'link', '#'),
                    'image' => data_get($media, 'media_details.sizes.medium_large.source_url')
                        ?? data_get($media, 'media_details.sizes.large.source_url')
                        ?? data_get($media, 'media_details.sizes.medium.source_url')
                        ?? data_get($media, 'source_url'),
                    'image_alt' => $this->cleanWpText(data_get($media, 'alt_text')) ?: $title,
                ];
            })->all();
        });
    }

    private function fetchWpCategoriesBySlugs(array $slugs): array
    {
        $slugs = array_filter($slugs);
        if (empty($slugs)) {
            return [];
        }

        $cacheKey = 'wp_tutorial_categories_'.md5(implode(',', $slugs));

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($slugs) {
            $baseUrl = config('app.wp_api_base_url');
            $response = Http::timeout(10)->get($baseUrl.'/categories', [
                'slug' => implode(',', $slugs),
                'per_page' => count($slugs),
            ]);

            if (! $response->successful()) {
                return [];
            }

            return $response->json();
        });
    }

    private function cleanWpText(?string $value): string
    {
        return trim(html_entity_decode(strip_tags($value ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    /** Build JS-ready quiz data from DB categories/topics */
    private function buildQuizData($categories): array
    {
        $out = [];
        foreach ($categories as $cat) {
            foreach ($cat->activeTopics as $topic) {
                $questions = $topic->activeQuestions;
                if ($questions->isEmpty()) {
                    continue;
                }

                $out[$topic->slug] = [
                    'name' => $topic->name,
                    'name_hi' => $topic->name_hi ?? $topic->name,
                    'icon' => $topic->icon,
                    'category' => $cat->name,
                    'category_hi' => $cat->name_hi ?? $cat->name,
                    'color' => $cat->color,
                    'questions' => $questions->map(fn ($q) => [
                        'q' => $q->question,
                        'q_hi' => $q->question_hi ?? $q->question,
                        'opts' => $q->options,
                        'ans' => $q->answer_index,
                        'explain' => $q->explanation ?? '',
                        'explain_hi' => $q->explanation_hi ?? $q->explanation ?? '',
                    ])->values()->toArray(),
                ];
            }
        }

        return $out;
    }
}
