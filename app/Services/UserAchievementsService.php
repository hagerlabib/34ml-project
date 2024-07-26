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

        $achievement = $this->getAchievements('>')->pluck('title');

        if (mb_stripos($achievement[$index], AchievementTypeEnum::Comment->value)) {
            $nextOne[] = $achievement[0];
            $nextOne[] = $achievement[$index];
        } else {
            $nextOne = $this->nextAvailableAchievements($user, $index + 1, $nextOne);
        }

        return $nextOne;
    }

    private function getAchievements(string $operator): Collection
    {
        return Achievement::where(function ($query) use ($operator) {
            $query->where('type', AchievementTypeEnum::Comment->value)->where('number', $operator, $this->commentsCount)
                ->orWhere('type', AchievementTypeEnum::Lesson->value)->where('number', $operator, $this->lessonsCount);
        })->get();
    }
}
