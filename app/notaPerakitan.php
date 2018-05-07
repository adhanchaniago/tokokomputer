<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notaPerakitan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nota_perakitans';

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
    protected $fillable = ['tgl', 'biaya', 'id_user','status', 'catatan', 'id_nota_jual', 'id_paket'];

    public function detailbarang(){
        return $this->hasMany('App\detailPerakitanBarang','id_nota','id');
    }
    public function detailpaket(){
        return $this->hasMany('App\detailPerakitanPaket','id_nota','id');
    }
    public function user(){
        return $this->belongsTo('App\User','id_karyawan','id');
    }
    
}
