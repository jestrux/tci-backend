<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePierMigrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pier_migrations', function (Blueprint $table) {
            $table->uuid('_id');
            $table->string('name');
            $table->string('display_field');
            $table->longText('fields');
            $table->longText('settings');
            $table->timestamps();
            $table->primary("_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pier_migrations');
    }
}
