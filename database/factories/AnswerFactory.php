<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\StudySpecializationEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

final class AnswerFactory extends Factory
{

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'overall_rating' => $this->faker->numberBetween(1, 5),
            'teacher_approach_rating' => $this->faker->numberBetween(1, 5),
            'expectation_fulfillment_rating' => $this->faker->numberBetween(1, 5),
            'specialization' => $this->faker->randomElement(StudySpecializationEnum::cases())
        ];
    }
}
