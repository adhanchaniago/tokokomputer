<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotaServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_services', function(Blueprint $table) {
            $table->increments('id');
            $table->text('detail');
            $table->datetime('tgl');
            $table->date('tgl_selesai')->nullable();
            $table->integer('total_biaya');
            $table->integer('id_customer')->unsigned();
            $table->foreign('id_customer')->references('id')->on("customers")->onDelete('cascade');            
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on("users")->onDelete('cascade');
            $table->string('status',20);
            $table->string('pembayaran',10);
            $table->text('catatan')->nullable();
            $table->string('nama_bank',15)->nullable();
            $table->string('no_rek',25)->nullable();
            $table->string('pengirim',30)->nullable();
            $table->string('status_garansi');
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
        Schema::drop('nota_services');
    }
}
