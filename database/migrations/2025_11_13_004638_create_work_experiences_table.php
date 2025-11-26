<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->string('company_name_ar');
            $table->string('company_name_en')->nullable();
            $table->string('position_ar');
            $table->string('position_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable(); // null means current job
            $table->boolean('is_current')->default(false);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
