<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBarangPaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_pakets', function(Blueprint $table) {
            $table->integer('id_paket')->unsigned();
            $table->foreign('id_paket')->references('id')->on("pakets")->onDelete('cascade');
            $table->integer('id_barang')->unsigned();
            $table->foreign('id_barang')->references('id')->on("barangs")->onDelete('cascade');
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
        Schema::drop('barang_pakets');
    }
}
