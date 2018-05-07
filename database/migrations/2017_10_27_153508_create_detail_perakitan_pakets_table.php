<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailPerakitanPaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_perakitan_pakets', function(Blueprint $table) {

            $table->integer('id_nota')->unsigned();
            $table->foreign('id_nota')->references('id')->on("nota_perakitans")->onDelete('cascade');
            $table->integer('id_paket')->nullable();
            $table->integer('qty');
            $table->integer('no_baris');
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
        Schema::drop('detail_perakitan_pakets');
    }
}
