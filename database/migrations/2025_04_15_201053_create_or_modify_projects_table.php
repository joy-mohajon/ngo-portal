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
        // First add new columns
        Schema::table('projects', function (Blueprint $table) {
            // Add new columns
            $table->text('description')->nullable()->after('name');
            $table->string('location')->nullable()->after('description');
            $table->decimal('budget', 15, 2)->nullable()->after('location');
            $table->string('focus_area')->nullable()->after('budget');
        });
        
        // Then rename the name column to title (in a separate operation)
        Schema::table('projects', function (Blueprint $table) {
            DB::statement('ALTER TABLE projects CHANGE name title VARCHAR(255)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First rename title back to name
        Schema::table('projects', function (Blueprint $table) {
            DB::statement('ALTER TABLE projects CHANGE title name VARCHAR(255)');
        });
        
        // Then drop the new columns
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'location',
                'budget',
                'focus_area'
            ]);
        });
    }
};
