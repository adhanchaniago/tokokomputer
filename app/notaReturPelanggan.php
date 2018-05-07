<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notaReturPelanggan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nota_retur_pelanggans';

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
    protected $fillable = ['tgl', 'tgl_selesai', 'jenis_retur', 'id_user', 'status', 'catatan', 'nama_bank', 'no_rek', 'pengirim', 'id_customer'];
     public function detail(){
        return $this->hasMany('App\detailReturPelanggan','id_nota','id');
    }
    public function customer(){
        return $this->belongsTo('App\customer','id_customer','id');
    }
    
}
