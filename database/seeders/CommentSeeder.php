<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lessonIds = Lesson::limit(3)->pluck('id')->toArray();

        $data = array_map(function ($lessonId) {
            return ['comment' => 'Some comment for lesson ' . $lessonId];
        }, $lessonIds);

        User::first()->comments()->attach(array_combine($lessonIds, $data));
    }
}
