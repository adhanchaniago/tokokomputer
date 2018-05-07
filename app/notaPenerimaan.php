<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notaPenerimaan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nota_penerimaans';

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
    protected $fillable = ['id_karyawan', 'id_nota_beli', 'status', 'tgl','status', 'catatan'];

    public function detail(){
        return $this->hasMany('App\detailPenerimaan','id_nota','id');
    }

    public function user(){
        return $this->belongsTo('App\User','id_karyawan','id');
    }


    
}
