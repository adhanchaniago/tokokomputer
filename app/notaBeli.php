<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notaBeli extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nota_belis';

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
    protected $fillable = ['tgl', 'jatuh_tempo', 'jenis_pembayaran', 'total_harga', 'id_supplier', 'id_user','status_barang', 'status_bayar', 'catatan','no_rek','nama_bank','pengirim'];

    public function supplier(){
        return $this->belongsTo('App\supplier','id_supplier','id');
    }
    public function detail(){
        return $this->hasMany('App\detailNotaBeli','id_nota','id');
    }
    public function user(){
        return $this->belongsTo('App\User','id_user','id');
    }

    
}
