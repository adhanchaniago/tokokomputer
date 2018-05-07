<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detailReturPelanggan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_retur_pelanggans';

    /**
    * The database primary key value.
    *
    * @var string
    */
     public $incrementing = false;
    // protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_nota', 'id_barang', 'qty', 'sub_total'];

    public function nota(){
        return $this->belongsTo('App\notaReturPelanggan','id_nota','id');
    }
     public function barang(){
        return $this->belongsTo('App\barang','id_barang','id');
    }
}
