<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class XmlDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xmlData', function (Blueprint $table) {
            $table->id();
            $table->string('STRREGION');
            $table->float('AMOUNT');
            $table->float('RATE')->nullable();
            $table->string('NAME');
            $table->string('STR');
            $table->float('PAYMENT');
            $table->string('STRPHONE');
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
        //
    }
}
