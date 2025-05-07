<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            ['name' => 'Dashboard'],
            ['name' => 'Target'],
            ['name' => 'Group'],
            ['name' => 'Sending Profile'],
            ['name' => 'Email Template'],
            ['name' => 'Landing Page'],
            ['name' => 'Campaign']
        ];

        foreach ($modules as $module) {
            \App\Models\Module::create($module);
        }
    }
}
