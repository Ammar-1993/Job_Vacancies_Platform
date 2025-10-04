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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('description');
            $table->string('location');
            $table->string('salary');
            $table->enum('type', ['Full-Time', 'Contract', 'Remote', 'Hybrid'])->default('Full-Time');
            $table->timestamps();
            $table->softDeletes();  
            
            $table->uuid('jobCategoryId');
            $table->foreign('jobCategoryId')->references('id')->on('job_categories')->onDelete('restrict');

            $table->uuid('companyId');
            $table->foreign('companyId')->references('id')->on('companies')->onDelete('restrict');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
