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
        // Check if columns already exist (for safety)
        if (!Schema::hasColumn('skills', 'name_ar')) {
            // Add new columns
            Schema::table('skills', function (Blueprint $table) {
                $table->string('name_ar')->nullable();
                $table->string('name_en')->nullable();
            });
        }
        
        // Migrate existing name data to name_ar if name column exists
        if (Schema::hasColumn('skills', 'name') && Schema::hasColumn('skills', 'name_ar')) {
            \DB::statement('UPDATE skills SET name_ar = name WHERE name IS NOT NULL AND name != ""');
        }
        
        // Drop old name column if it exists
        if (Schema::hasColumn('skills', 'name')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back name column if it doesn't exist
        if (!Schema::hasColumn('skills', 'name')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->string('name')->nullable();
            });
        }
        
        // Migrate name_ar back to name if name_ar exists
        if (Schema::hasColumn('skills', 'name_ar')) {
            \DB::statement('UPDATE skills SET name = name_ar WHERE name IS NULL OR name = ""');
        }
        
        // Drop new columns if they exist
        if (Schema::hasColumn('skills', 'name_ar')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->dropColumn(['name_ar', 'name_en']);
            });
        }
    }
};
