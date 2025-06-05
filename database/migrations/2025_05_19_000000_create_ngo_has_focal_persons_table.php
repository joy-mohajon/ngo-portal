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
        Schema::create('ngo_has_focal_person', function (Blueprint $table) {
            $table->id();
            $table->foreignId('focal_person_id')->constrained('focal_persons')->onDelete('cascade');
            $table->foreignId('ngo_id')->constrained('ngos')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['focal_person_id', 'ngo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ngo_has_focal_person');
    }
};