<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detailNotaService extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_nota_services';

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
    protected $fillable = ['id_nota', 'barang', 'qty', 'sub_total', 'harga', 'keterangan'];

    
}
