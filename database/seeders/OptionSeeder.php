<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Option::create([
            'name' => 'Legit',
            'group' => '1',
        ]);
        Option::create([
            'name' => 'Fake',
            'group' => '1',
        ]);
        Option::create([
            'name' => 'Yes',
            'group' => '2',
        ]);
        Option::create([
            'name' => 'No',
            'group' => '2',
        ]);
        Option::create([
            'name' => 'True',
            'group' => '3',
        ]);
        Option::create([
            'name' => 'False',
            'group' => '3',
        ]);
    }
}
