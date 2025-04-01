<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\StudySpecializationEnum;
use App\Models\Answer;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

final class AnswerFactory extends Factory
{

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'overall_rating' => null,
            'teacher_approach_rating' => null,
            'expectation_fulfillment_rating' => null,
            'specialization' => $this->faker->randomElement(StudySpecializationEnum::cases()),
            'access_token' => $this->faker->uuid(),
            'school_id' => School::query()->inRandomOrder()->first()->getKey(),
        ];
    }

    /**
     * @return Answer | Collection<int, Answer>
     */
    public function createAnsweredRecord(): Answer | Collection
    {
        return $this
            ->state([
                'overall_rating' => $this->faker->numberBetween(1, 5),
                'teacher_approach_rating' => $this->faker->numberBetween(1, 5),
                'expectation_fulfillment_rating' => $this->faker->numberBetween(1, 5),
                'answered_at' => $this->faker->dateTimeBetween('-1 year'),
            ])
            ->create();
    }

    /**
     * @return Answer | Collection<int, Answer>
     */
    public function createUnansweredRecord(): Answer | Collection
    {
        return $this->create();
    }
}
