<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\notaService;
use App\detailNotaService;
use App\detailSperpart;
use App\barang;
use App\customer;
use App\supplier;
use App\akun;
use App\akunJurnal;
use App\jurnal;
use App\laporan;
use App\laporanAkun;
use App\periode;
use App\periodeAkun;
use auth;
use Illuminate\Http\Request;
use Session;

class notaServiceController extends Controller
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
            $notaservice = notaService::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('detail', 'LIKE', "%$keyword%")
				->orWhere('tgl', 'LIKE', "%$keyword%")
				->orWhere('tgl_selesai', 'LIKE', "%$keyword%")
				->orWhere('total_biaya', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $notaservice = notaService::paginate($perPage);
        }

        return view('nota-service.index', compact('notaservice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $notaservice = notaService::count('id');
        $barangs = barang::all();
        $customers=customer::all();
        setlocale(LC_ALL, 'IND');
        $tgl= strftime('%d %B %Y');
        // $tgl=date('d-m')
      
        if(!$notaservice)
         {   $notaservice=1;}
        else{
            $notaservice=notaService::max('id');
            $notaservice++;
        }
        return view('nota-service.create', compact('notaservice','tgl','customers','barangs'));
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

        $sperpart=$request->get('sperpart');
        $qtysperpart=$request->get('qtysperpart');
        $hargasperpart=$request->get('pricesperpart');
        $totalsperpart=$request->get('totalsperpart');
                // echo $grantot;exit();
        $tgl_selesai=null;
        $pembayaran=$request->get('pembayaran');
        if($request->get('tgl_selesai')!=''||$request->get('tgl_selesai')!=null)
        $tgl_selesai=$request->get('tgl_selesai');
        $id_customer=$request->get('id_customer');
        $tgl=date('Y-m-d H:i:s');
        $catatan=$request->get('catatan');
        $detail='';
        $keterangan=$request->get('keterangan');
        $status=$request->get('status');
        $status_garansi=$request->get('status_garansi');;
        $no_rek=NULL;
        $bank=NULL;
        $pengirim=NULL;
        if($pembayaran=='transfer'){
            $no_rek=$request->get('norek');
            $bank=$request->get('bank');
            $pengirim=$request->get('pengirim');
        }

       $nota=new notaService(array('tgl'=>$tgl,
        'pembayaran'=>$pembayaran,
        'tgl_selesai'=>$tgl_selesai,
        'catatan'=>$catatan,
        'detail'=>$detail,
        'id_customer'=>$id_customer,
        'status'=>$status,
        'total_biaya'=>$grantot,
        'id_user'=>auth::user()->id,
        'status_garansi'=>$status_garansi,
         'nama_bank'=>$bank,
        'no_rek'=>$no_rek,
        'pengirim'=>$pengirim
        ));
       $nota->save();

       $totjasa=0;
        for($i=0;$i<sizeof($qty);$i++){
            $sub_total=$qty[$i]*$harsat[$i];
            $detail=new detailNotaService(array('id_nota'=>$nota->id,
                'barang'=>$barang[$i],
                'qty'=>$qty[$i],
                'sub_total'=>$sub_total,
                'harga'=>$harsat[$i],
                'keterangan'=>$keterangan[$i]
                ));
            $detail->save();
            $totjasa+=$sub_total;
        }

        $totsparepart=0;

        for($i=0;$i<sizeof($qtysperpart);$i++){
            $sub_total=$qty[$i]*$harsat[$i];
            $detail=new detailSperpart(array('id_nota'=>$nota->id,
                'id_barang'=>$sperpart[$i],
                'qty'=>$qtysperpart[$i],
                'sub_total'=>$totalsperpart[$i],
                'harga'=>$hargasperpart[$i]
                ));
            $detail->save();
            $totalsperpart+=$totalsperpart[$i];
        }

        if($status=='selesai'){
            for($i=0;$i<sizeof($qtysperpart);$i++){
            $barang=barang::find($sperpart[$i]);
            $sub_total=$qty[$i]*$harsat[$i];
            $detail=new detailSperpart(array('id_nota'=>$nota->id,
                'id_barang'=>$sperpart[$i],
                'qty'=>$qtysperpart[$i],
                'sub_total'=>$totalsperpart[$i],
                'harga'=>$hargasperpart[$i]
                ));
            $detail->save();
            $barang->stok_baik-=$qtysperpart[$i];
            $barang->save();

            }

            // $periode=periode::where('tgl_awal','<=',date('Y-m-d'))->where('tgl_akhir','>=',date('Y-m-d'))->first();
            periode::whereStatus('aktif')->first();
            if($pembayaran=='tunai'){
                $jurnal=new jurnal(array('tgl'=>$tgl,
                    'keterangan'=>"Transaksi Service dengan Tunai",
                    'no_bukti'=>$nota->id,
                    'jenis'=>'JU',
                    'id_periode'=>$periode->id
                    ));
                $jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>402,
                    'urutan'=>1,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$totjasa
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>101,
                    'urutan'=>2,
                    'nominal_debet'=>$grantot,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
            }else{
                $jurnal=new jurnal(array('tgl'=>$tgl,
                    'keterangan'=>"Transaksi Service dengan Transfer ke Rekening ".$bank,
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
                    'nomor_akun'=>402,
                    'urutan'=>1,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$totjasa
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>$noakun,
                    'urutan'=>2,
                    'nominal_debet'=>$grantot,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
            }

            if(sizeof($qtysperpart)>0){
             
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>106,
                    'urutan'=>3,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$grantot
                ));
                $detail_jurnal->save();
            }
               
        }


        
        // notaService::create($requestData);

        Session::flash('flash_message', 'notaService added!');

        return redirect('nota-service');
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
        $notaservice = notaService::findOrFail($id);
        $customers= customer::all();
        $detailnota=$notaservice->detailbarang;
        $sperparts=$notaservice->sperpart;
        $barangs=barang::all();

        return view('nota-service.show', compact('notaservice','customers','detailnota','barangs','sperparts'));
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

        $notaservice = notaService::findOrFail($id);
        $customers= customer::all();
        $detailnota=$notaservice->detailbarang;
        $sperparts=$notaservice->sperpart;
        $barangs=barang::all();
        // echo 

        return view('nota-service.edit', compact('notaservice','customers','detailnota','barangs','sperparts'));
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
        
        $barang=$request->get('barang');
        $qty=$request->get('qty');
        $harsat=$request->get('price');
        $total=$request->get('total');
        $grantot=$request->get('grandTot');


        $sperpart=$request->get('sperpart');
        $qtysperpart=$request->get('qtysperpart');
        $hargasperpart=$request->get('pricesperpart');
        $totalsperpart=$request->get('totalsperpart');

        // echo $grantot;exit();
        $pembayaran=$request->get('pembayaran');
        $tgl_selesai=$request->get('tgl_selesai');
        $id_customer=$request->get('id_customer');
        $tgl=date('Y-m-d H:i:s');
        $catatan=$request->get('catatan');
        $detail='';
        $keterangan=$request->get('keterangan');
        $status=$request->get('status');
        $status_garansi=$request->get('status_garansi');
        $no_rek=NULL;
        $bank=NULL;
        $pengirim=NULL;
        if($pembayaran=='transfer'){
            $no_rek=$request->get('norek');
            $bank=$request->get('bank');
            $pengirim=$request->get('pengirim');
        }


        $notaservice = notaService::findOrFail($id);
        $notaservice->update(['tgl'=>$tgl,
        'pembayaran'=>$pembayaran,
        'tgl_selesai'=>$tgl_selesai,
        'catatan'=>$catatan,
        'detail'=>$detail,
        'id_customer'=>$id_customer,
        'status'=>$status,
        'total_biaya'=>$grantot,
        'id_user'=>auth::user()->id,
        'status_garansi'=>$status_garansi,
         'nama_bank'=>$bank,
        'no_rek'=>$no_rek,
        'pengirim'=>$pengirim]);

        detailNotaService::whereIdNota($id)->delete();
        for($i=0;$i<sizeof($qty);$i++){
            $sub_total=$qty[$i]*$harsat[$i];
            $detail=new detailNotaService(array('id_nota'=>$notaservice->id,
                'barang'=>$barang[$i],
                'qty'=>$qty[$i],
                'sub_total'=>$sub_total,
                'harga'=>$harsat[$i],
                'keterangan'=>$keterangan[$i]
                ));
            $detail->save();

        }

        detailSperpart::whereIdNota($id)->delete();
        for($i=0;$i<sizeof($qty);$i++){
            $sub_total=$qty[$i]*$harsat[$i];
            $detail=new detailSperpart(array('id_nota'=>$notaservice->id,
                'id_barang'=>$sperpart[$i],
                'qty'=>$qtysperpart[$i],
                'sub_total'=>$totalsperpart[$i],
                'harga'=>$hargasperpart[$i]
                ));
            $detail->save();

        }

         if($status=='selesai'){
            for($i=0;$i<sizeof($qtysperpart);$i++){
            $barang=barang::find($sperpart[$i]);
            $sub_total=$qty[$i]*$harsat[$i];
            $detail=new detailSperpart(array('id_nota'=>$id,
                'id_barang'=>$sperpart[$i],
                'qty'=>$qtysperpart[$i],
                'sub_total'=>$totalsperpart[$i],
                'harga'=>$hargasperpart[$i]
                ));
            $detail->save();
            $barang->stok_baik-=$qtysperpart[$i];
            $barang->save();

            }


            // $periode=periode::where('tgl_awal','<=',date('Y-m-d'))->where('tgl_akhir','>=',date('Y-m-d'))->first();
            periode::whereStatus('aktif')->first();
            if($pembayaran=='tunai'){
                $jurnal=new jurnal(array('tgl'=>$tgl,
                    'keterangan'=>"Transaksi Service dengan Tunai",
                    'no_bukti'=>$nota->id,
                    'jenis'=>'JU',
                    'id_periode'=>$periode->id
                    ));
                $jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>402,
                    'urutan'=>1,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$totjasa
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>101,
                    'urutan'=>2,
                    'nominal_debet'=>$grantot,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
            }else{
                $jurnal=new jurnal(array('tgl'=>$tgl,
                    'keterangan'=>"Transaksi Service dengan Transfer ke Rekening ".$bank,
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
                    'nomor_akun'=>402,
                    'urutan'=>1,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$grantot
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>$noakun,
                    'urutan'=>2,
                    'nominal_debet'=>$grantot,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
            }

            if(sizeof($qtysperpart)>0){
             
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>106,
                    'urutan'=>3,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$grantot
                ));
                $detail_jurnal->save();
            }
        }

        Session::flash('flash_message', 'notaService updated!');

        return redirect('nota-service');
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
        notaService::destroy($id);

        Session::flash('flash_message', 'notaService deleted!');

        return redirect('nota-service');
    }
}
