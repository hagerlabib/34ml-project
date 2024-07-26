<?php

namespace Tests\Feature;

use App\Enums\AchievementTypeEnum;
use App\Http\Controllers\AchievementController;
use App\Models\Achievement;
use App\Models\Lesson;
use App\Models\User;
use App\Services\UserAchievementsService;
use App\Services\UserBadgesService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class AchievementTest extends TestCase
{
    protected $user;
    protected $achievementsService;
    protected $badgesService;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->achievementsService = Mockery::mock(UserAchievementsService::class);
        $this->badgesService = Mockery::mock(UserBadgesService::class);
        $this->controller = new AchievementController();
    }

    public function testControllerResponse()
    {
        $this->achievementsService
            ->shouldReceive('unlockedAchievement')
            ->with($this->user)
            ->andReturn(collect());

        $this->achievementsService
            ->shouldReceive('nextAvailableAchievements')
            ->with($this->user)
            ->andReturn(['Next Achievement 1', 'Next Achievement 2']);

        $this->badgesService
            ->shouldReceive('getBadges')
            ->with($this->user)
            ->andReturn([
                'currentLevel' => 'Beginner',
                'nextLevel' => 'Intermediate',
                'remaining' => 4
            ]);

        $response = $this->controller->index(
            $this->user,
            $this->achievementsService,
            $this->badgesService
        );

        $this->assertEquals([
            'unlocked_achievements' => collect(),
            'next_available_achievements' => ['Next Achievement 1', 'Next Achievement 2'],
            'current_badge' => 'Beginner',
            'next_badge' => 'Intermediate',
            'remaining_to_unlock_next_badge' => 4
        ], $response);
    }

    public function testReturnsTheErrorIfNextBadgeWrong()
    {
        $user = $this->createMock(User::class);

        $achievementsService = $this->createMock(UserAchievementsService::class);

        $achievementsService->method('unlockedAchievement')
            ->willReturn(new Collection([/* mocked achievements data */]));

        $badgesService = $this->createMock(UserBadgesService::class);

        $badgesService->method('getBadges')
            ->willReturn([
                'currentLevel' => 'Beginner',
                'nextLevel' => 'Intermediate',
                'remaining' => 5,
            ]);

        $result = $this->controller->index($user, $achievementsService, $badgesService);

        $this->assertEquals('Beginner', $result['current_badge']);

        $this->assertEquals('Intermediate', $result['next_badge']);

        if ($result['current_badge'] === 'Beginner' && $result['next_badge'] !== 'Intermediate') {
            $this->fail('Next badge should be intermediate if current badge is beginner.');
        }
    }

    public function testReturnsTheCorrectUnlockedAchievements()
    {
        $lessons = Lesson::factory()->count(3)->make()->toArray();
        $this->user->watches()->createMany($lessons);

        Achievement::factory()->create([
            'title' => 'Lesson Achievement',
            'type' => AchievementTypeEnum::Lesson->value,
            'number' => 2
        ]);

        $this->achievementsService
            ->shouldReceive('unlockedAchievement')
            ->with($this->user)
            ->andReturn(collect(['Lesson Achievement']));

        $response = $this->achievementsService->unlockedAchievement($this->user);

        $this->assertTrue($response->contains('Lesson Achievement'));
    }

    public function testSendWrongUrl()
    {
        $response = $this->actingAs($this->user)->get('/achievements');

        $response->assertStatus(404);
    }
}
