<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // general
            ['key' => 'site_name',       'label' => 'Site Name',          'group' => 'general', 'value' => 'Global World Academy'],
            ['key' => 'site_tagline',    'label' => 'Tagline',            'group' => 'general', 'value' => "India's Trusted MPTET Expert Coaching Online"],
            ['key' => 'phone',           'label' => 'Phone Number',       'group' => 'general', 'value' => '+91-8770803840'],
            ['key' => 'email',           'label' => 'Email Address',      'group' => 'general', 'value' => 'info@globalworldacademy.com'],
            // hero
            ['key' => 'hero_heading',    'label' => 'Hero Heading',       'group' => 'hero',    'value' => "India's Trusted MPTET Coaching Online Platform"],
            ['key' => 'hero_sub',        'label' => 'Hero Subheading',    'group' => 'hero',    'value' => 'Expert video classes, comprehensive test series & free study material — designed specifically for MPTET Varg 2 & Varg 3 aspirants across Madhya Pradesh.'],
            ['key' => 'hero_cta_url',    'label' => 'Hero CTA URL',       'group' => 'hero',    'value' => 'https://classplusapp.com/w/global-world-academy-xygeb'],
            // stats
            ['key' => 'stat_students',   'label' => 'Students Count',     'group' => 'stats',   'value' => '10'],
            ['key' => 'stat_mcq',        'label' => 'MCQ Count (K)',      'group' => 'stats',   'value' => '5'],
            ['key' => 'stat_videos',     'label' => 'Video Count',        'group' => 'stats',   'value' => '500'],
            ['key' => 'stat_years',      'label' => 'Years of Experience', 'group' => 'stats',   'value' => '5'],
            // social
            ['key' => 'youtube_url',     'label' => 'YouTube Channel URL', 'group' => 'social',  'value' => 'https://www.youtube.com/channel/UCAUjpk6WmdECWyGj90yl9Qg'],
            ['key' => 'classplus_url',   'label' => 'Classplus App URL',  'group' => 'social',  'value' => 'https://classplusapp.com/w/global-world-academy-xygeb'],
            ['key' => 'website_url',     'label' => 'Official Website',   'group' => 'social',  'value' => 'https://globalworldacademy.com'],
        ];

        foreach ($settings as $s) {
            SiteSetting::firstOrCreate(['key' => $s['key']], $s);
        }
    }
}
