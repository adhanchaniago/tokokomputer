<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paket extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pakets';

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
    protected $fillable = ['nama', 'detail', 'total_harga_jual', 'total_harga_asli', 'stok'];

     public function barang(){
        return $this->hasMany('App\barangPaket','id_paket','id');
    }

    
}
