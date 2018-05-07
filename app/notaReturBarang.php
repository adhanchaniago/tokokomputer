<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notaReturBarang extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nota_retur_barangs';

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
    protected $fillable = ['tgl_retur', 'tgl_selesai', 'jenis_retur', 'id_user','status', 'catatan', 'id_supplier'];

    public function detail(){
        return $this->hasMany('App\detailNotaRetur','id_nota','id');
    }
    public function supplier(){
        return $this->belongsTo('App\supplier','id_supplier','id');
    }
}
