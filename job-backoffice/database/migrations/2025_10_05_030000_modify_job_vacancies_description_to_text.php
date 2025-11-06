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
        if (Schema::hasTable('job_vacancies') && Schema::hasColumn('job_vacancies', 'description')) {
            $driver = null;
            try {
                $driver = DB::getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME);
            } catch (\Throwable $e) {
            }

            // Only run MODIFY on mysql/mariadb. SQLite (tests) doesn't support this syntax.
            if (in_array($driver, ['mysql', 'mariadb'])) {
                // Use raw statement to avoid doctrine/dbal dependency. Works on MySQL/MariaDB.
                DB::statement('ALTER TABLE `job_vacancies` MODIFY `description` TEXT');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('job_vacancies') && Schema::hasColumn('job_vacancies', 'description')) {
            $driver = null;
            try {
                $driver = DB::getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME);
            } catch (\Throwable $e) {
            }

            if (in_array($driver, ['mysql', 'mariadb'])) {
                DB::statement('ALTER TABLE `job_vacancies` MODIFY `description` VARCHAR(255)');
            }
        }
    }
};
