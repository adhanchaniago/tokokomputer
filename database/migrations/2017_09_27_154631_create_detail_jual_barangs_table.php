<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailJualBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_jual_barangs', function(Blueprint $table) {
            $table->integer('id_nota')->unsigned();
            $table->foreign('id_nota')->references('id')->on("nota_juals")->onDelete('cascade');
            $table->integer('id_paket')->unsigned()->nullable();
            $table->foreign('id_paket')->references('id')->on("pakets")->onDelete('cascade');
            $table->integer('no_baris_paket');
            $table->integer('id_barang')->unsigned();
            $table->foreign('id_barang')->references('id')->on("barangs")->onDelete('cascade');
            $table->integer('qty');
            $table->string('tipe_paket',10);
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
        Schema::drop('detail_jual_barangs');
    }
}
