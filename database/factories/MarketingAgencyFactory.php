<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MarketingAgency>
 */
class MarketingAgencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' =>fake()->company(),
            'email' =>fake()->email(),
            'phone' =>fake()->phoneNumber(),
            'start_date' =>fake()->date(),
            'end_date' =>fake()->date(),
            'total_leads' =>fake()->randomNumber(2),
        ];
    }
}
