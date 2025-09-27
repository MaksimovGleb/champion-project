<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition()
    {
        $type = $this->faker->numberBetween(Job::JOB_TYPE_INTERNAL, Job::JOB_TYPE_EXTERNAL);
        $object_id = $type == Job::JOB_TYPE_INTERNAL ? User::all()->random()->id : Task::all()->random()->id;
        $object_type = $type == Job::JOB_TYPE_INTERNAL ? User::class : Task::class;

        return [
            'title' => $this->faker->word(),
            'body' => $this->faker->text,
            'start' => $this->faker->dateTimeBetween('-3 day', '+2 day'),
            'end' => $this->faker->dateTimeBetween('+1 day', '+3 day'),
            'allDay' => $this->faker->boolean,

            // Самому себе тоже можно назначить
            'user_id' => User::all()->random()->id,
            'object_id' => $object_id,
            'object_type' => $object_type,
            'status' => $this->faker->numberBetween(0, 5),
            'type' => $type,
            'backgroundColor' => $this->faker->safeHexColor,
            'borderColor' => $this->faker->safeHexColor,

        ];
    }
}
