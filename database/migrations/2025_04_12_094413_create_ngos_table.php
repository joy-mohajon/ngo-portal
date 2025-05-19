<?php

use App\Models\FocusArea;
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
        Schema::create('ngos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('logo')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('registration_id')->unique();
            $table->string('email')->unique();
            $table->string('website')->nullable();
            $table->string('location');
            $table->text('focus_area')->nullable(); 
             $table->text('focus_activities')->nullable(); 
            $table->string('certificate_path')->nullable();
            $table->string('established_year')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'suspended'])->default('pending');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ngos');
    }
};