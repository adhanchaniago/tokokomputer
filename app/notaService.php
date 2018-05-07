<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notaService extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nota_services';

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
    protected $fillable = ['detail', 'tgl', 'tgl_selesai', 'total_biaya', 'id_user','status', 'catatan','id_customer', 'status_garansi','no_rek','nama_bank','pengirim', 'pembayaran'];

    public function customer(){
        return $this->belongsTo('App\customer','id_customer','id');
    }
    public function detailbarang(){
        return $this->hasMany('App\detailNotaService','id_nota','id');
    }
    public function sperpart(){
        return $this->hasMany('App\detailSperpart','id_nota','id');
    }
    public function user(){
        return $this->belongsTo('App\User','id_user','id');
    }
    
}
