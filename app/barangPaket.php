<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class barangPaket extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'barang_pakets';

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
    protected $fillable = ['id_paket', 'id_barang'];

      public function barang(){
        return $this->belongsTo('App\barang','id_barang','id');
    }

    
}
