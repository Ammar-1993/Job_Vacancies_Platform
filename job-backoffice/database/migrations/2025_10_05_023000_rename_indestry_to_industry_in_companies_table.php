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
        // Some database drivers require the doctrine/dbal package to rename columns.
        // To avoid that dependency, run a raw ALTER TABLE statement which works for MySQL/MariaDB.
        if (Schema::hasTable('companies') && Schema::hasColumn('companies', 'indestry')) {
            // Change column name from `indestry` to `industry` and keep it as VARCHAR(255)
            DB::statement('ALTER TABLE `companies` CHANGE `indestry` `industry` VARCHAR(255)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('companies') && Schema::hasColumn('companies', 'industry')) {
            DB::statement('ALTER TABLE `companies` CHANGE `industry` `indestry` VARCHAR(255)');
        }
    }
};
