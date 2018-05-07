<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detailPerakitanBarang extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_perakitan_barangs';

    /**
    * The database primary key value.
    *
    * @var string
    */
    // protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_nota', 'id_barang', 'no_baris_paket', 'qty', 'sub_total', 'harga', 'tipe_paket'];
    public function nota(){
        return $this->belongsTo('App\notaPenerimaan','id_nota','id');
    }
     public function barang(){
        return $this->belongsTo('App\barang','id_barang','id');
    }

    public function getqty($idnota,$baris,$idbarang){
        $paket=detailPerakitanPaket::whereNoBaris($baris)->whereIdNota($idnota)->first();
        $barang=detailPerakitanBarang::whereNoBarisPaket($baris)->whereIdNota($idnota)->whereIdBarang($idbarang)->first();
        return $barang->qty/$paket->qty;
    }
    
}
