<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\notaReturBarang;
use App\notaBeli;
use App\barang;
use App\supplier;
use App\detailNotaBeli;
use App\detailNotaRetur;
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

class notaReturBarangController extends Controller
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
            $notareturbarang = notaReturBarang::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('tgl_retur', 'LIKE', "%$keyword%")
				->orWhere('tgl_selesai', 'LIKE', "%$keyword%")
				->orWhere('jenis_retur', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $notareturbarang = notaReturBarang::paginate($perPage);
        }

        return view('nota-retur-barang.index', compact('notareturbarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $suppliers=supplier::all();
        $barangs=barang::all();
        $notaretur = notaReturBarang::count('id');
          if(!$notaretur)
         {   $notaretur=1;}
        else{
            $notaretur=notaReturBarang::max('id');
            $notaretur++;
        }
        return view('nota-retur-barang.create', compact('notaretur','barangs','suppliers'));
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
        
        $barang=$request->get('barang');
        $qty=$request->get('qtyretur');
        $harsat=$request->get('pricebuy');
        $totalretur=$request->get('totalretur');
        $grantot=$request->get('grandTot');
        $pembayaran=$request->get('pembayaran');
        $selesai=$request->get('selesai');
        $id_supplier=$request->get('id_supplier');
        $tgl=date('Y-m-d H:i:s');
        $catatan=$request->get('catatan');
        $jenis=$request->get('jenis_retur');
        $status=$request->get('status');
        $nota=new notaReturBarang(
            array('tgl_retur'=>$tgl,
                    'tgl_selesai'=>$selesai,
                    'jenis_retur'=>$jenis,
                    'id_supplier'=>$id_supplier,
                    'status'=>$status,
                    'id_user'=>auth::user()->id,
                    'catatan'=>$catatan
                    ));
        $nota->save();

        
        
        for($i=0;$i<sizeof($qty);$i++){
            // $sub_total=$totalretur;
            $detail=new detailNotaRetur(array('id_nota'=>$nota->id,
                'id_barang'=>$barang[$i],
                'qty'=>$qty[$i],
                'sub_total'=>$totalretur[$i]
                ));
            $detail->save();

          
           
                  $aa=barang::whereId($barang[$i])->first();
                  $aa->stok_rusak-=$qty[$i];
                  // $aa->stok_baik-=$qty[$i];
                  $aa->save();
              
        

        }

        if($status=='selesai'){
                // $periode=periode::where('tgl_awal','<=',date('Y-m-d'))->where('tgl_akhir','>=',date('Y-m-d'))->first();
          periode::whereStatus('aktif')->first();
                if($jenis=='uang'){
                
                  
                        $jurnal=new jurnal(array('tgl'=>$tgl,
                            'keterangan'=>"Transaksi Retur Pembelian dengan Jenis Tunai",
                            'no_bukti'=>$nota->id,
                            'jenis'=>'JU',
                            'id_periode'=>$periode->id
                            ));
                        $jurnal->save();
                        $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                            'nomor_akun'=>107,
                            'urutan'=>1,
                            'nominal_debet'=>0,
                            'nominal_kredit'=>$grantot
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
                            'keterangan'=>"Transaksi Retur Pembelian dengan Pengembalian Barang",
                            'no_bukti'=>$nota->id,
                            'jenis'=>'JU',
                            'id_periode'=>$periode->id
                        ));
                      $jurnal->save();
                        $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                            'nomor_akun'=>107,
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
           }

        Session::flash('flash_message', 'notaReturBarang added!');

        return redirect('nota-retur-barang');
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
        // $notareturbarang = notaReturBarang::findOrFail($id);
        $suppliers=supplier::all();
        $barangs=barang::all();
        $notaretur = notaReturBarang::findOrFail($id);
        $details=$notaretur->detail;

        return view('nota-retur-barang.show', compact('notaretur','suppliers','barangs','details'));
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
        $suppliers=supplier::all();
        $barangs=barang::all();
        $notaretur = notaReturBarang::findOrFail($id);
        $details=$notaretur->detail;

        return view('nota-retur-barang.edit', compact('notaretur','details','suppliers','barangs'));
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
        
        $notareturbarang = notaReturBarang::findOrFail($id);
        $details=$notareturbarang->detail;
      
          foreach ($details as $detail) {
              $aa=barang::find($detail->id_barang);
              $aa->stok_rusak+=$detail->qty;
              $aa->save();
          }
        // $notareturbarang->update($requestData);
        $barang=$request->get('barang');
        $qty=$request->get('qtyretur');
        $harsat=$request->get('pricebuy');
        $totalretur=$request->get('totalretur');
        $grantot=$request->get('grandTot');
        $pembayaran=$request->get('pembayaran');
        $selesai=$request->get('selesai');
        $id_supplier=$request->get('id_supplier');
        $tgl=date("Y-m-d H:i:s");
        $catatan=$request->get('catatan');
        $jenis=$request->get('jenis_retur');
        $status=$request->get('status');
        $notareturbarang->update(['tgl_selesai'=>$selesai,
                    'jenis_retur'=>$jenis,
                    'id_supplier'=>$id_supplier,
                    'status'=>$status,
                    'id_user'=>auth::user()->id,
                    'catatan'=>$catatan
                    ]);
        // $nota->save();
        detailNotaRetur::whereIdNota($id)->delete();
         for($i=0;$i<sizeof($qty);$i++){
            // $sub_total=$totalretur;
            $detail=new detailNotaRetur(array('id_nota'=>$id,
                'id_barang'=>$barang[$i],
                'qty'=>$qty[$i],
                'sub_total'=>$totalretur[$i]
                ));
            $detail->save();

                if($jenis=="barang"){
                  $aa=barang::whereId($barang[$i])->first();
                  $aa->stok_rusak-=$qty[$i];
                  // $aa->stok_baik-=$qty[$i];
                  $aa->save();
                }

        }

        if($status=='selesai'){
              // $periode=periode::where('tgl_awal','<=',date('Y-m-d'))->where('tgl_akhir','>=',date('Y-m-d'))->first();
          periode::whereStatus('aktif')->first();
              if($jenis=='uang'){
              
              
                      $jurnal=new jurnal(array('tgl'=>$tgl,
                          'keterangan'=>"Transaksi Retur Pembelian dengan Jenis Tunai",
                          'no_bukti'=>$notareturbarang->id,
                          'jenis'=>'JU',
                          'id_periode'=>$periode->id
                          ));
                      $jurnal->save();
                      $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                          'nomor_akun'=>107,
                          'urutan'=>1,
                          'nominal_debet'=>0,
                          'nominal_kredit'=>$grantot
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
                          'keterangan'=>"Transaksi Retur Pembelian dengan Pengembalian Barang",
                          'no_bukti'=>$notareturbarang->id,
                          'jenis'=>'JU',
                          'id_periode'=>$periode->id
                      ));
                      $jurnal->save();
                      
                      $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                          'nomor_akun'=>107,
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

        
           }

        Session::flash('flash_message', 'notaReturBarang updated!');

        return redirect('nota-retur-barang');
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
        notaReturBarang::destroy($id);

        Session::flash('flash_message', 'notaReturBarang deleted!');

        return redirect('nota-retur-barang');
    }
}
