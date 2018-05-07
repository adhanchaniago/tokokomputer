<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class akunJurnal extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'akun_jurnals';

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
    protected $fillable = ['id_jurnal', 'nomor_akun', 'nominal_debet', 'nominal_kredit', 'urutan'];

    public function akun(){
        return $this->belongsTo('App\akun','nomor_akun','nomor');
    }
    public function jurnal(){
        return $this->belongsTo('App\jurnal','id_jurnal','id');
    }
    

    
}
