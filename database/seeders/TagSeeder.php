<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        Tag::factory()->create(
            [
                'name' => 'Terror',
                'description' => 'Terrorifico',
            ]
        );
        Tag::factory()->create(
            [
                'name' => 'Humor',
                'description' => 'Que gracia',
            ]
        );
        Tag::factory()->create(
            [
                'name' => 'Love',
                'description' => 'Que bonito es el amor',
            ]
        );
    }
}
