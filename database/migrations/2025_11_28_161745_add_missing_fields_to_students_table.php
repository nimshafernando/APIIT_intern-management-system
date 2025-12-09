<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('phone_number');
            $table->string('profile_photo')->nullable()->after('date_of_birth');
            $table->decimal('gpa', 3, 2)->nullable()->after('semester'); // e.g., 3.85
            $table->text('notes')->nullable()->after('gpa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['date_of_birth', 'profile_photo', 'gpa', 'notes']);
        });
    }
};
