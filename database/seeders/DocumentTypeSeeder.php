<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentType;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentTypes = [
            ['name' => 'CV', 'description' => 'Curriculum Vitae / Resume'],
            ['name' => 'Activity Logs', 'description' => 'Weekly internship activity logs and reports'],
            ['name' => 'Marksheets', 'description' => 'Academic transcripts and marksheets'],
            ['name' => 'Placement Forms', 'description' => 'Internship placement confirmation forms'],
            ['name' => 'Offer Letter', 'description' => 'Official Internship Offer Letter from Company'],
            ['name' => 'NDA', 'description' => 'Non-Disclosure Agreement'],
            ['name' => 'Industry Midpoint Evaluation', 'description' => 'Mid-term evaluation by industry supervisor'],
            ['name' => 'Industry Final Evaluation', 'description' => 'Final evaluation by industry supervisor'],
            ['name' => 'Academic Evaluation Sheet', 'description' => 'Academic evaluation by university lecturer'],
            ['name' => 'Weekly Work Log', 'description' => 'Weekly internship activity report'],
            ['name' => 'Attendance Sheet', 'description' => 'Internship attendance record'],
            ['name' => 'Supporting Documents', 'description' => 'Other relevant supporting documents'],
        ];

        foreach ($documentTypes as $type) {
            DocumentType::firstOrCreate(
                ['name' => $type['name']],
                ['description' => $type['description']]
            );
        }
    }
}
