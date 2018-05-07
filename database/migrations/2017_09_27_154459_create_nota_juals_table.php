<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotaJualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_juals', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_customer')->unsigned();
            $table->foreign('id_customer')->references('id')->on("customers")->onDelete('cascade');            
            $table->datetime('tgl');
            $table->string('jenis_pembayaran',50);
            $table->integer('total_harga');
            $table->string('telp',20);
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on("users")->onDelete('cascade');
            $table->string('status',20);
            $table->text('catatan')->nullable();
            $table->string('nama_bank',15)->nullable();
            $table->string('no_rek',25)->nullable();
            $table->string('pengirim',30)->nullable();
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
        Schema::drop('nota_juals');
    }
}
