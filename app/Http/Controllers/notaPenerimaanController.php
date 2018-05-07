<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\notaPenerimaan;
use App\barang;
use App\suppplier;
use App\notaTerimaBarang;
use App\detailPenerimaan;
use App\notaBeli;
use App\detailNotaBeli;
use App\notaReturBarang;
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

class notaPenerimaanController extends Controller
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
            $notapenerimaan = notaPenerimaan::where('id_karyawan', 'LIKE', "%$keyword%")
				->orWhere('id_nota_beli', 'LIKE', "%$keyword%")
				->orWhere('status', 'LIKE', "%$keyword%")
				->orWhere('tgl', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $notapenerimaan = notaPenerimaan::paginate($perPage);
        }

        return view('nota-penerimaan.index', compact('notapenerimaan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $barangs = barang::all();
        $notabelis=notaBeli::where('status_barang','!=','diterima')->get();
        $notareturs=notaReturBarang::where('status','!=','diterima')->where('jenis_retur','=','barang')->get();
        $notapenerimaan = notaPenerimaan::count('id');
        setlocale(LC_ALL, 'IND');
        $tgl= strftime('%d %B %Y');

        if(!$notapenerimaan)
         {   $notapenerimaan=1;}
        else{
            $notapenerimaan=notaBeli::max('id');
            $notapenerimaan++;
        }
        return view('nota-penerimaan.create', compact('barangs', 'notapenerimaan','tgl','notabelis','notareturs'));
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
        
        // $requestData = $request->all();

        $barang=$request->get('barang');
        $qty=$request->get('qty');
         // $tgl=date('Y-m-d');
         $status="kurang";
         $notabeli=NULL;
         $notaretur=NULL;
         if($request->get('notabeli'))
         {$notabeli=$request->get('notabeli');}
        elseif($request->get('notaretur'))
            {$notaretur=$request->get('notaretur');}
         $tgl=date('Y-m-d H:i:s');
         $catatan=$request->get('catatan');

        $nota=new notaPenerimaan(array('tgl'=>$tgl,
            'id_karyawan'=>auth::user()->id,
            'id_nota_beli'=>$notabeli,
            'id_nota_retur'=>$notaretur,
            'status'=>$status,
            'catatan'=>$catatan
            ));
        $nota->save();

        for($i=0;$i<sizeof($qty);$i++){
    
            $detail=new detailPenerimaan(array('id_nota'=>$nota->id,
                'id_barang'=>$barang[$i],
                'qty'=>$qty[$i]
                ));
            $detail->save();
   
           
            if($notabeli){
                $not=notaBeli::whereId($notabeli)->first();
                $not->update(['status_barang'=>'diterima']);
                $beli=detailNotaBeli::whereIdNota($notabeli)->whereIdBarang($barang[$i])->first();
                $aa=barang::whereId($barang[$i])->first();
                $harga=(($aa->harga_beli_rata*$aa->stok_baik)+$beli->sub_total)/($aa->stok_baik+$beli->qty);
                $aa->stok_baik+=$qty[$i];
                $aa->harga_beli_rata=$harga;
                $aa->save();
                $nota->update(['status'=>'lengkap']);
            }else{
                $not=notaReturBarang::whereId($notaretur)->first();
                $not->update(['status'=>'diterima']);
                $aa=barang::whereId($barang[$i])->first();
                $aa->stok_baik+=$qty[$i];
                $aa->save();
                $nota->update(['status'=>'lengkap']);
            }

            

        }
       
        if($notaretur){
            $bukti=$notaretur;
            $dari='Nota Retur';
            $grantot=0;
            $detail=detailNotaRetur::whereIdNota($notaretur)->get();
            foreach ($detail as $det) {
                $grantot+=$det->sub_total;
            }
        }else{
            $dari="Nota Beli";
            $bukti=$notabeli;
            $grantot=$not->total_harga;
        }

        // $periode=periode::where('tgl_awal','<=',date('Y-m-d'))->where('tgl_akhir','>=',date('Y-m-d'))->first();
        $periode=periode::whereStatus('aktif')->first();
               $jurnal=new jurnal(array('tgl'=>$tgl,
                    'keterangan'=>"Transaksi Penerimaan dari ".$dari." Nomor ".$bukti,
                    'no_bukti'=>$nota->id,
                    'jenis'=>'JU',
                    'id_periode'=>$periode->id
                    ));
                $jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>104,
                    'urutan'=>1,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$grantot
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>106,
                    'urutan'=>2,
                    'nominal_debet'=>$grantot,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
            
        
        // notaPenerimaan::create($requestData);

        // Session::flash('flash_message', 'notaPenerimaan added!');

        return redirect('nota-penerimaan');
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
        $notapenerimaan = notaPenerimaan::findOrFail($id);
        $details=$notapenerimaan->detail;

        return view('nota-penerimaan.show', compact('notapenerimaan','details'));
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
        $notapenerimaan = notaPenerimaan::findOrFail($id);
        $notabelis=notaBeli::all();

        $notareturs=notaReturBarang::where('status','!=','selesai')->get();
        $details=$notapenerimaan->detail;
         $barangs = barang::all();

        return view('nota-penerimaan.edit', compact('notapenerimaan','notabelis','details','barangs','notareturs'));
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
        
        //$requestData = $request->all();
        
        $nota = notaPenerimaan::findOrFail($id);
        // $notapenerimaan->update($requestData);

         $barang=$request->get('barang');
        $qty=$request->get('qty');
         // $tgl=date('Y-m-d');

        $notabeli=NULL;
         $notaretur=NULL;
         if($request->get('notabeli'))
         {$notabeli=$request->get('notabeli');}
        elseif($request->get('notaretur'))
            {$notaretur=$request->get('notaretur');}
         $status="kurang";
         $notabeli=$request->get('notabeli');
         $tgl=date('Y-m-d H:i:s');
         $catatan=$request->get('catatan');

          $nota->update(['tgl'=>$tgl,
            'id_karyawan'=>auth::user()->id,
            'id_nota_beli'=>$notabeli,
            'id_nota_retur'=>$notaretur,
            'status'=>$status,
            'catatan'=>$catatan
            ]);

          detailPenerimaan::whereIdNota($id)->delete();

        for($i=0;$i<sizeof($qty);$i++){
    
            $detail=new detailPenerimaan(array('id_nota'=>$nota->id,
                'id_barang'=>$barang[$i],
                'qty'=>$qty[$i]
                ));
            $detail->save();


            $terima=detailPenerimaan::join('nota_penerimaans as np', 'np.id','=','detail_penerimaans.id_nota')->where('np.id_nota_beli','=',$notabeli)->where('detail_penerimaans.id_barang','=',$barang[$i])->sum('qty');
            $beli=detailNotaBeli::whereIdNota($notabeli)->whereIdBarang($barang[$i])->first();
            $sisa=$beli->qty-$terima;

            $aa=barang::whereId($barang[$i])->first();
            $aa->stok+=$qty[$i];
            $aa->save();


            if(!$sisa){
                notaBeli::whereId($notabeli)->update(['status'=>'dikirim']);
                notapenerimaan::whereIdNotaBeli($notabeli)->update(['status'=>'lengkap']);
            }

        }

        Session::flash('flash_message', 'notaPenerimaan updated!');

        return redirect('nota-penerimaan');
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
        $nota = notaPenerimaan::findOrFail($id);
        notaBeli::whereId($nota->id_nota_beli)->update(['status_barang'=>'dikirim']);
        notaPenerimaan::destroy($id);

        Session::flash('flash_message', 'notaPenerimaan deleted!');

        return redirect('nota-penerimaan');
    }

    public function loaddetail($tipe,$id){
        if($tipe=='notabeli'){
            $notabeli=notaBeli::whereId($id)->first();
            $details=$notabeli->detail;
        }else{
            $notaretur=notaReturBarang::whereId($id)->first();
             $details=$notaretur->detail;
        }
        $itung=1;
        foreach ($details as $detail) {
           
            echo "<tr  id='no".$itung."'>".
                "<td><label>" .$detail->barang->nama ."</label>".
                    "<input type='hidden' id='barang".$itung."' name='barang[]' value='".$detail->barang->id."'>".
                "</td>".
                "<td><input type='number' name='qty[]' class='qty form-control' readonly id='qty".$itung."' min='1' max='".$detail->qty."' value='".$detail->qty."'></td>".
                "<td width='5%' >
                <a style='background-color:#fffff; font-weight:bold; color:red;' id='".$itung."'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>

                </tr>";
                $itung++;
            
        }
    }

    public function loadsupplier($tipe,$id){
        if($tipe='notabeli'){
            $notabeli=notaBeli::whereId($id)->first();
            echo $notabeli->supplier->nama;
        }else{
            $notaretur=notaReturBarang::whereId($id)->first();
            echo $notaretur->supplier->nama;
        }
    }
}
