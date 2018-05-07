<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotaPenerimaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_penerimaans', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_karyawan')->unsigned();
            $table->foreign('id_karyawan')->references('id')->on("users")->onDelete('cascade');
            $table->integer('id_nota_beli')->unsigned()->nullable();
            $table->foreign('id_nota_beli')->references('id')->on("nota_belis")->onDelete('cascade');
            $table->integer('id_nota_retur')->unsigned()->nullable();
            $table->foreign('id_nota_retur')->references('id')->on("nota_retur_barangs")->onDelete('cascade');
            $table->string('status',20);
            $table->datetime('tgl');
            $table->text('catatan')->nullable();
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
        Schema::drop('nota_penerimaans');
    }
}
