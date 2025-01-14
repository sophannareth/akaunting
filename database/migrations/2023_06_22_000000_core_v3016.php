<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Settings
        Schema::table('settings', function (Blueprint $table) {
            $connection = Schema::getConnection();
            $d_table = $connection->getDoctrineSchemaManager()->listTableDetails($connection->getTablePrefix() . 'settings');

            if ($d_table->hasIndex('settings_company_id_key_unique')) {
                $table->dropUnique('settings_company_id_key_unique');
            } else {
                $table->dropUnique(['company_id', 'key']);
            }

            $table->unique(['company_id', 'key', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Settings
        Schema::table('settings', function (Blueprint $table) {
            $connection = Schema::getConnection();
            $d_table = $connection->getDoctrineSchemaManager()->listTableDetails($connection->getTablePrefix() . 'settings');

            if ($d_table->hasIndex('settings_company_id_key_deleted_at_unique')) {
                $table->dropUnique('settings_company_id_key_deleted_at_unique');
            } else {
                $table->dropUnique(['company_id', 'key', 'deleted_at']);
            }

            $table->unique(['company_id', 'key']);
        });
    }
};
