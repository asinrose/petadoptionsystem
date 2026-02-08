<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Pet;
use App\Models\User;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // Assign to first user

        if (!$user) {
            $user = User::factory()->create();
        }

        Pet::create([
            'name' => 'Buddy',
            'breed' => 'Golden Retriever',
            'age' => 2,
            'gender' => 'male',
            'status' => 'available',
            'description' => 'Friendly and energetic Golden Retriever looking for a loving home.',
            'user_id' => $user->id,
            'image' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'location' => 'New York, NY',
            'type' => 'dog',
        ]);

        Pet::create([
            'name' => 'Mittens',
            'breed' => 'Siamese',
            'age' => 1,
            'gender' => 'female',
            'status' => 'available',
            'description' => 'Quiet and affectionate Siamese cat.',
            'user_id' => $user->id,
            'image' => 'https://images.unsplash.com/photo-1513245543132-31f507417b26?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'location' => 'Los Angeles, CA',
            'type' => 'cat',
        ]);

        Pet::create([
            'name' => 'Max',
            'breed' => 'German Shepherd',
            'age' => 3,
            'gender' => 'male',
            'status' => 'available',
            'description' => 'Loyal and protective German Shepherd.',
            'user_id' => $user->id,
            'image' => 'https://images.unsplash.com/photo-1589941013453-ec89f33b5e95?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'location' => 'Chicago, IL',
            'type' => 'dog',
        ]);
    }
}
