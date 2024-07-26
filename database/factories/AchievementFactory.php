<?php

namespace Database\Factories;

use App\Enums\AchievementTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AchievementFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'type' => $this->randomEnumValue(AchievementTypeEnum::class),
            'number' => $this->faker->numberBetween(1, 20)
        ];
    }

    private function randomEnumValue(string $enumClass): string
    {
        $cases = $enumClass::cases();
        $randomCase = $cases[array_rand($cases)];
        return $randomCase->value;
    }
}
