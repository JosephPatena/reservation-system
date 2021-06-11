<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('iso_code');
            $table->string('name');
            $table->string('symbol');
            $table->string('subunit');
            $table->integer('subunit_to_unit');
            $table->boolean('symbol_first');
            $table->string('html_entity');
            $table->string('decimal_mark');
            $table->string('thousands_separator');
            $table->integer('iso_numeric');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
