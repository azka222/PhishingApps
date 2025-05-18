<?php
namespace Database\Seeders;

use App\Models\TargetDepartment;
use App\Models\TargetPosition;
use Illuminate\Database\Seeder;

class TargetResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Sekretariat',
            'Bidang Ketenagalistrikan',
            'Bidang Pertambangan',
            'Bidang Air Tanah',
            'Bidang Energi',
            'Dinas',
        ];

        foreach ($departments as $department) {
            TargetDepartment::create(['name' => $department]);
        }

// Create positions (roles)
        $positions = [
            'Kepala Dinas',
            'Sekretaris Dinas',
            'Kepala Sub Bagian Tata Usaha',
            'Kepala Bidang',
            'Karyawan',
            'Kepala Seksi',
            'Dinas'

        ];

        foreach ($positions as $position) {
            TargetPosition::create(['name' => $position]);
        }

    }
}
