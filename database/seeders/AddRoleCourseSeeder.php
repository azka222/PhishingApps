<?php

namespace Database\Seeders;

use App\Models\ModuleAbility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;

class AddRoleCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Module::create([
            'name' => 'Course',
        ]);
        ModuleAbility::create([
            'ability_id' => 2,
            'module_id' => 8,
        ]);
    }
}
