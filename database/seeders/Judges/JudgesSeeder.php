<?php

namespace Database\Seeders\Judges;

use App\Models\Judge;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

/** Судьи боев
 *  php artisan db:seed --class=Database\Seeders\Judges\JudgesSeeder
 */
class JudgesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $positions = [
            'Главный судья',
            'Главный секретарь',
            'Руководитель ринга',
            'Рефери в ринге',
            'Боковой арбитр',
            'Судья-секундометрист',
            'Технический секретарь',
        ];

        $categories = ['ССВК', 'СС1К', 'СС2К', 'СС3К'];

        $cities = [
            'Краснодар', 'Воронеж', 'Смоленск', 'Сочи', 'Судак',
            'Новороссийск', 'Рязань', 'Петропавловск-Камчатский',
            'Грозный', 'Москва', 'Ростов-на-Дону', 'Нальчик',
            'Пятигорск', 'Махачкала', 'Мурманск', 'Симферополь', 'Анапа'
        ];

        for ($i = 0; $i < 20; $i++) {
            Judge::create([
                'position' => $faker->randomElement($positions),
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'patronymic' => $faker->optional()->firstName,
                'country' => 'Россия',
                'city' => $faker->randomElement($cities),
                'category' => $faker->randomElement($categories),
            ]);
        }
    }
}
