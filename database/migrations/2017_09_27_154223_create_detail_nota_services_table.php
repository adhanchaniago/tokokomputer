<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailNotaServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_nota_services', function(Blueprint $table) {
            $table->integer('id_nota')->unsigned();
            $table->foreign('id_nota')->references('id')->on("nota_services")->onDelete('cascade');
            $table->string('barang',50);
            $table->integer('qty');
            $table->integer('sub_total');
            $table->integer('harga');
            $table->text('keterangan');
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
        Schema::drop('detail_nota_services');
    }
}
