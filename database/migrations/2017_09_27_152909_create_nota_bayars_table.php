<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotaBayarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_bayars', function(Blueprint $table) {
            $table->increments('id');
            $table->datetime('tgl_bayar');
            $table->integer('total_harga');
            $table->integer('id_nota_beli')->unsigned();
            $table->foreign('id_nota_beli')->references('id')->on("nota_belis")->onDelete('cascade');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on("users")->onDelete('cascade');
            $table->string('status',20);
            $table->text('catatan')->nullable();
            $table->string('jenis_pembayaran',50)->nullable();
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
        Schema::drop('nota_bayars');
    }
}
