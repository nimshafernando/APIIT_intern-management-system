<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->renameColumn('gpa', 'cumulative_marks');
        });
        
        // Update existing values: convert GPA (0-4) to percentage (0-100)
        DB::statement('UPDATE students SET cumulative_marks = (cumulative_marks / 4) * 100 WHERE cumulative_marks IS NOT NULL');
        
        // Change column type to allow values 0-100
        Schema::table('students', function (Blueprint $table) {
            $table->decimal('cumulative_marks', 5, 2)->nullable()->change(); // Allows up to 999.99
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert percentage back to GPA before renaming
        DB::statement('UPDATE students SET cumulative_marks = (cumulative_marks / 100) * 4 WHERE cumulative_marks IS NOT NULL');
        
        Schema::table('students', function (Blueprint $table) {
            $table->renameColumn('cumulative_marks', 'gpa');
        });
    }
};
