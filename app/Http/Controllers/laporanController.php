<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\akun;
use App\akunJurnal;
use App\jurnal;
use App\laporan;
use App\laporanAkun;
use App\periode;
use App\periodeAkun;
use Illuminate\Http\Request;
use Session;
use DB;

class laporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

        public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $laporan = laporan::where('nama', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $laporan = laporan::paginate($perPage);
        }

        return view('laporan.index', compact('laporan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('laporan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        laporan::create($requestData);

        Session::flash('flash_message', 'laporan added!');

        return redirect('laporan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $laporan = laporan::findOrFail($id);

        return view('laporan.show', compact('laporan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $laporan = laporan::findOrFail($id);

        return view('laporan.edit', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $requestData = $request->all();
        
        $laporan = laporan::findOrFail($id);
        $laporan->update($requestData);

        Session::flash('flash_message', 'laporan updated!');

        return redirect('laporan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        laporan::destroy($id);

        Session::flash('flash_message', 'laporan deleted!');

        return redirect('laporan');
    }

    public function insertlabarugi(){
        laporanAkun::where('nomor_akun','like','4%')->orWhere('nomor_akun','like','5%')->delete();
        $akuns=akun::where('Nomor','like','4%')->orWhere('Nomor','like','5%')->get();
        foreach ($akuns as $akun) {
            $laporanakun=new laporanAkun(array('id_laporan'=>"LR",
                'nomor_akun'=>$akun->nomor));
            $laporanakun->save();
        }

        return redirect('/');
    }
    public function insertneraca(){
        laporanAkun::where('nomor_akun','like','1%')->orWhere('nomor_akun','like','2%')->orWhere('Nomor','=','301')->delete();
        $akuns=akun::where('Nomor','like','1%')->orWhere('Nomor','like','2%')->orWhere('Nomor','=','301')->get();
        foreach ($akuns as $akun) {
            $laporanakun=new laporanAkun(array('id_laporan'=>"NR",
                'nomor_akun'=>$akun->nomor));
            $laporanakun->save();
        }
        return redirect('/');
    }
    public function insertaruskas(){
        laporanAkun::where('Nomor','like','1%')->delete();
        $akuns=akun::where('Nomor','like','1%')->get();
        foreach ($akuns as $akun) {
            $laporanakun=new laporanAkun(array('id_laporan'=>"AK",
                'nomor_akun'=>$akun->nomor));
            $laporanakun->save();
        }
        return redirect('/');
    }
    public function insertekuitas(){
        laporanAkun::where('Nomor','like','3%')->delete();
        $akuns=akun::where('Nomor','like','3%')->get();
        foreach ($akuns as $akun) {
            $laporanakun=new laporanAkun(array('id_laporan'=>"PE",
                'nomor_akun'=>$akun->nomor));
            $laporanakun->save();
        }
        return redirect('/');
    }

    public function insertperiodeakun(){
        $periode=periode::whereStatus('aktif')->first();
        $akuns=akun::all();
        foreach ($akuns as $akun) {
            $laporanakun=new periodeAkun(array('id_periode'=>$periode->id,
                'nomor_akun'=>$akun->nomor,
                'saldo_awal'=>0,
                'saldo_akhir'=>0
                ));
            $laporanakun->save();
        }
        return redirect('/');
    }

    public function tampiljurnal(){
        $periodes=periode::all();
        $periode=periode::whereStatus('aktif')->first();
        //$jurnal=jurnal::whereIdPeriode($periode->id)->get();
        //$jurnals=akunJurnal::whereRaw('date(created_at)<="'.$periode->tgl_akhir.'"')->whereRaw('date(created_at)>="'.$periode->tgl_awal.'"')->orderBy('id_jurnal','asc')->orderBy('urutan','desc')->get();
        $jurnals=jurnal::whereIdPeriode($periode->id)->where('keterangan','not like','%Penutupan%')->get();
        return view('laporan.jurnal', compact('jurnals','periode','periodes'));
    }

     public function tampiljurnalpost(Request $request){
        $periodes=periode::all();
        $periode=periode::whereId($request->get('periode'))->first();
        //$jurnal=jurnal::whereIdPeriode($periode->id)->get();
        //$jurnals=akunJurnal::whereRaw('date(created_at)<="'.$periode->tgl_akhir.'"')->whereRaw('date(created_at)>="'.$periode->tgl_awal.'"')->orderBy('id_jurnal','asc')->orderBy('urutan','desc')->get();
        $jurnals=jurnal::whereIdPeriode($periode->id)->get();
        return view('laporan.jurnal', compact('jurnals','periode','periodes'));
    }

    public function tampilaruskas(){
        $periodes=periode::all();
        $periode=periode::whereStatus('aktif')->first();
        $akuns=periodeAkun::whereIdPeriode($periode->id)->Where('nomor_akun','>',100)->Where('nomor_akun','<',104)->get();
        // print_r($aruskas);
        return view('laporan.aruskas', compact('akuns','periode','periodes'));
    }

    public function tampilaruskaspost(Request $request){
        $periodes=periode::all();
        $periode=periode::whereId($request->get('periode'))->first();
        $akuns=periodeAkun::whereIdPeriode($periode->id)->Where('nomor_akun','>',100)->Where('nomor_akun','<',104)->get();
        // print_r($aruskas);
        return view('laporan.aruskas', compact('akuns','periode','periodes'));
    }

    public function tampillabarugi(){
        $periodes=periode::all();
        $periode=periode::whereStatus('aktif')->first();
        $pendapatan=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','4%')->get();
        $biaya=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','5%')->get();
        // print_r($pendapatan);

        return view('laporan.labarugi', compact('pendapatan','biaya','periode','periodes'));
        
    }

    public function tampillabarugipost(Request $request){
        $periodes=periode::all();
        $periode=periode::whereId($request->get('periode'))->first();
        $pendapatan=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','4%')->get();
        $biaya=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','5%')->get();
        // print_r($pendapatan);

        return view('laporan.labarugi', compact('pendapatan','biaya','periode','periodes'));
        
    }

    public function tampilekuitas(){
        $periodes=periode::all();
        $periode=periode::whereStatus('aktif')->first();
        $ekuitas=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','3%')->get();
        $pendapatan=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','4%')->get();
        $biaya=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','5%')->get();
        $labarugi=0;
        foreach($pendapatan as $item){
            $labarugi+=$item->gettotal($item->nomor_akun,$item->id_periode);
        }
        foreach($biaya as $item){
            $labarugi-=$item->gettotal($item->nomor_akun,$item->id_periode);
        }


        
        
        return view('laporan.ekuitas', compact('ekuitas','labarugi','periode','periodes'));


    }

     public function tampilekuitaspost(Request $request){
        $periodes=periode::all();
        $periode=periode::whereId($request->get('periode'))->first();
        $ekuitas=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','3%')->get();
        $pendapatan=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','4%')->get();
        $biaya=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','5%')->get();
        $labarugi=0;
        foreach($pendapatan as $item){
            $labarugi+=$item->gettotal($item->nomor_akun,$item->id_periode);
        }
        foreach($biaya as $item){
            $labarugi-=$item->gettotal($item->nomor_akun,$item->id_periode);
        }


        
        
        return view('laporan.ekuitas', compact('ekuitas','labarugi','periode','periodes'));


    }
    public function tampilneraca(){
        $periodes=periode::all();
        $periode=periode::whereStatus('aktif')->first();
        $ekuitas=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','3%')->get();
        $pendapatan=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','4%')->get();
        $biaya=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','5%')->get();
        $modal=0;
        foreach($pendapatan as $item){
            $modal+=$item->gettotal($item->nomor_akun,$item->id_periode);
        }
        foreach($biaya as $item){
            $modal-=$item->gettotal($item->nomor_akun,$item->id_periode);
        }
        foreach($ekuitas as $item){
            if($item->nomor_akun==301)
            $modal+=$item->saldo_awal;
            else
            $modal-=$item->gettotal($item->nomor_akun,$item->id_periode);
        }
        // $modal= $pendapatan-$biaya+$ekuitas;
        $aktiva=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','1%')->get();
        $pasiva=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','2%')->get();
        return view('laporan.neraca', compact('pasiva','aktiva','modal','periode','periodes'));
    }

     public function tampilneracapost(Request $request){
        $periodes=periode::all();
        $periode=periode::whereId($request->get('periode'))->first();
        $ekuitas=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','3%')->get();
        $pendapatan=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','4%')->get();
        $biaya=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','5%')->get();
        $modal=0;
        foreach($pendapatan as $item){
            $modal+=$item->gettotal($item->nomor_akun,$item->id_periode);
        }
        foreach($biaya as $item){
            $modal-=$item->gettotal($item->nomor_akun,$item->id_periode);
        }
        foreach($ekuitas as $item){
            if($item->nomor_akun==301)
            $modal+=$item->saldo_awal;
            else
            $modal-=$item->gettotal($item->nomor_akun,$item->id_periode);
        }
        // $modal= $pendapatan-$biaya+$ekuitas;
        $aktiva=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','1%')->get();
        $pasiva=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','2%')->get();
        return view('laporan.neraca', compact('pasiva','aktiva','modal','periode','periodes'));
    }

    public function tutupperiode($id)
    {
        $laba=0;$rugi=0;
       
        $periode=periode::whereId($id)->first();
        $akuns=periodeAkun::whereIdPeriode($id)->get();
        foreach($akuns as $akun){
            $transaksi=$akun->getdetail($akun->nomor_akun);
            $saldo=$akun->saldo_awal;
            foreach($transaksi as $item){
                if($akun->akun->saldo_normal>0){
                    $saldo=$saldo+ $item->nominal_debet - $item->nominal_kredit;
                }
                else{
                    $saldo=$saldo-$item->nominal_debet+$item->nominal_kredit;
                }
            }
            if($akun->nomor_akun<1 ||$akun->nomor_akun>301){

                periodeAkun::whereIdPeriode($akun->id_periode)->whereNomorAkun($akun->nomor_akun)->update(['saldo_akhir'=>0]);
                if($akun->nomor_akun>=400&&$akun->nomor_akun<500)
                { 
                   $keterangan="Penutupan Pendapatan";
                   $debet1=$saldo;
                   $debet2=0;
                   $kredit1=0;
                   $kredit2=$saldo;
                   $bukti="T".$akun->nomor_akun;
                   
                }
                elseif($akun->nomor_akun>=500)
                {   
                    $keterangan="Penutupan Biaya";
                    $debet1=0;
                    $debet2=$saldo;
                    $kredit1=$saldo;
                    $kredit2=0;
                    $bukti="T".$akun->nomor_akun;
                
                }
                if($akun->nomor_akun>=400){
                    $jurnal=new jurnal(array('tgl'=>date('Y-m-d H:i:s'),
                        'keterangan'=>$keterangan,
                        'no_bukti'=>$bukti,
                        'jenis'=>'JP',
                        'id_periode'=>$periode->id
                        ));
                    $jurnal->save();
                    $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                        'nomor_akun'=>$akun->nomor_akun,
                        'urutan'=>1,
                        'nominal_debet'=>$debet1,
                        'nominal_kredit'=>$kredit1
                    ));
                    $detail_jurnal->save();
                    $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                        'nomor_akun'=>'000',
                        'urutan'=>2,
                        'nominal_debet'=>$debet2,
                        'nominal_kredit'=>$kredit2
                    ));
                    $detail_jurnal->save();
                }

            }
            else{

                
                periodeAkun::whereIdPeriode($akun->id_periode)->whereNomorAkun($akun->nomor_akun)->update(['saldo_akhir'=>$saldo]);
            }
        }


        $pendapatan=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','4%')->get();
        $biaya=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like','5%')->get();
        $labarugi=0;
        foreach($pendapatan as $item){
            $labarugi+=$item->gettotal($item->nomor_akun,$item->id_periode);
        }
        foreach($biaya as $item){
            $labarugi-=$item->gettotal($item->nomor_akun,$item->id_periode);
        }
         $modal=periodeAkun::whereIdPeriode($id)->whereNomorAkun('301')->first();
        periodeAkun::whereIdPeriode($id)->whereNomorAkun('301')->update(['saldo_akhir'=>$modal->saldo_awal+$labarugi]);
         $modal=periodeAkun::whereIdPeriode($id)->whereNomorAkun('301')->first();
        //$modal->save();

        // echo $modal->saldo_awal;
        // exit();
                $jurnal=new jurnal(array('tgl'=>date('Y-m-d H:i:s'),
                    'keterangan'=>"Penutupan Modal Laba Rugi",
                    'no_bukti'=>"T301",
                    'jenis'=>'JP',
                    'id_periode'=>$periode->id
                    ));
                $jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>301,
                    'urutan'=>1,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$modal->saldo_akhir
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>'000',
                    'urutan'=>2,
                    'nominal_debet'=>$modal->saldo_akhir,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
                // periodeAkun::whereIdPeriode($akun->id_periode)->whereNomorAkun('301')->update(['saldo_akhir'=>$modal->saldo_awal]);


                $jurnal=new jurnal(array('tgl'=>date('Y-m-d H:i:s'),
                    'keterangan'=>"Penutupan Modal dan Prive",
                    'no_bukti'=>"T301",
                    'jenis'=>'JP',
                    'id_periode'=>$periode->id
                    ));
                $jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>301,
                    'urutan'=>1,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>'000',
                    'urutan'=>2,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();


        $periode->update(['status'=>'selesai']);

        return redirect('periode/create');


    }


    public function tampilbukubesar(){
        $periodes=periode::all();
        $periode=periode::whereStatus('aktif')->first();
        $akuns=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','not like', '000')->get();
        $iktisar='';
        return view('laporan.bukubesar', compact('akuns','periode','periodes','iktisar'));   
    }

    public function tampilbukubesarpost(Request $request){
        $periodes=periode::all();
        $periode=periode::whereId($request->get('periode'))->first();
        $akuns=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','not like', '000')->get();
        $iktisar='';
        if($periode->status=='selesai')
        $iktisar=periodeAkun::whereIdPeriode($periode->id)->where('nomor_akun','like', '000')->first();
        return view('laporan.bukubesar', compact('akuns','periode','periodes','iktisar'));   
    }

    public function tampilbukuclosing($id){
        $periode=periode::whereId($id)->first();
        $akuns=periodeAkun::whereIdPeriode($id)->get();
        return view('laporan.bukuclosing', compact('akuns','periode'));
    }
}
