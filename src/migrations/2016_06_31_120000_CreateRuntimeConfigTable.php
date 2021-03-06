<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creates the runtime config database schema
 */
class CreateRuntimeConfigTable extends Migration
{
    /**
     * Runs the Migration
     *
     * @return void
     */
    public function up()
    {
        $table = \Config::get('runtimeconfig.storage.table') ?? 'runtime_config';
        Schema::create($table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->longText('value');

            $table->unique('key');
        });
    }

    /**
     * Reverts the migrations
     *
     * @return void
     */
    public function down()
    {
        $table = \Config::get('runtimeconfig.storage.table') ?? 'runtime_config';
        Schema::drop($table);
    }
}
