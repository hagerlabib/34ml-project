<?php

namespace App\Services;

use App\Enums\AchievementTypeEnum;
use App\Models\Achievement;
use App\Models\User;
use Illuminate\Support\Collection;

class UserAchievementsService
{
    private int $lessonsCount;
    private int $commentsCount;

    public function unlockedAchievement(User $user): Collection
    {
        $this->lessonsCount = $user->watches()->count();
        $this->commentsCount = $user->comments()->count();

        return $this->getAchievements('<=')->pluck('title');
    }

    public function nextAvailableAchievements(User $user, int $index = 0, array $nextOne = []): array
    {
        $this->lessonsCount = $user->watches()->count();
        $this->commentsCount = $user->comments()->count();

        $achievements = $this->getAchievements('>')->pluck('title');

        if (isset($achievements[$index])) {
            foreach (AchievementTypeEnum::values() as $achievementType) {
                if (!in_array($achievementType, array_keys($nextOne)) && mb_stripos($achievements[$index], $achievementType)) {
                    $nextOne[$achievementType] = $achievements[$index];
                }
            }

            return $this->nextAvailableAchievements($user, $index + 1, $nextOne);
        }

        return array_values($nextOne);
    }

    private function getAchievements(string $operator): Collection
    {
        return Achievement::where(function ($query) use ($operator) {
            $query->where('type', AchievementTypeEnum::Comment->value)->where('number', $operator, $this->commentsCount)
                ->orWhere('type', AchievementTypeEnum::Lesson->value)->where('number', $operator, $this->lessonsCount);
        })->get();
    }
}
