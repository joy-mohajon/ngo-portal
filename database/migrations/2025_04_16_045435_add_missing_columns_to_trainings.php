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
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        if (!Schema::hasTable('trainings')) {
            Schema::create('trainings', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->string('location');
                $table->foreignId('organizer_id')->nullable()->constrained('users')->onDelete('set null');
                $table->unsignedBigInteger('project_id')->nullable(); // Add without constraint
                $table->dateTime('start_date');
                $table->dateTime('end_date');
                $table->integer('capacity');
                $table->dateTime('registration_deadline');
                $table->string('category', 100);
                $table->string('status');
                $table->timestamps();
            });
        } else {
            Schema::table('trainings', function (Blueprint $table) {
                if (!Schema::hasColumn('trainings', 'title')) {
                    $table->string('title')->nullable();
                }
                
                if (!Schema::hasColumn('trainings', 'description')) {
                    $table->text('description')->nullable();
                }
                
                if (!Schema::hasColumn('trainings', 'location')) {
                    $table->string('location')->nullable();
                }
                
                if (!Schema::hasColumn('trainings', 'organizer_id')) {
                    $table->foreignId('organizer_id')->nullable()->constrained('users')->onDelete('set null');
                }
                
                if (!Schema::hasColumn('trainings', 'project_id')) {
                    $table->unsignedBigInteger('project_id')->nullable(); // Add without constraint
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
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse as we're only ensuring columns exist
    }
};
