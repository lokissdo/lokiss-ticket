<?php

namespace Database\Factories;

use App\Models\Rating;
use App\Models\ServiceProvider;
use App\Models\Ticket;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $ticket = $this->faker->randomElement(Ticket::get());
        } while (Rating::where('user_id', $ticket->user_id)->where('trip_id', $ticket->trip_id)->exists());
        $service_provider_id = Trip::find($ticket->trip_id)->service_provider_id;
        return [
            'comment' => $this->faker->realText(),
            'trip_id' => $ticket->trip_id,
            'service_provider_id' => $service_provider_id,
            'rate' => rand(2.0, 5.0),
            'user_id' => $ticket->user_id
        ];
    }
}
