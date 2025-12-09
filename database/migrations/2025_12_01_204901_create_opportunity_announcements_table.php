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
        Schema::create('opportunity_announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->json('roles'); // Store multiple roles as JSON array
            $table->text('skills')->nullable();
            $table->date('deadline')->nullable();
            $table->date('announced_at');
            $table->string('contact_person')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('document_path')->nullable(); // PDF/image attachments
            $table->enum('status', ['Open', 'Closed', 'Filled', 'Expired'])->default('Open');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunity_announcements');
    }
};
