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
            // If these columns already exist, comment them out
            if (!Schema::hasColumn('reports', 'pdf_path')) {
                $table->dropColumn(['pdf_path', 'images_path']);
            }
            
            // Add new columns for file uploads
            $table->string('title')->nullable();
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_size')->nullable();
            $table->string('file_type')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('submitted_by')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('submitted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'file_path',
                'file_name',
                'file_size',
                'file_type',
                'description',
                'submitted_by',
                'status'
            ]);
            
            // Re-add original columns if needed
            $table->string('pdf_path');
            $table->string('images_path')->nullable();
        });
    }
}; 