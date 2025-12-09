<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ActivityType;

class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activityTypes = [
            ['name' => 'Company Visit', 'description' => 'Physical visit to company premises'],
            ['name' => 'Email Communication', 'description' => 'Email correspondence with company'],
            ['name' => 'Phone Call', 'description' => 'Phone conversation with company contact'],
            ['name' => 'CV Submission', 'description' => 'Student CV sent to company'],
            ['name' => 'Interview Scheduled', 'description' => 'Interview arranged for student'],
            ['name' => 'Follow-up', 'description' => 'Follow-up communication with company'],
            ['name' => 'Meeting', 'description' => 'Formal meeting with company representative'],
            ['name' => 'Other', 'description' => 'Other activity types'],
        ];

        foreach ($activityTypes as $type) {
            ActivityType::create($type);
        }
    }
}
