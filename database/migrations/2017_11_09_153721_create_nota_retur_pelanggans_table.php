<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotaReturPelanggansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_retur_pelanggans', function(Blueprint $table) {
            $table->increments('id');
            $table->datetime('tgl');
            $table->date('tgl_selesai');
            $table->integer('id_customer')->unsigned();
            $table->foreign('id_customer')->references('id')->on("customers")->onDelete('cascade'); 
            $table->string('jenis_retur');
            $table->integer('id_user');
            $table->string('status');
            $table->text('catatan')->nullable();
            
            $table->string('nama_bank')->nullable();
            $table->string('no_rek')->nullable();
            $table->string('pengirim')->nullable();
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
        Schema::drop('nota_retur_pelanggans');
    }
}
