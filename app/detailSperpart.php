<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detailSperpart extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_sperparts';

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
    protected $fillable = ['id_nota', 'id_barang', 'qty', 'harga', 'sub_total'];

    public function nota(){
        return $this->belongsTo('App\notaService','id_nota','id');
    }
     public function barang(){
        return $this->belongsTo('App\barang','id_barang','id');
    }
}
