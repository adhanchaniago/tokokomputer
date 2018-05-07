<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class laporan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'laporans';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';
     public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id','nama'];


    public static function SaldoAkhir($idPeriode)
    {
        $hasil = DB::table('akuns as a')
            ->leftJoin('akun_jurnals as aj', 'ja.nomor_akun', '=', 'a.nomor')
            ->join('periode_akuns as pa', 'pa.nomor_akun', '=', 'a.nomor')
            ->join('periodes as p', 'p.id', '=', 'pa.periode_id')
            ->selectRaw('a.nomor as nomor, a.nama as NamaAkun, pa.saldo_awal + ifnull(((sum(ja.nominal_debet) - sum(ja.nominal_kredit)) * a.saldo_normal),0) AS SaldoAkhir',[])
            ->whereRaw('p.id = ?', [$idPeriode])
            ->groupBy('aj.nomor_akun','a.nama','a.nomor','pa.saldo_awal', 'a.saldo_normal')
            ->orderBy('a.nomor');
        return $hasil;
    }

    public static function PerubahanEkuitas($idPeriode)
    {
        $first = DB::table('akuns as a')->join('periode_akuns as p', 'a.nomor', '=', 'p.akun_nomor')->whereRaw('a.nomor = "000" and p.id_periode = ?',[$idPeriode])->selectRaw('a.nomor AS nomor, a.nama AS nama, p.saldo_awal AS SaldoAkhir');
        $hasil = DB::table('akuns as a')
            ->leftJoin('akun_jurnals as aj', 'aj.nomor_akun', '=', 'a.nomor')
            ->join('periode_akuns as pa', 'pa.nomor_akun', '=', 'a.nomor')
            ->join('periodes as p', 'p.id', '=', 'pa.id_periode')
            ->selectRaw('a.nomor as nomor, a.nama as NamaAkun, pa.saldo_awal + ifnull(((sum(aj.nominal_debet) - sum(aj.nominal_kredit)) * a.saldo_normal),0) AS SaldoAkhir',[])
            ->whereRaw('p.id = ?', [$idPeriode])
            ->groupBy('aj.akun_nomor','a.nama','a.nomor','pa.saldo_awal', 'a.saldo_normal')
            ->orderBy('a.nomor')
            ->join('laporan_akuns as l', 'a.nomor', '=', 'l.nomor_akun')
            ->whereRaw('l.laporan_id = "PE"',[])
            ->union($first);
        return $hasil;
    }

    public static function Neraca($idPeriode)
    {
        $hasil = DB::table('akuns as a')
            ->leftJoin('akun_jurnals as aj', 'aj.nomor_akun', '=', 'a.nomor')
            ->join('periode_akuns as pa', 'pa.nomor_akun', '=', 'a.nomor')
            ->join('periodes as p', 'p.id', '=', 'pa.id_periode')
            ->join('laporan_akuns as l', 'a.nomor', '=', 'l.nomor_akun')
            ->selectRaw('a.nomor as nomor, a.nama as NamaAkun, pa.saldo_awal + ifnull(((sum(aj.nominal_debet) - sum(aj.nominal_kredit)) * a.saldo_normal),0) AS SaldoAkhir',[])
            ->whereRaw('p.id = ? and l.id_laporan = "NR"', [$idPeriode])
            ->groupBy('aj.nomor_akun','a.nama','a.nomor','pa.saldo_awal', 'a.saldo_normal')
            ->orderBy('a.nomor');
        return $hasil;
    }

    public static function LaporanJurnal($idPeriode)
    {
        $hasil = DB::table('jurnals as j')
            ->join('akun_jurnals as aj', 'j.id', '=', 'aj.id_jurnal')
            ->join('akuns as a', 'aj.nomor_akun', '=', 'a.nomor')
            ->selectRaw('j.tanggal as tanggal, j.keterangan as keterangan, a.nama as NamaAkun, aj.nominal_debet as Debet ,aj.nominal_kredit AS Kredit, j.no_bukti AS NomorBukti',[])
            ->whereRaw('j.periode_id = ?',[$idPeriode])
            ->orderBy('j.id', 'asc')
            ->orderBy('aj.urutan', 'asc');
        return $hasil;
    }

    public static function LabaRugi($idPeriode)
    {
        $hasil = DB::table('akuns as a')
            ->leftJoin('akun_jurnals as aj', 'aj.nomor_akun', '=', 'a.nomor')
            ->join('periode_akuns as pa', 'pa.nomor_akun', '=', 'a.nomor')
            ->join('periodes as p', 'p.id', '=', 'pa.id_periode')
            ->join('laporan_akuns as l', 'a.nomor', '=', 'l.nomor_akun')
            ->selectRaw('a.nomor as nomor, a.nama as NamaAkun, pa.saldo_awal + ifnull(((sum(aj.nominal_debet) - sum(aj.nominal_kredit)) * a.saldo_normal),0) AS SaldoAkhir',[])
            ->whereRaw('p.id = ? and l.laporan_id = "LR"', [$idPeriode])
            ->groupBy('aj.nomor_akun','a.nama','a.nomor','pa.saldo_awal', 'a.saldo_normal')
            ->orderBy('a.nomor');
        return $hasil;
    }

    public static function ArusKas($idPeriode)
    {
        $hasil = DB::table('akuns as a')
            ->leftJoin('akun_jurnals as aj', 'aj.nomor_akun', '=', 'a.nomor')
            ->join('periode_akuns as pa', 'pa.nomor_akun', '=', 'a.nomor')
            ->join('periodes as p', 'p.id', '=', 'pa.id_periode')
            ->join('laporan_akuns as l', 'a.nomor', '=', 'l.nomor_akun')
            ->selectRaw('a.nomor as nomor, a.nama as NamaAkun, pa.saldo_awal + ifnull(((sum(aj.nominal_debet) - sum(aj.nominal_kredit)) * a.saldo_normal),0) AS SaldoAkhir',[])
            ->whereRaw('p.id = ? and l.id_laporan = "AK"', [$idPeriode])
            ->groupBy('aj.nomor_akun','a.nama','a.nomor','pa.saldo_awal', 'a.saldo_normal')
            ->orderBy('a.nomor');
        return $hasil;
    }

    public static function BukuBesar($idPeriode)
    {
        $hasil = DB::table('akun_jurnals as aj')
            ->join('akuns as a', 'aj.nomor_akun', '=', 'a.nomor')
            ->join('periode_akuns as p', 'p.nomor_akun', '=', 'a.nomor')
            ->join('jurnals as j', 'aj.id_jurnal', '=', 'j.id')
            ->selectRaw('aj.nomor_akun AS akun_nomor, a.nama AS NamaAkun, j.tanggal AS tanggal, j.keterangan AS keterangan, aj.nominal_debet AS nominal_debet, aj.nominal_kredit AS nominal_kredit, j.no_bukti AS no_bukti',[])
            ->orderBy('aj.nomor_akun');
        return $hasil;
    }
    
    
}
