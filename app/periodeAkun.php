<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class periodeAkun extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'periode_akuns';

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
    protected $fillable = ['id_periode', 'nomor_akun', 'saldo_akhir', 'saldo_awal'];

    public function periode(){
        return $this->belongsTo('App\periode','id_periode','id');
    }
    public function akun(){
        return $this->belongsTo('App\akun','nomor_akun','nomor');
    }
    public function getdetail($id){
        $periode=periode::whereStatus('aktif')->first();
        return akunJurnal::join('jurnals as j','j.id','=','akun_jurnals.id_jurnal')->where('nomor_akun','=',$id)->orderBy('tgl','asc')->get();akunJurnal::join('jurnals as j','j.id','=','akun_jurnals.id_jurnal')->where('j.keterangan','not like','%Penutupan%')->whereNomorAkun($id)->where('j.id_periode','=',$periode->id)->get();
    }
    public function gettotal($idakun,$idperiode){
        $periode=periode::whereId($idperiode)->first();
        $akun=akun::whereNomor($idakun)->first();
        $debet=akunJurnal::join('jurnals as j','j.id','=','akun_jurnals.id_jurnal')->where('j.keterangan','not like','%Penutupan%')->whereNomorAkun($idakun)->where('j.id_periode','=',$idperiode)->sum('nominal_debet');
        $kredit=akunJurnal::join('jurnals as j','j.id','=','akun_jurnals.id_jurnal')->where('j.keterangan','not like','%Penutupan%')->whereNomorAkun($idakun)->where('j.id_periode','=',$idperiode)->sum('nominal_kredit');
        $akuna=periodeAkun::whereNomorAkun($idakun)->whereIdPeriode($idperiode)->first();
        return $akuna->saldo_awal+(($debet-$kredit)*$akun->saldo_normal);
    }

    public function gettransaksi($idakun,$idperiode){
        $periode=periode::whereId($idperiode)->first();
        return akunJurnal::join('jurnals as j','j.id','=','akun_jurnals.id_jurnal')->whereNomorAkun($idakun)->where('j.id_periode','=',$idperiode)->orderBy('id_jurnal','asc')->get();
    }

    public function getpenutup($idakun,$idperiode){
        $periode=periode::find($idperiode);
        // echo $idperiode;exit();
        // $detail=akunJurnal::join('jurnals as j','j.id','=','akun_jurnals.id_jurnal')->where('j.id_periode','=',$periode->id)->where('j.keterangan','like','%Penutupan%')->where('akun_jurnals.nomor_akun','=',$idakun)->select('j.tgl as tgl,j.keterangan as keterangan','akun_jurnals.nominal_debet as nominal_debet','akun_jurnals.nominal_kredit as nominal_kredit','akun_jurnals.nomor_akun')->get();
        $detail=akunJurnal::join('jurnals as j','j.id','=','akun_jurnals.id_jurnal')->where('j.keterangan','like','%Penutupan%')->whereNomorAkun($idakun)->where('j.id_periode','=',$idperiode)->get();
        return $detail;
    }
}
