<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class akun extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'akuns';

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
    protected $fillable = ['nomor', 'nama'];

    public function detail(){
        return $this->hasMany('App\akunJurnal','nomor_akun','nomor');
    }
    public function getdetail($id){
        return DB::table('vbukubesar')->where('nomor_akun','=',$id)->get();
    }

    
}
