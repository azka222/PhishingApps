<?php

namespace Database\Seeders;

use App\Models\ModuleAbility;
use Illuminate\Database\Seeder;

class ModuleAbilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModuleAbility::create(['module_id' => 1, 'ability_id' => 2]);
        ModuleAbility::create(['module_id' => 2, 'ability_id' => 1]);
        ModuleAbility::create(['module_id' => 2, 'ability_id' => 2]);
        ModuleAbility::create(['module_id' => 2, 'ability_id' => 3]);
        ModuleAbility::create(['module_id' => 2, 'ability_id' => 4]);
        ModuleAbility::create(['module_id' => 3, 'ability_id' => 1]);
        ModuleAbility::create(['module_id' => 3, 'ability_id' => 2]);
        ModuleAbility::create(['module_id' => 3, 'ability_id' => 3]);
        ModuleAbility::create(['module_id' => 3, 'ability_id' => 4]);
        ModuleAbility::create(['module_id' => 4, 'ability_id' => 1]);
        ModuleAbility::create(['module_id' => 4, 'ability_id' => 2]);
        ModuleAbility::create(['module_id' => 4, 'ability_id' => 3]);
        ModuleAbility::create(['module_id' => 4, 'ability_id' => 4]);
        ModuleAbility::create(['module_id' => 5, 'ability_id' => 1]);
        ModuleAbility::create(['module_id' => 5, 'ability_id' => 2]);
        ModuleAbility::create(['module_id' => 5, 'ability_id' => 3]);
        ModuleAbility::create(['module_id' => 5, 'ability_id' => 4]);
        ModuleAbility::create(['module_id' => 6, 'ability_id' => 1]);
        ModuleAbility::create(['module_id' => 6, 'ability_id' => 2]);
        ModuleAbility::create(['module_id' => 6, 'ability_id' => 3]);
        ModuleAbility::create(['module_id' => 6, 'ability_id' => 4]);
        ModuleAbility::create(['module_id' => 7, 'ability_id' => 1]);
        ModuleAbility::create(['module_id' => 7, 'ability_id' => 2]);
        ModuleAbility::create(['module_id' => 7, 'ability_id' => 4]);

    }
}
