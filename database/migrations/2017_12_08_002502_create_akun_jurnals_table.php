<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAkunJurnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akun_jurnals', function(Blueprint $table) {
            // $table->increments('id');
            $table->integer('id_jurnal')->unsigned();
            $table->foreign('id_jurnal')->references('id')->on("jurnals")->onDelete('cascade');
            $table->string('nomor_akun',3);
            $table->foreign('nomor_akun')->references('nomor')->on("akuns")->onDelete('cascade');
            $table->integer('urutan');
            $table->double('nominal_debet');
            $table->double('nominal_kredit');
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
        Schema::drop('akun_jurnals');
    }
}
