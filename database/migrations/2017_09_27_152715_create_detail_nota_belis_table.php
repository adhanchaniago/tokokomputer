<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailNotaBelisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_nota_belis', function(Blueprint $table) {
            $table->integer('id_nota')->unsigned();
            $table->foreign('id_nota')->references('id')->on("nota_belis")->onDelete('cascade');
            $table->integer('id_barang')->unsigned();
            $table->foreign('id_barang')->references('id')->on("barangs")->onDelete('cascade');
            $table->integer('qty');
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
        Schema::drop('detail_nota_belis');
    }
}
