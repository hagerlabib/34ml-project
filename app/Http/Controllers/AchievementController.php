<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserAchievementsService;
use App\Services\UserBadgesService;
use Exception;
use Illuminate\Http\JsonResponse;

class AchievementController extends Controller
{
    public function index(
        User $user,
        UserAchievementsService $achievementsService,
        UserBadgesService $badgesService
    ): JsonResponse|array
    {
        try {
            return [
                'unlocked_achievements' => $achievementsService->unlockedAchievement($user),
                'next_available_achievements' => $achievementsService->nextAvailableAchievements($user),
                'current_badge' => $badgesService->getBadges($user)['currentLevel'],
                'next_badge' => $badgesService->getBadges($user)['nextLevel'],
                'remaining_to_unlock_next_badge' => $badgesService->getBadges($user)['remaining'],
            ];

        }catch (Exception $exception) {
               return response()->json([
                'message' => 'Something went wrong',
                'error' => $exception->getMessage()
            ], 500);

        }

    }
}
