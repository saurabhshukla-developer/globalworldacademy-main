<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            ['title' => 'MPTET Varg 2 Science – Chapter Notes', 'description' => 'Comprehensive chapter-wise notes for Varg 2 Science — Physics, Chemistry & Biology covered.', 'icon' => '📘', 'icon_bg_class' => 'mi-blue',   'tags' => ['PDF', 'Hindi + English', 'Free'], 'sort_order' => 1],
            ['title' => 'MPTET Varg 3 PRE – Previous Year Questions', 'description' => '2022 & 2024 previous year question papers with answers — best for last-minute revision.', 'icon' => '📗', 'icon_bg_class' => 'mi-green',  'tags' => ['PDF', 'Bilingual', 'Free'], 'sort_order' => 2],
            ['title' => 'Child Development & Pedagogy – Summary Sheet', 'description' => 'One-page quick revision sheets covering all key topics of Child Development for MPTET.', 'icon' => '📙', 'icon_bg_class' => 'mi-gold',   'tags' => ['PDF', 'Quick Revision', 'Free'], 'sort_order' => 3],
            ['title' => 'MP GK – Important Facts for Teacher Exams', 'description' => 'Madhya Pradesh GK handpicked facts — geography, history, culture & current affairs.', 'icon' => '📕', 'icon_bg_class' => 'mi-red',    'tags' => ['PDF', 'MP Focused', 'Free'], 'sort_order' => 4],
            ['title' => 'Science Formula Sheet – Physics & Chemistry', 'description' => 'All important formulas, units, and definitions — printable quick-reference card.', 'icon' => '🧮', 'icon_bg_class' => 'mi-purple', 'tags' => ['PDF', 'Printable', 'Free'], 'sort_order' => 5],
        ];

        foreach ($materials as $m) {
            Material::firstOrCreate(['title' => $m['title']], $m);
        }
    }
}
