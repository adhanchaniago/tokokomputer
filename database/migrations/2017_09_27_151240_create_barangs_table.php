<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nama',100);
            $table->string('detail',255)->nullable();
            $table->integer('harga_jual');
            $table->integer('harga_beli');
            $table->integer('harga_beli_rata');
            $table->integer('id_jenis_barang');
            $table->integer('stok_baik');
            $table->integer('stok_rusak');
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
        Schema::drop('barangs');
    }
}
