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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->float('aiGeneratedScore',2)->default(0);
            $table->timestamps();
            $table->longText('aiGeneratedFeedback')->nullable();
            $table->softDeletes();

            $table->uuid('jobVacancyId');
            $table->foreign('jobVacancyId')->references('id')->on('job_vacancies')->onDelete('restrict');

            $table->uuid('resumeId');
            $table->foreign('resumeId')->references('id')->on('resumes')->onDelete('restrict');

            $table->uuid('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('restrict');
        });

           
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
