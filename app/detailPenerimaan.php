<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detailPenerimaan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_penerimaans';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_nota', 'id_barang', 'qty'];

    public function nota(){
        return $this->belongsTo('App\notaPenerimaan','id_nota','id');
    }
     public function barang(){
        return $this->belongsTo('App\barang','id_barang','id');
    }
}
