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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('vacancy_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('status', ['Pending', 'CV Sent', 'Shortlisted', 'Interview', 'Rejected', 'Approved'])->default('Pending');
            $table->date('sent_date')->nullable();
            $table->text('remarks')->nullable();
            $table->string('cv_file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
