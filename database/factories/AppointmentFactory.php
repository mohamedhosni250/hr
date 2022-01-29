<?php

namespace Database\Factories;

use App\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start_time = now()->addHours(rand(1, 100));
        return [
           
            'start_time' => $start_time->format('Y-m-d H') . ':00',
          
        ];
    }
}
