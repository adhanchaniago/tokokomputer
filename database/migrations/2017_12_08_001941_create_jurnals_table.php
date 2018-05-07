<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJurnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnals', function(Blueprint $table) {
            $table->increments('id');
            $table->datetime('tgl');
            $table->string('keterangan',255);
            $table->string('jenis',15);
            $table->string('no_bukti',15);
            $table->integer('id_periode')->unsigned();
            $table->foreign('id_periode')->references('id')->on("periodes")->onDelete('cascade');
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
        Schema::drop('jurnals');
    }
}
