<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailJualPaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_jual_pakets', function(Blueprint $table) {
            // $table->increments('id');   
            $table->integer('id_nota')->unsigned();
            $table->foreign('id_nota')->references('id')->on("nota_juals")->onDelete('cascade');         
            $table->integer('id_paket')->unsigned()->nullable();
            $table->integer('qty');
            $table->integer('no_baris');
            $table->integer('sub_total');
            $table->integer('harga');
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
        Schema::drop('detail_jual_pakets');
    }
}
