<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notaJual extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nota_juals';

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
    protected $fillable = [ 'tgl', 'jenis_pembayaran', 'total_harga', 'id_customer', 'id_user', 'telp','status', 'catatan', 'no_rek','nama_bank','pengirim'];

     public function customer(){
        return $this->belongsTo('App\customer','id_customer','id');
    }
    public function detailbarang(){
        return $this->hasMany('App\detailJualBarang','id_nota','id');
    }
     public function detailpaket(){
        return $this->hasMany('App\detailJualPaket','id_nota','id');
    }
    public function user(){
        return $this->belongsTo('App\User','id_user','id');
    }
}
