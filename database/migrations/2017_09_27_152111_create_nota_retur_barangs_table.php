<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotaReturBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_retur_barangs', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_supplier')->unsigned();
            $table->foreign('id_supplier')->references('id')->on("suppliers")->onDelete('cascade');
            $table->datetime('tgl_retur');
            $table->date('tgl_selesai');
            $table->string('jenis_retur',50);
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
        Schema::drop('nota_retur_barangs');
    }
}
