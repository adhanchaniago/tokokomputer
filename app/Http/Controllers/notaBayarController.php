<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\notaBeli;
use App\barang;
use App\supplier;
use App\detailNotaBeli;
use App\notaBayar;
use App\akun;
use App\akunJurnal;
use App\jurnal;
use App\laporan;
use App\laporanAkun;
use App\periode;
use App\periodeAkun;
use Illuminate\Http\Request;
use Session;

class notaBayarController extends Controller
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
            $notabayar = notaBayar::where('tgl_bayar', 'LIKE', "%$keyword%")
				->orWhere('total_harga', 'LIKE', "%$keyword%")
				->orWhere('id_nota_beli', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $notabayar = notaBayar::paginate($perPage);
        }

        return view('nota-bayar.index', compact('notabayar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {   

        $notabelis=notaBeli::where('jatuh_tempo',">=",date('Y-m-d'))->where('status_bayar','!=','lunas')->get();
        return view('nota-bayar.create', compact('notabelis'));
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
        
        //$requestData = $request->all();
        $pembayaran=$request->get('pembayaran');
        $no_rek=NULL;
        $bank=NULL;
        $pengirim=NULL;
        $grantot=$request->get('total_harga');
        if($pembayaran=='transfer'){
            $no_rek=$request->get('norek');
            $bank=$request->get('bank');
            $pengirim=$request->get('pengirim');
        }
         $notabeli=notaBeli::find($request->get('id_nota_beli'));
         if($notabeli->total_harga==$request->get('total_harga')){
            $status="lunas";
         }else{
            $status="belum lunas";
         }
         $notabayar=new notaBayar( array('tgl_bayar' => date('Y-m-d H:i:s'),
         'total_harga' => $request->get('total_harga'), 
         'id_nota_beli' => $request->get('id_nota_beli'),
         'id_user' => $request->get('id_user'),
         'status' => $status,
         'catatan' => $request->get('catatan'),
         'nama_bank'=>$bank,
         'jenis_pembayaran'=>$pembayaran,
         'no_rek'=>$no_rek,
         'pengirim'=>$pengirim
         ));

         $notabayar->save();

         $sudahbayar=0;

         $notabayars=notaBayar::whereIdNotaBeli($notabeli->id)->get();
            foreach ($notabayars as $not) {
                $sudahbayar+=$not->total_harga;
            }
        if($notabeli->total_harga>=$sudahbayar){
            notaBayar::whereIdNotaBeli($notabeli->id)->update(['status'=>'lunas']);
            $notabeli->update(['status_bayar'=>'lunas']);

            $details=$notabeli->detail;

            foreach ($details as $detail) {
                $barang=barang::whereId($detail->id_barang)->first();
                // print_r($barang); exit();
                $harga_rata=(($barang->harga_beli_rata*$barang->stok_baik)+$detail->sub_total)/($detail->qty+$barang->stok_baik);
                $barang->harga_beli_rata=$harga_rata;
                $barang->save();
            }

        }

        $tgl= date('Y-m-d');
        periode::whereStatus('aktif')->first();
            if($pembayaran=='tunai'){
                $jurnal=new jurnal(array('tgl'=>$tgl,
                    'keterangan'=>"Transaksi Pembayaran Tunai Nota Beli Nomor ".$request->get('id_nota_beli'),
                    'no_bukti'=>$notabayar->id,
                    'jenis'=>'JU',
                    'id_periode'=>$periode->id
                    ));
                $jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>101,
                    'urutan'=>1,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$grantot
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>201,
                    'urutan'=>2,
                    'nominal_debet'=>$grantot,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
            }else{
                $jurnal=new jurnal(array('tgl'=>$tgl,
                    'keterangan'=>"Transaksi Pembayaran Transfer ke Rekening ".$bank." Nota Beli Nomor ".$request->get('id_nota_beli'),
                    'no_bukti'=>$notabayar->id,
                    'jenis'=>'JU',
                    'id_periode'=>$periode->id
                ));
                $jurnal->save();
                if($bank=='BNI')
                    $noakun=102;
                else
                    $noakun=103;
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>$noakun,
                    'urutan'=>1,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$grantot
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>104,
                    'urutan'=>2,
                    'nominal_debet'=>$grantot,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
            }
        
        //notaBayar::create($requestData);


        Session::flash('flash_message', 'notaBayar added!');

        return redirect('nota-bayar');
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
        $notabayar = notaBayar::findOrFail($id);

        return view('nota-bayar.show', compact('notabayar'));
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
        $notabayar = notaBayar::findOrFail($id);
         $notabelis=notaBeli::where('jatuh_tempo',">=",date('Y-m-d'))->where('status_bayar','!=','lunas')->get();
        return view('nota-bayar.edit', compact('notabayar','notabelis'));
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
        $tgl=date('Y-m-d H:i:s');
        $pembayaran=$request->get('pembayaran');
        $no_rek=NULL;
        $bank=NULL;
        $pengirim=NULL;
        if($pembayaran=='transfer'){
            $no_rek=$request->get('norek');
            $bank=$request->get('bank');
            $pengirim=$request->get('pengirim');
        }
        $notabayar = notaBayar::findOrFail($id);
         $notabeli=notaBeli::find($request->get('id_nota_beli'));
         if($notabeli->total_harga==$request->get('total_harga')){
            $status="lunas";
         }else{
            $status="belum lunas";
         }
         $notabayar->update(['tgl_bayar' => $tgl,
        'total_harga' => $request->get('total_harga'), 
        'id_nota_beli' => $request->get('id_nota_beli'),
        'id_user' => $request->get('id_user'),
        'status' => $status,
        'catatan' => $request->get('catatan'),
        'nama_bank'=>$bank,
        'jenis_pembayaran'=>$pembayaran,
        'no_rek'=>$no_rek,
        'pengirim'=>$pengirim]);
         $sudahbayar=0;

         $notabayars=notaBayar::whereIdNotaBeli($notabeli->id)->get();
            foreach ($notabayars as $not) {
                $sudahbayar+=$not->total_harga;
            }
        if($notabeli->total_harga>=$sudahbayar){
            notaBayar::whereIdNotaBeli($notabeli->id)->update(['status'=>'lunas']);
            $notabeli->update(['status_bayar'=>'lunas']);

             $details=detailNotaBeli::whereIdNota($notabeli->id)->first();

            foreach ($$details as $detail) {
                $barang=barang::find($detail->id_barang);
                $harga_rata=(($barang->harga_rata*$barang->stok_baik)+$detail->sub_total)/($detail->qty+$barang->stok_baik);
                $barang->harga_rata=$harga_rata;
                $barang->save();
            }
        }

        Session::flash('flash_message', 'notaBayar updated!');

        return redirect('nota-bayar');
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
        notaBayar::destroy($id);

        Session::flash('flash_message', 'notaBayar deleted!');

        return redirect('nota-bayar');
    }

    public function settagihan($id){
        $nota=notaBeli::find($id);
        $sudahbayar=0;
        $jum=notaBayar::whereIdNotaBeli($id)->count();
        if($jum){
            $notabayars=notaBayar::whereIdNotaBeli($id)->get();
            foreach ($notabayars as $not) {
                $sudahbayar+=$not->total_harga;
            }
        }
        echo $nota->total_harga-$sudahbayar;
    }
}
