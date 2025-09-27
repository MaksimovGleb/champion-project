<?php

namespace Database\Factories;

use App\Enums\TaskStatus;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'subject' => $this->faker->word(),
            'body' => $this->faker->paragraph(),
            'status' =>  array_rand(TaskStatus::toArray()),
            'created_at' =>$this->faker->dateTimeBetween("-1 years"),
            'type_id' => $this->faker->numberBetween(1, 8),
            'creator_id' => null,
        ];
    }
}
