<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'name'        => 'Varg 2 Science Mains Course & Test Series',
                'exam_tag'    => 'MPTET Varg 2',
                'description' => 'Complete video classes with notes. New syllabus based preparation.',
                'thumb_class' => 'ct1',
                'thumb_icon'  => '🔬',
                'badge'       => '🔥 Bestseller',
                'badge_style' => 'badge-hot',
                'features'    => ['Complete Video Classes with Notes', 'All Sections Chapter-wise Coverage', '5000 MCQ Practice Questions', 'Exam Pattern Based Mock Tests'],
                'price'       => 776,
                'old_price'   => 799,
                'buy_url'     => 'https://classplusapp.com/w/global-world-academy-xygeb',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Varg 3 PRE Test Series 2026',
                'exam_tag'    => 'MPTET Varg 3',
                'description' => 'Based on new 2026 syllabus with bilingual full-length tests.',
                'thumb_class' => 'ct2',
                'thumb_icon'  => '📝',
                'badge'       => 'New 2026',
                'badge_style' => 'badge-new',
                'features'    => ['10 Full Length Tests (Bilingual)', '10 Tests based on 2022 & 2024 exams', '100+ Chapter-wise MCQs', 'Daily YouTube Classes PDF'],
                'price'       => 299,
                'old_price'   => null,
                'buy_url'     => 'https://classplusapp.com/w/global-world-academy-xygeb',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Varg 2 Science PRE Exam Course – 2026',
                'exam_tag'    => 'MPTET Varg 2',
                'description' => 'Video Classes & Test Series for विज्ञान पात्रता परीक्षा (PRE).',
                'thumb_class' => 'ct3',
                'thumb_icon'  => '🧪',
                'badge'       => 'Guaranteed',
                'badge_style' => 'badge-new',
                'features'    => ['Complete Video Classes', 'Full Length Test Series', 'म.प्र. शिक्षक भर्ती Varg 2 Focused', 'Bilingual Study Material'],
                'price'       => 583,
                'old_price'   => 599,
                'buy_url'     => 'https://classplusapp.com/w/global-world-academy-xygeb',
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Varg 2 Science Full Length Test Series',
                'exam_tag'    => 'MPTET Varg 2',
                'description' => 'Complete test series with bilingual papers — Science focused.',
                'thumb_class' => 'ct4',
                'thumb_icon'  => '📊',
                'badge'       => null,
                'badge_style' => 'badge-new',
                'features'    => ['Full Length Bilingual Tests', 'Detailed Answer Key + Explanations', 'Performance Analytics'],
                'price'       => 289,
                'old_price'   => 399,
                'buy_url'     => 'https://classplusapp.com/w/global-world-academy-xygeb',
                'sort_order'  => 4,
            ],
        ];

        foreach ($courses as $c) {
            Course::firstOrCreate(['name' => $c['name']], $c);
        }
    }
}
