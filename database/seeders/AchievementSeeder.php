<?php

namespace Database\Seeders;

use App\Enums\AchievementTypeEnum;
use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'title' => 'First Lesson Watched',
                'type' => AchievementTypeEnum::Lesson,
                'number' => 1,
            ],
            [
                'title' => '5 Lessons Watched',
                'type' =>  AchievementTypeEnum::Lesson,
                'number' => 5,
            ],
            [
                'title' => '10 Lessons Watched',
                'type' =>  AchievementTypeEnum::Lesson,
                'number' => 10,
            ],
            [
                'title' => '25 Lessons Watched',
                'type' =>  AchievementTypeEnum::Lesson,
                'number' => 25,
            ],
            [
                'title' => '50 Lessons Watched',
                'type' =>  AchievementTypeEnum::Lesson,
                'number' => 50,
            ],
            [
                'title' => 'First Comment Written',
                'type' => AchievementTypeEnum::Comment,
                'number' => 1,
            ],
            [
                'title' => '3 Comments Written',
                'type' => AchievementTypeEnum::Comment,
                'number' => 3,
            ],
            [
                'title' => '5 Comments Written',
                'type' => AchievementTypeEnum::Comment,
                'number' => 5,
            ],
            [
                'title' => '10 Comments Written',
                'type' => AchievementTypeEnum::Comment,
                'number' => 10,
            ],
            [
                'title' => '20 Comments Written',
                'type' => AchievementTypeEnum::Comment,
                'number' => 20,
            ]
        ];
        Achievement::insert($achievements);
    }
}
