<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    protected $model = Registration::class;

    public function definition(): array
    {
        return [
            'name'                       => $this->faker->name(),
            'email'                      => $this->faker->unique()->safeEmail(),
            'phone'                      => $this->faker->phoneNumber(),
            'unique_code'                => strtoupper($this->faker->bothify('??##??')),
            'has_attended'               => false,
            'is_approved'                => $this->faker->boolean(80), // mostly approved
            'approved_at'                => null,
            'attended_at'                => null,
            'last_blasted_at'            => null,
            'last_successful_sent_at'    => null,
            'whatsapp_send_attempts'     => 0,
            'extras'                     => [],
            'event_id'                   => Event::factory(), // assumes you have an EventFactory
        ];
    }

    /**
     * Indicate that the registration is approved.
     */
    public function approved(): static
    {
        return $this->state(fn() => [
            'is_approved' => true,
            'approved_at' => now(),
        ]);
    }

    /**
     * Indicate that the registration has attended.
     */
    public function attended(): static
    {
        return $this->state(fn() => [
            'attended_at' => now(),
            'has_attended' => true,
        ]);
    }
}
