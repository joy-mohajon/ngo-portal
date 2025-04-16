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
        Schema::table('reports', function (Blueprint $table) {
            // First ensure the file_path exists for existing reports
            if (!Schema::hasColumn('reports', 'file_path')) {
                $table->string('file_path')->nullable();
            }
            
            // Make sure file_path has data from pdf_path for existing records
            if (Schema::hasColumn('reports', 'pdf_path')) {
                // Run a query to copy data from pdf_path to file_path for existing records
                \DB::statement('UPDATE reports SET file_path = pdf_path WHERE file_path IS NULL AND pdf_path IS NOT NULL');
                
                // Now drop the pdf_path column
                $table->dropColumn('pdf_path');
            }
            
            // Drop images_path if it exists
            if (Schema::hasColumn('reports', 'images_path')) {
                $table->dropColumn('images_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Add back the columns if they don't exist
            if (!Schema::hasColumn('reports', 'pdf_path')) {
                $table->string('pdf_path')->nullable();
            }
            
            if (!Schema::hasColumn('reports', 'images_path')) {
                $table->string('images_path')->nullable();
            }
            
            // Copy data back from file_path to pdf_path
            \DB::statement('UPDATE reports SET pdf_path = file_path WHERE pdf_path IS NULL AND file_path IS NOT NULL');
        });
    }
};
