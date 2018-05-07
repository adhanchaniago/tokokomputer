<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailReturPelanggansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_retur_pelanggans', function(Blueprint $table) {
            // $table->increments('id');
            $table->integer('id_nota')->unsigned();
            $table->foreign('id_nota')->references('id')->on("nota_retur_pelanggans")->onDelete('cascade');
            $table->integer('id_barang')->unsigned();
            $table->foreign('id_barang')->references('id')->on("barangs")->onDelete('cascade');
            $table->integer('qty');
            $table->integer('sub_total');
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
        Schema::drop('detail_retur_pelanggans');
    }
}
