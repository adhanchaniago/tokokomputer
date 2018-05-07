<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jurnal extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'jurnals';

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
    protected $fillable = ['tgl', 'keterangan', 'jenis', 'id_periode', 'no_bukti'];

    public function detail(){
        return $this->hasMany('App\akunJurnal','id_jurnal','id');
    }

    public function getdetail($idjurnal){
        return akunJurnal::whereIdJurnal($idjurnal)->orderBy('urutan','desc')->get();
    }
    
}
