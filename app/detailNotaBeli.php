<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detailNotaBeli extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_nota_belis';

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
    protected $fillable = ['id_nota', 'id_barang', 'qty', 'sub_total', 'harga'];

    public function nota(){
        return $this->belongsTo('App\notaBeli','id_nota','id');
    }
     public function barang(){
        return $this->belongsTo('App\barang','id_barang','id');
    }
    

    
}
