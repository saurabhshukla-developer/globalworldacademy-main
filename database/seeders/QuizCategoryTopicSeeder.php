<?php

namespace Database\Seeders;

use App\Models\QuizCategory;
use App\Models\QuizQuestion;
use App\Models\QuizTopic;
use Illuminate\Database\Seeder;

class QuizCategoryTopicSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name'    => 'Science',
                'name_hi' => 'विज्ञान',
                'slug'    => 'science',
                'icon'    => '🔬',
                'color'   => '#1155cc',
                'sort_order' => 1,
                'topics'  => [
                    ['name'=>'General Science', 'name_hi'=>'सामान्य विज्ञान', 'slug'=>'general-science', 'icon'=>'🧪', 'sort_order'=>1, '_legacy'=>'science'],
                    ['name'=>'Biology',         'name_hi'=>'जीव विज्ञान',    'slug'=>'biology',         'icon'=>'🧬', 'sort_order'=>2, '_legacy'=>null],
                    ['name'=>'Physics',         'name_hi'=>'भौतिकी',         'slug'=>'physics',          'icon'=>'⚡', 'sort_order'=>3, '_legacy'=>null],
                    ['name'=>'Chemistry',       'name_hi'=>'रसायन विज्ञान',  'slug'=>'chemistry',        'icon'=>'⚗️', 'sort_order'=>4, '_legacy'=>null],
                ],
            ],
            [
                'name'    => 'Child Development',
                'name_hi' => 'बाल विकास',
                'slug'    => 'child-development',
                'icon'    => '👶',
                'color'   => '#1a8f3c',
                'sort_order' => 2,
                'topics'  => [
                    ['name'=>'Child Development & Pedagogy', 'name_hi'=>'बाल विकास एवं शिक्षाशास्त्र', 'slug'=>'cdp', 'icon'=>'👶', 'sort_order'=>1, '_legacy'=>'child_dev'],
                    ['name'=>'Learning & Teaching',          'name_hi'=>'अधिगम एवं शिक्षण',            'slug'=>'learning-teaching', 'icon'=>'📖', 'sort_order'=>2, '_legacy'=>null],
                ],
            ],
            [
                'name'    => 'General Knowledge',
                'name_hi' => 'सामान्य ज्ञान',
                'slug'    => 'general-knowledge',
                'icon'    => '🌍',
                'color'   => '#e8a020',
                'sort_order' => 3,
                'topics'  => [
                    ['name'=>'India GK',        'name_hi'=>'भारत सामान्य ज्ञान',    'slug'=>'india-gk',  'icon'=>'🇮🇳', 'sort_order'=>1, '_legacy'=>'gk'],
                    ['name'=>'Current Affairs', 'name_hi'=>'समसामयिक घटनाएं',       'slug'=>'current-affairs', 'icon'=>'📰', 'sort_order'=>2, '_legacy'=>null],
                ],
            ],
            [
                'name'    => 'Madhya Pradesh GK',
                'name_hi' => 'मध्यप्रदेश सामान्य ज्ञान',
                'slug'    => 'mp-gk',
                'icon'    => '🗺️',
                'color'   => '#6b3fa0',
                'sort_order' => 4,
                'topics'  => [
                    ['name'=>'MP Geography & History', 'name_hi'=>'म.प्र. भूगोल एवं इतिहास', 'slug'=>'mp-geography', 'icon'=>'🗺️', 'sort_order'=>1, '_legacy'=>'mp'],
                    ['name'=>'MP Economy & Polity',    'name_hi'=>'म.प्र. अर्थव्यवस्था एवं राजव्यवस्था', 'slug'=>'mp-polity', 'icon'=>'🏛️', 'sort_order'=>2, '_legacy'=>null],
                ],
            ],
            [
                'name'    => 'EVS',
                'name_hi' => 'पर्यावरण अध्ययन',
                'slug'    => 'evs',
                'icon'    => '🌿',
                'color'   => '#2dba58',
                'sort_order' => 5,
                'topics'  => [
                    ['name'=>'Environmental Studies', 'name_hi'=>'पर्यावरण अध्ययन', 'slug'=>'environmental-studies', 'icon'=>'🌿', 'sort_order'=>1, '_legacy'=>null],
                ],
            ],
        ];

        foreach ($data as $catData) {
            $topics  = $catData['topics'];
            unset($catData['topics']);

            $category = QuizCategory::firstOrCreate(['slug' => $catData['slug']], $catData);

            foreach ($topics as $topicData) {
                $legacy = $topicData['_legacy'];
                unset($topicData['_legacy']);
                $topicData['category_id'] = $category->id;

                $topic = QuizTopic::firstOrCreate(['slug' => $topicData['slug']], $topicData);

                // Backfill: assign topic_id to existing questions that used the legacy string key
                if ($legacy) {
                    QuizQuestion::where('topic', $legacy)
                        ->whereNull('topic_id')
                        ->update(['topic_id' => $topic->id]);
                }
            }
        }
    }
}
