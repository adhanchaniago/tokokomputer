<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\notaReturPelanggan;
use App\notaReturBarang;
use App\notaBeli;
use App\barang;
use App\customer;
use App\supplier;
use App\detailNotaBeli;
use App\detailNotaRetur;
use App\detailReturPelanggan;
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

class notaReturPelangganController extends Controller
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
            $notareturpelanggan = notaReturPelanggan::where('tgl', 'LIKE', "%$keyword%")
				->orWhere('tgl_selesai', 'LIKE', "%$keyword%")
				->orWhere('jenis_retur', 'LIKE', "%$keyword%")
				->orWhere('id_user', 'LIKE', "%$keyword%")
				->orWhere('status', 'LIKE', "%$keyword%")
				->orWhere('catatan', 'LIKE', "%$keyword%")
				->orWhere('nama_bank', 'LIKE', "%$keyword%")
				->orWhere('no_rek', 'LIKE', "%$keyword%")
				->orWhere('pengirim', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $notareturpelanggan = notaReturPelanggan::paginate($perPage);
        }

        return view('nota-retur-pelanggan.index', compact('notareturpelanggan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $customers=customer::all();
         $barangs=barang::all();
        $notaretur = notaReturPelanggan::count('id');
          if(!$notaretur)
         {   $notaretur=1;}
        else{
            $notaretur=notaReturPelanggan::max('id');
            $notaretur++;
        }
        return view('nota-retur-pelanggan.create',compact('notaretur','customers','barangs'));
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
        $id_customer=$request->get('id_customer');
        $tgl=date('Y-m-d H:i:s');
        $catatan=$request->get('catatan');
        $jenis=$request->get('jenis_retur');
        $status=$request->get('status');
        $nota=new notaReturPelanggan(
            array('tgl'=>$tgl,
                    'tgl_selesai'=>$selesai,
                    'jenis_retur'=>$jenis,
                    'id_customer'=>$id_customer,
                    'status'=>$status,
                    'id_user'=>auth::user()->id,
                    'catatan'=>$catatan
                    ));
        $nota->save();

        for($i=0;$i<sizeof($qty);$i++){
            // $sub_total=$totalretur;
            $detail=new detailReturPelanggan(array('id_nota'=>$nota->id,
                'id_barang'=>$barang[$i],
                'qty'=>$qty[$i],
                'sub_total'=>$totalretur[$i]
                ));
            $detail->save();
            if($status=='selesai'){
                  $aa=barang::whereId($barang[$i])->first();
                  $aa->stok_rusak+=$qty[$i];
                  if($jenis=="barang")
                  $aa->stok_baik-=$qty[$i];
                  $aa->save();
            }
           

        }



            if($status=='selesai'){
              // $periode=periode::where('tgl_awal','<=',date('Y-m-d'))->where('tgl_akhir','>=',date('Y-m-d'))->first();
              periode::whereStatus('aktif')->first();
              if($jenis=='uang'){
              
                
                      $jurnal=new jurnal(array('tgl'=>$tgl,
                          'keterangan'=>"Transaksi Retur Penjualan dengan Jenis Tunai",
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
                          'nomor_akun'=>107,
                          'urutan'=>2,
                          'nominal_debet'=>$grantot,
                          'nominal_kredit'=>0
                      ));
                      $detail_jurnal->save();
            }else{
                   $jurnal=new jurnal(array('tgl'=>$tgl,
                          'keterangan'=>"Transaksi Retur Penjualan dengan Pengembalian Barang",
                          'no_bukti'=>$nota->id,
                          'jenis'=>'JU',
                          'id_periode'=>$periode->id
                      ));
                      $jurnal->save();
                      
                      $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                          'nomor_akun'=>106,
                          'urutan'=>1,
                          'nominal_debet'=>0,
                          'nominal_kredit'=>$grantot
                      ));
                      $detail_jurnal->save();
                      $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                          'nomor_akun'=>107,
                          'urutan'=>2,
                          'nominal_debet'=>$grantot,
                          'nominal_kredit'=>0
                      ));
                      $detail_jurnal->save();
            }
           }
        

        Session::flash('flash_message', 'notaReturPelanggan added!');

        return redirect('nota-retur-pelanggan');
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
          $notaretur = notaReturPelanggan::findOrFail($id);
         $customers=customer::all();
         $barangs=barang::all();
         $details=$notaretur->detail;

        return view('nota-retur-pelanggan.show', compact('notaretur','details', 'customers', 'barangs'));
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
        $notaretur = notaReturPelanggan::findOrFail($id);
         $customers=customer::all();
         $barangs=barang::all();
         $details=$notaretur->detail;

        return view('nota-retur-pelanggan.edit', compact('notaretur','details', 'customers', 'barangs'));
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
        
        // $requestData = $request->all();
        
        $nota = notaReturPelanggan::findOrFail($id);
       
        // $notareturpelanggan->update($requestData);
        $barang=$request->get('barang');
        $qty=$request->get('qtyretur');
        $harsat=$request->get('pricebuy');
        $totalretur=$request->get('totalretur');
        $grantot=$request->get('grandTot');
        $pembayaran=$request->get('pembayaran');
        $selesai=$request->get('selesai');
        $id_customer=$request->get('id_customer');
        $catatan=$request->get('catatan');
        $jenis=$request->get('jenis_retur');
        $status=$request->get('status');
        $nota->update(['tgl_selesai'=>$selesai,
                    'jenis_retur'=>$jenis,
                    'id_customer'=>$id_customer,
                    'status'=>$status,
                    'id_user'=>auth::user()->id,
                    'catatan'=>$catatan
                    ]);
        $nota->save();

        for($i=0;$i<sizeof($qty);$i++){
            // $sub_total=$totalretur;
            $detail=new detailReturPelanggan(array('id_nota'=>$nota->id,
                'id_barang'=>$barang[$i],
                'qty'=>$qty[$i],
                'sub_total'=>$totalretur[$i]
                ));
            $detail->save();
            if($status=='selesai'){
                  $aa=barang::whereId($barang[$i])->first();
                  $aa->stok_rusak+=$qty[$i];
                  if($jenis=="barang")
                  $aa->stok_baik-=$qty[$i];

                  $aa->save();
            }
           

        }
        $tgl=date('Y-m-d');
        if($status=='selesai'){
              // $periode=periode::where('tgl_awal','<=',date('Y-m-d'))->where('tgl_akhir','>=',date('Y-m-d'))->first();
          periode::whereStatus('aktif')->first();
              if($jenis=='uang'){
              
                if($pembayaran=='tunai'){
                      $jurnal=new jurnal(array('tgl'=>$tgl,
                          'keterangan'=>"Transaksi Retur Penjualan dengan Jenis Tunai",
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
                          'nomor_akun'=>107,
                          'urutan'=>2,
                          'nominal_debet'=>$grantot,
                          'nominal_kredit'=>0
                      ));
                      $detail_jurnal->save();
                }
            }else{
                   $jurnal=new jurnal(array('tgl'=>$tgl,
                          'keterangan'=>"Transaksi Retur Penjualan dengan Pengembalian Barang",
                          'no_bukti'=>$nota->id,
                          'jenis'=>'JU',
                          'id_periode'=>$periode->id
                      ));
                      $jurnal->save();
                      $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                          'nomor_akun'=>106,
                          'urutan'=>1,
                          'nominal_debet'=>0,
                          'nominal_kredit'=>$grantot
                      ));
                      $detail_jurnal->save();
                      $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                          'nomor_akun'=>107,
                          'urutan'=>2,
                          'nominal_debet'=>$grantot,
                          'nominal_kredit'=>0
                      ));
                      $detail_jurnal->save();
            }
           }

        Session::flash('flash_message', 'notaReturPelanggan updated!');

        return redirect('nota-retur-pelanggan');
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
        notaReturPelanggan::destroy($id);

        Session::flash('flash_message', 'notaReturPelanggan deleted!');

        return redirect('nota-retur-pelanggan');
    }
}
