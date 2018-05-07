<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notaBayar extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nota_bayars';

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
    protected $fillable = ['tgl_bayar', 'total_harga', 'id_nota_beli' , 'id_user', 'status', 'catatan', 'jenis_pembayaran','no_rek','nama_bank','pengirim'];
    public function notabeli(){
        return $this->belongsTo('App\notaBeli','id_nota_beli','id');
    }
    public function user(){
        return $this->belongsTo('App\User','id_user','id');
    }
    
}
