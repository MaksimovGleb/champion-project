<?php

namespace Database\Seeders\Champions;

use App\Models\Champion;
use App\Services\Champion\ChampionService;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;

/** Участники боев
 *  php artisan db:seed --class=Database\Seeders\Champions\ChampionsSeeder
 */
class ChampionsSeeder extends Seeder
{
    public function run(ChampionService $championService): void
    {
        $faker = Faker::create();

        $ageCategories = $championService->ageCategories();

        foreach ($ageCategories as $category) {
            foreach ($category['weights'] as $index => $weightMax) {
                $weightMin = $index === 0 ? 0 : $category['weights'][$index - 1] + 0.1;
                $championCount = rand(20, 30); // случайное количество чемпионов для каждой весовой категории

                for ($i = 0; $i < $championCount; $i++) {
                    $age = rand($category['age'][0], $category['age'][1]);
                    $birth_date = Carbon::now()->subYears($age)->subDays(rand(0, 364))->format('Y-m-d');
                    Champion::create([
                        'name' => $faker->firstName,
                        'surname' => $faker->lastName,
                        'patronymic' => $faker->optional()->firstName(),
                        'coach' => $faker->company,
                        'category' => $faker->randomDigitNotNull(),
                        'weight' => $faker->randomFloat(2, $weightMin, $weightMax),
                        'birth_date' => $birth_date,
                    ]);
                }
            }
        }
    }
}
