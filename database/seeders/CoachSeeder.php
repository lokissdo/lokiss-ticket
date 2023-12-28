<?php

namespace Database\Seeders;

use App\Enums\CoachTypesEnum;
use App\Models\Coach;
use App\Models\ServiceProvider;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Container\Container;

class CoachSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
    private function seed_coach_all_service_providers()
    {
        $service_provider_ids = ServiceProvider::get('id');
        foreach ($service_provider_ids as  $each) {
            Coach::create([
                'service_provider_id' => $each->id,
                'seat_number' => rand(10, 50),
                'type' => $this->faker->randomElement(CoachTypesEnum::getValues()),
                'name' => $this->faker->company(),
                'photo' => 'provider/15/n5t0eoAXw2tdgdCjlkKQY8qZJPgZYqHxBAzUnKgA.jpg'
            ]);
        }
    }
    private function update_photo_coach()
    {
        $photos = [
            'provider/15/zDgmCnsALXrhOj6wNbXXl584kmQQHS5pQwXiNmqK.jpg',
            'provider/15/W4TbZyLFAMqW1TVtg06gNnoZF40duFCNaXxmQjJd.png',
            'provider/15/nqPLbS2eWetHQiyegEMlkqH5Fx1rnGdrzoizwfX8.webp',
            'provider/15/jFfdkGlZ6pNoqZPxGelTIhKQbW5vMWToJJR1PWYQ.jpg',
            'provider/15/7F5wrccl0i4Tl5Hml7kKica749JzlaRBRgJEFIMY.png',
            'provider/15/RRsskmvtrBI1UEtdWBIxXMIz6XiO1k3fKV45Jwmi.jpg',
            'provider/15/n5t0eoAXw2tdgdCjlkKQY8qZJPgZYqHxBAzUnKgA.jpg'
        ];
        $coaches = Coach::where('photo', 'provider/15/jFfdkGlZ6pNoqZPxGelTIhKQbW5vMWToJJR1PWYQ.jpg')->get();
        foreach ($coaches as  $coach) {
            $coach->photo = $this->faker->randomElement($photos);
            $coach->save();
        }
    }
    public function run()
    {
        Coach::factory()->count(10)->create();
        $this->update_photo_coach();
    }
}
