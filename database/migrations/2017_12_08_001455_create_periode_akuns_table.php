<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePeriodeAkunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periode_akuns', function(Blueprint $table) {
            $table->integer('id_periode')->unsigned();
            $table->foreign('id_periode')->references('id')->on("periodes")->onDelete('cascade');
            $table->string('nomor_akun',3);
            $table->foreign('nomor_akun')->references('nomor')->on("akuns")->onDelete('cascade');
            $table->double('saldo_awal');
            $table->double('saldo_akhir');
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
        Schema::drop('periode_akuns');
    }
}
