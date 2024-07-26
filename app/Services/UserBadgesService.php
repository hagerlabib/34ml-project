<?php

namespace App\Services;

use App\Enums\BadgeEnum;
use App\Models\User;

class UserBadgesService
{
    public function __construct(public readonly UserAchievementsService $achievementsService)
    {
    }

    public function getBadges(User $user)
    {
        $achievementsCount = $this->achievementsService->unlockedAchievement($user)->count();

        $currentLevel = $nextLevel = "";
        $remaining = 0;

        foreach (BadgeEnum::asSelectArray() as $level => $levelCount) {
            if ($achievementsCount >= $levelCount) {
                $currentLevel = $level;
            } elseif ($nextLevel === "") {
                $nextLevel = $level;
                $remaining = $levelCount - $achievementsCount;
            }
        }

        return get_defined_vars();
    }
}
