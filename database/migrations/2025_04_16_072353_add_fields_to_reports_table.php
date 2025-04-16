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
            // Check if the table already has the pdf_path column
            if (Schema::hasColumn('reports', 'pdf_path')) {
                // We have the original columns, so we need to modify them to allow NULL
                $table->string('pdf_path')->nullable()->change();
                if (Schema::hasColumn('reports', 'images_path')) {
                    $table->string('images_path')->nullable()->change();
                }
            }
            
            // Add new columns for file uploads if they don't exist
            if (!Schema::hasColumn('reports', 'title')) {
                $table->string('title')->nullable();
            }
            
            if (!Schema::hasColumn('reports', 'file_path')) {
                $table->string('file_path')->nullable();
            }
            
            if (!Schema::hasColumn('reports', 'file_name')) {
                $table->string('file_name')->nullable();
            }
            
            if (!Schema::hasColumn('reports', 'file_size')) {
                $table->string('file_size')->nullable();
            }
            
            if (!Schema::hasColumn('reports', 'file_type')) {
                $table->string('file_type')->nullable();
            }
            
            if (!Schema::hasColumn('reports', 'description')) {
                $table->text('description')->nullable();
            }
            
            if (!Schema::hasColumn('reports', 'submitted_by')) {
                $table->foreignId('submitted_by')->nullable()->constrained('users')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('reports', 'status')) {
                $table->string('status')->default('submitted');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $columns = [
                'title',
                'file_path',
                'file_name',
                'file_size',
                'file_type',
                'description',
                'submitted_by',
                'status'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('reports', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
