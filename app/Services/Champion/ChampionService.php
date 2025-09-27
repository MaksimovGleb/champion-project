<?php

namespace App\Services\Champion;

use App\Exceptions\HasLastError;
use App\Models\Champion;

class ChampionService extends HasLastError
{
    private Champion $champion;

    public function __construct(
    ){
    }

    public function ageCategories(): array
    {
        return [
            'boys_12_13' => ['title' => 'Юноши (12-13 лет)', 'age' => [12, 13], 'weights' => [32, 36, 40, 44, 48, 52, 57, 62, 67]],
            'boys_14_15' => ['title' => 'Юноши (14-15 лет)', 'age' => [14, 15], 'weights' => [36, 40, 44, 48, 52, 57, 62, 67, 73, 80]],
            'boys_16_17' => ['title' => 'Юноши (16-17 лет)', 'age' => [16, 17], 'weights' => [48, 52, 57, 61.2, 65.8, 70.3, 77.1, 83.9, 93]],
            'juniors' => ['title' => 'Юниоры (18-20 лет)', 'age' => [18, 20], 'weights' => [52.2, 56.7, 61.2, 65.8, 70.3, 77.1, 83.9, 93, 120.2, 999]],
            'men' => ['title' => 'Мужчины', 'age' => [21, 100], 'weights' => [52.2, 56.7, 61.2, 65.8, 70.3, 77.1, 83.9, 93, 120.2, 999]],
        ];
    }


}
