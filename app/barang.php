<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'barangs';

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
    protected $fillable = [ 'nama', 'detail', 'harga_jual', 'harga_beli', 'harga_beli_rata', 'id_jenis_barang', 'stok_baik', 'stok_rusak'];

    public function jenisbarang(){
        return $this->belongsTo('App\jenisBarang','id_jenis_barang','id');
    }

    
}
