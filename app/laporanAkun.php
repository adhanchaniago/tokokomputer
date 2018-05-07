<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class laporanAkun extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'laporan_akuns';

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
    protected $fillable = ['id_laporan', 'nomor_akun'];

    
}
