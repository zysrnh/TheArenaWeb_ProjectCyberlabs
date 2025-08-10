<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $name = $this->faker->sentence(3); // e.g. "SAC Opening Ceremony"

        return [
            'name' => $name,
            // Slug will be automatically generated in model boot() method
            'slug' => str($name)->slug(),
        ];
    }
}
