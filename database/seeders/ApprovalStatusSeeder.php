<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprovalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Pending'],
            ['name' => 'Approved'],
            ['name' => 'Rejected'],
        ];

        foreach ($statuses as $status) {
            DB::table('approval_statuses')->insert($status);
        }
    }
}
