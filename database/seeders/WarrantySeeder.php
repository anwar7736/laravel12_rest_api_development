<?php

namespace Database\Seeders;

use App\Models\Warranty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarrantySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Warranty::factory()->create([
            'name' => '7 Days Warranty',
            'type' => 1,
            'count' => 7,
            'created_by' => 1,
        ]);
    }
}
