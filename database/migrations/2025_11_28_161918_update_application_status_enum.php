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
        // Check if using MySQL
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE applications MODIFY COLUMN status ENUM('Pending', 'CV Sent', 'Shortlisted', 'Interview', 'Offer Sent', 'Rejected', 'Approved', 'Completed') DEFAULT 'Pending'");
        } else {
            // For SQLite and other databases, recreate the table
            Schema::table('applications', function (Blueprint $table) {
                $table->string('status')->default('Pending')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if using MySQL
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE applications MODIFY COLUMN status ENUM('Pending', 'CV Sent', 'Shortlisted', 'Interview', 'Rejected', 'Approved') DEFAULT 'Pending'");
        } else {
            // For SQLite and other databases
            Schema::table('applications', function (Blueprint $table) {
                $table->string('status')->default('Pending')->change();
            });
        }
    }
};
