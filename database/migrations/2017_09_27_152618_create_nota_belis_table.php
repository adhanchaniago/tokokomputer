<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotaBelisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_belis', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_supplier')->unsigned();
            $table->foreign('id_supplier')->references('id')->on("suppliers")->onDelete('cascade');
            $table->datetime('tgl');
            $table->date('jatuh_tempo');
            $table->string('jenis_pembayaran',50)->nullable();
            $table->integer('total_harga');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on("users")->onDelete('cascade');
            $table->string('status_barang',20);
            $table->string('status_bayar',20);
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
        Schema::drop('nota_belis');
    }
}
