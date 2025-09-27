<?php

namespace Database\Factories;


use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    protected $model = Like::class;

    public function definition()
    {
        return [
            'user_id' => 5,//User::factory(),
            'resource_id' => null,
            'item_id' => 1,
            'item_type' => "App\Models\Role",
        ];
    }
}

