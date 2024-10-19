<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Evert Huaman',
            'email' => 'admin@mail.com',
            'password' => bcrypt('12345678'),
        ]);

        Storage::deleteDirectory('products');
        
        Storage::makeDirectory('products');

        $this->call(FamilySeeder::class);

        Product::factory(50)->create();
    }
}
