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
use auth;

class notaBeliController extends Controller
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
        
         if(session()->has('customs')){
          session()->forget('customs');
         }
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $notabeli = notaBeli::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('tgl', 'LIKE', "%$keyword%")
				->orWhere('jatuh_tempo', 'LIKE', "%$keyword%")
				->orWhere('jenis_pembayaran', 'LIKE', "%$keyword%")
				->orWhere('total_harga', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $notabeli = notaBeli::paginate($perPage);
        }

        return view('nota-beli.index', compact('notabeli'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // $no=notaBeli::
        $barangs = barang::all();
        $notabeli = notaBeli::count('id');
        $suppliers=supplier::all();
        setlocale(LC_ALL, 'IND');
        $tgl= strftime('%d %B %Y');
        // $tgl=date('d-m')
      
        if(!$notabeli)
         {   $notabeli=1;}
        else{
            $notabeli=notaBeli::max('id');
            $notabeli++;
        }
        return view('nota-beli.create', compact('barangs','notabeli','suppliers','tgl'));
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
        $barang=$request->get('barang');
        $qty=$request->get('qty');
        $harsat=$request->get('price');
        $total=$request->get('total');
        $grantot=$request->get('grandTot');
        $pembayaran='';
        if($request->get('pembayaran'))
        $pembayaran=$request->get('pembayaran');
        $jatuhtempo=$request->get('jatuhtempo');
        $id_supplier=$request->get('id_supplier');
        $tgl=date('Y-m-d H:i:s');
        $catatan=$request->get('catatan');
        $status="belum kirim";
        $status_bayar=$request->get('jenis_bayar');
        $no_rek=NULL;
        $bank=NULL;
        $pengirim=NULL;
        if($pembayaran){
            if($pembayaran=='transfer'){
                $no_rek=$request->get('norek');
                $bank=$request->get('bank');
                $pengirim=$request->get('pengirim');
            }
        }   

        $nota=new notaBeli(array('tgl'=>$tgl,
            'jatuh_tempo'=>$jatuhtempo,
            'jenis_pembayaran'=>$pembayaran,
            'total_harga'=>$grantot,
            'id_supplier'=>$id_supplier,
            'id_user'=>auth::user()->id,
            'status_barang'=>$status,
            'status_bayar'=>$status_bayar,
            'catatan'=>$catatan,
            'nama_bank'=>$bank,
            'no_rek'=>$no_rek,
            'pengirim'=>$pengirim
        ));
        $nota->save();

        if($status_bayar=="lunas"){
             $notabayar=new notaBayar( array('tgl_bayar' => $tgl,
             'total_harga' => $grantot, 
             'id_nota_beli' => $nota->id,
             'id_user' => auth::user()->id,
             'status' => $status_bayar,
             'catatan' => $catatan,
             'jenis_pembayaran'=> $pembayaran
             ));

             $notabayar->save();
        }

        for($i=0;$i<sizeof($qty);$i++){
            $sub_total=$qty[$i]*$harsat[$i];
            $detail=new detailNotaBeli(array('id_nota'=>$nota->id,
                'id_barang'=>$barang[$i],
                'qty'=>$qty[$i],
                'sub_total'=>$sub_total,
                'harga'=>$harsat[$i]
                ));
            $detail->save();

            if($status_bayar=="lunas"){
                $barang=barang::find($barang[$i]);
                $harga_rata=(($barang->harga_beli_rata*$barang->stok_baik)+($qty[$i]*$harsat[$i]))/($qty[$i]+$barang->stok_baik);
                // $barang->harga_beli_rata=$harga_rata;
                $barang->save();
            }

        }
        $date= date('Y-m-d');
        // $periode=periode::where('tgl_awal','<=',$date)->where('tgl_akhir','>=',$date)->first();
        periode::whereStatus('aktif')->first();
        // print_r($periode);    exit();
        if($status_bayar=="lunas"){
            if($pembayaran=='tunai'){
                $jurnal=new jurnal(array('tgl'=>$date,
                    'keterangan'=>"Transaksi Pembelian Lunas Tunai",
                    'no_bukti'=>$nota->id,
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
                    'nomor_akun'=>104,
                    'urutan'=>2,
                    'nominal_debet'=>$grantot,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
            }else{
                $jurnal=new jurnal(array('tgl'=>$date,
                    'keterangan'=>"Transaksi Pembelian Lunas Transfer ke Rekening ".$bank,
                    'no_bukti'=>$nota->id,
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
        }else{
                $jurnal=new jurnal(array('tgl'=>$date,
                    'keterangan'=>"Transaksi Pembelian Kredit",
                    'no_bukti'=>$nota->id,
                    'jenis'=>'JU',
                    'id_periode'=>$periode->id
                    ));
                $jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>201,
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
        // notaBeli::create($requestData);

        Session::flash('flash_message', 'notaBeli added!');

        return redirect('nota-beli');
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
        $notabeli = notaBeli::findOrFail($id);
        $details= $notabeli->detail;
        // print_r($details);exit();

        return view('nota-beli.show', compact('notabeli','details'));
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
        $barangs = barang::all();
        $suppliers=supplier::all();
        $notabeli = notaBeli::findOrFail($id);
        $details= $notabeli->detail;

        $arrbar='';
        foreach ($details as $detail) {
            if($arrbar=='')
                $arrbar=$detail->id_barang;
            else
                $arrbar.=','.$detail->id_barang;
        }   

        return view('nota-beli.edit', compact('notabeli','barangs','suppliers','details','arrbar'));
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
        
        
        // $notabeli = notaBeli::findOrFail($id);
        $barang=$request->get('barang');
        $qty=$request->get('qty');
        $harsat=$request->get('price');
        $total=$request->get('total');
        $grantot=$request->get('grandTot');
        $pembayaran=$request->get('pembayaran');
        $jatuhtempo=$request->get('jatuhtempo');
        $id_supplier=$request->get('id_supplier');
        $tgl=date('Y-m-d');
        $catatan=$request->get('catatan');
        $status=$request->get('status');

        $status_bayar=$request->get('jenis_bayar');
        $no_rek=NULL;
        $bank=NULL;
        $pengirim=NULL;
        if($pembayaran=='transfer'){
            $no_rek=$request->get('norek');
            $bank=$request->get('bank');
            $pengirim=$request->get('pengirim');
        }

        $nota= notaBeli::whereId($id)->update([
            'tgl'=>$tgl,
            'jatuh_tempo'=>$jatuhtempo,
            'jenis_pembayaran'=>$pembayaran,
            'total_harga'=>$grantot,
            'id_supplier'=>$id_supplier,
            'id_user'=>auth::user()->id,
            'status_barang'=>"",
            'status_bayar'=>$status_bayar,
            'catatan'=>$catatan,
            'nama_bank'=>$bank,
            'no_rek'=>$no_rek,
            'pengirim'=>$pengirim
            ]);
         if($status_bayar=="lunas"){
            
            if(notaBayar::whereIdNotaBeli($id)->count()){
                 $notabayar=new notaBayar( array('tgl_bayar' => $tgl,
                 'total_harga' => $grantot, 
                 'id_nota_beli' => $id,
                 'id_user' => auth::user()->id,
                 'status' => $status_bayar,
                 'catatan' => $catatan
                 ));

                 $notabayar->save();}

                    }
        detailNotaBeli::whereIdNota($id)->delete();
       for($i=0;$i<sizeof($qty);$i++){
            $sub_total=$qty[$i]*$harsat[$i];
            $detail=new detailNotaBeli(array('id_nota'=>$id,
                'id_barang'=>$barang[$i],
                'qty'=>$qty[$i],
                'sub_total'=>$sub_total,
                'harga'=>$harsat[$i]
                ));
            $detail->save();

        }

        // $periode=periode::where('tgl_awal','>=',date('Y-m-d'))->where('tgl_akhir','<=',date('Y-m-d'))->first();
        periode::whereStatus('aktif')->first();

        // $jurnal=new jurnal(array('tgl'=>$tgl,
        //     'keterangan'=>"Transaksi Pembelian Kredit",
        //     'no_bukti'=>$nota->id,
        //     'jenis'=>'JU',
        //     'id_periode'=>$periode->id
        // ));
        $jurnal=jurnal::whereNoBukti($nota->id)->first();
        akunJurnal::whereIdJurnal($jurnal->id)->whereUrutan('1')->update(['nominal_kredit'=>$grantot]);
        akunJurnal::whereIdJurnal($jurnal->id)->whereUrutan('1')->update(['nominal_debet'=>$grantot]);
        
        // $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
        //     'nomor_akun'=>201,
        //     'urutan'=>1,
        //     'nominal_debet'=>0,
        //     'nominal_kredit'=>$grantot
        // ));
        // $detail_jurnal->save();
        // $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
        //     'nomor_akun'=>104,
        //     'urutan'=>2,
        //     'nominal_debet'=>$grantot,
        //     'nominal_kredit'=>0
        // ));
        // $detail_jurnal->save();
           
        // $notabeli->update($requestData);

        Session::flash('flash_message', 'notaBeli updated!');

        return redirect('nota-beli');
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
        notaBeli::destroy($id);

        Session::flash('flash_message', 'notaBeli deleted!');

        return redirect('nota-beli');
    }
}
