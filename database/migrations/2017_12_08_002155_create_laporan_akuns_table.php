<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLaporanAkunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_akuns', function(Blueprint $table) {
            // $table->increments('id');
            $table->string('id_laporan',2);
            $table->foreign('id_laporan')->references('id')->on("laporans")->onDelete('cascade');
            $table->string('nomor_akun',3);
            $table->foreign('nomor_akun')->references('nomor')->on("akuns")->onDelete('cascade');
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
        Schema::drop('laporan_akuns');
    }
}
