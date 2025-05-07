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
            'Management and Administration',
            'Finance and Accounting',
            'Information Technology',
            'Marketing and Sales',
            'Operations',
            'Production',
            'Customer Service',
            'Public Relations and Communication',
            'Strategy and Innovation',
            'Creative',
            'Risk Management',
            'Others',
        ];

        foreach ($departments as $department) {
            TargetDepartment::create(['name' => $department]);
        }

        // Create positions (roles)
        $positions = [
            'Chief Executive Officer (CEO)',
            'Chief Operating Officer (COO)',
            'Chief Financial Officer (CFO)',
            'Chief Information Officer (CIO)',
            'Chief Marketing Officer (CMO)',
            'General Manager',
            'Manager',
            'Supervisor',
            'Team Leader',
            'Coordinator',
            'IT Specialist',
            'HR Specialist',
            'Marketing Specialist',
            'Financial Analyst',
            'Administrative Staff',
            'IT Staff',
            'HR Staff',
            'Accounting Staff',
            'Sales Executive',
            'Engineer',
            'Technician',
            'QA/QC Analyst',
            'R&D Scientist',
            'Operator',
            'Logistic Officer',
            'Warehouse Staff',
            'Customer Service Representative',
            'Helpdesk Support',
            'Call Center Agent',
            'Graphic Designer',
            'Content Creator',
            'Copywriter',
            'Intern',
            'Trainee',
            'Consultant',
            'Freelancer',
            'Part-timer',
            'Others',
        ];

        foreach ($positions as $position) {
            TargetPosition::create(['name' => $position]);
        }
    }
}
