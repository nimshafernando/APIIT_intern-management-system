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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('industry')->nullable()->after('name'); // Industry category
            $table->text('description')->nullable()->after('industry'); // Company description
            $table->string('city')->nullable()->after('address');
            $table->string('country')->default('Sri Lanka')->after('city');
            $table->string('contact_person_position')->nullable()->after('contact_person_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['industry', 'description', 'city', 'country', 'contact_person_position']);
        });
    }
};
