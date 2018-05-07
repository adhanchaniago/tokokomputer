<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detailNotaRetur extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_nota_returs';

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
    protected $fillable = ['id_nota', 'id_barang', 'qty', 'sub_total'];
    public function nota(){
        return $this->belongsTo('App\notaReturBarang','id_nota','id');
    }
    public function barang(){
        return $this->belongsTo('App\barang','id_barang','id');
    }

    
}
