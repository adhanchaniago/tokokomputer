<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detailJualPaket extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_jual_pakets';

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
    protected $fillable = ['id_nota', 'id_paket', 'qty', 'sub_total', 'harga', 'no_baris'];

    public function nota(){
        return $this->belongsTo('App\notaJual','id_nota','id');
    }
     public function paket(){
        return $this->belongsTo('App\paket','id_paket','id');
    }
    public function detail(){
        return $this->hasMany('App\detailJualBarang','no_baris_paket','no_baris');
    }
    public function detailcustom($idnota,$nobaris){
        return detailJualBarang::whereIdPaket(null)->whereIdNota($idnota)->whereNoBarisPaket($nobaris)->get();
    }
    public function detailbarang($idnota,$nobaris){
        return detailJualBarang::whereIdNota($idnota)->whereNoBarisPaket($nobaris)->get();
    }
}
