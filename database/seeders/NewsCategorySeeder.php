<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newsCategories = [
            [
                'name' => 'Business Partnership Announcements',
            ],
            [
                'name' => 'Service or Product Launches'
            ],
            [
                'name' => 'Partnership Press Release'
            ],
            [
                'name' => 'New Hire Announcements'
            ]
        ];

        foreach ($newsCategories as $newsCategory) {
            NewsCategory::create($newsCategory);
        }

    }
}
