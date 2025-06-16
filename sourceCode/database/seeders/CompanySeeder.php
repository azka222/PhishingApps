<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanyStatus;
use App\Models\CompanyVisibility;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyStatus::create(['name' => 'Active']);
        CompanyStatus::create(['name' => 'Inactive']);
        CompanyVisibility::create(['name' => 'Public']);
        CompanyVisibility::create(['name' => 'Private']);
    }
}
