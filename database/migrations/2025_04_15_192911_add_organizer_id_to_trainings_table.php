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
        Schema::table('trainings', function (Blueprint $table) {
            // Add organizer_id column if it doesn't exist
            if (!Schema::hasColumn('trainings', 'organizer_id')) {
                $table->foreignId('organizer_id')->nullable()->constrained('users')->onDelete('cascade');
            }
            
            // Add other columns if they don't exist
            if (!Schema::hasColumn('trainings', 'title')) {
                $table->string('title')->nullable();
            }
            
            if (!Schema::hasColumn('trainings', 'start_date')) {
                $table->dateTime('start_date')->nullable();
            }
            
            if (!Schema::hasColumn('trainings', 'end_date')) {
                $table->dateTime('end_date')->nullable();
            }
            
            if (!Schema::hasColumn('trainings', 'capacity')) {
                $table->integer('capacity')->nullable();
            }
            
            if (!Schema::hasColumn('trainings', 'registration_deadline')) {
                $table->dateTime('registration_deadline')->nullable();
            }
            
            if (!Schema::hasColumn('trainings', 'category')) {
                $table->string('category', 100)->nullable();
            }
            
            if (!Schema::hasColumn('trainings', 'status')) {
                $table->string('status')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            // Drop columns if they exist
            $columns = [
                'organizer_id', 'title', 'start_date', 'end_date', 
                'capacity', 'registration_deadline', 'category', 'status'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('trainings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
