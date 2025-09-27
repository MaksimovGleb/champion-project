<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

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
