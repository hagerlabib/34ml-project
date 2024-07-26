<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;

class WatchingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lessonIds = Lesson::limit(3)->pluck('id')->toArray();

        User::first()->watches()->attach($lessonIds);
    }
}
