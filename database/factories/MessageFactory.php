<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $creator_id = User::inRandomOrder()->first()->id;
        $to_user = null;
        if (rand(0, 99) < 15) {
            $to_user = User::inRandomOrder()->first()->id;
        }

        return [
            'subject' => $this->faker->word(),
            'body' => $this->faker->paragraph(),
            'creator_id' => $creator_id,
            'to_user_id' => $to_user,
            'status' => ($creator_id == 5 ? 0 : rand(0, 1)),
            'task_id' => 5,
        ];
    }
}
