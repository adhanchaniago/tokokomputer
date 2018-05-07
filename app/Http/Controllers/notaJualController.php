<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\notaJual;
use App\notaPerakitan;
use App\detailPerakitanBarang;
use App\detailPerakitanPaket;
use App\detailJualBarang;
use App\detailJualPaket;
use App\customer;
use App\barang;
use App\paket;
use App\barangPaket;
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

class notaJualController extends Controller
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
            $notajual = notaJual::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('tgl', 'LIKE', "%$keyword%")
				->orWhere('jenis_pembayaran', 'LIKE', "%$keyword%")
				->orWhere('total_harga', 'LIKE', "%$keyword%")
				->orWhere('id_user', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $notajual = notaJual::paginate($perPage);
        }

        return view('nota-jual.index', compact('notajual'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

      if(session()->has('customs')){
          session()->forget('customs');
        }
        $barangs = barang::all();
        $notajual = notaJual::count('id');
        $customers=customer::all();
        $pakets=paket::all();
        setlocale(LC_ALL, 'IND');
        $tgl= strftime('%d %B %Y');
        $tgl.=date(" H:s");
        // $tgl=date('d-m')
      
        if(!$notajual)
         {   $notajual=1;}
        else{
            $notajual=notaJual::max('id');
            $notajual++;
        }
        return view('nota-jual.create', compact('barangs','notajual','customers','tgl','pakets'));
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
        
        // notaJual::create($requestData);

          if(session()->has('customs')){
            $customs=session()->get('customs');
            // print_r($customs);
          }


        $requestData = $request->all();
        $barang=$request->get('barang');
        $qty=$request->get('qty');
        $harsat=$request->get('price');
        $total=$request->get('total');
        $grantot=$request->get('grandTot');
        $pembayaran=$request->get('pembayaran');
        $telp=$request->get('telp');
        $min=$request->get('min');
        $id_customer=$request->get('id_customer');
        $tgl=date('Y-m-d H:i:s');
        $paket=$request->get('paket');
        $qtypaket=$request->get('qtypaket');
        $harsatpaket=$request->get('pricepaket');
        $status=$request->get('status');

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

        // echo $pembayaran.' '.$no_rek.' '.$bank.' '.$pengirim;exit();

        $nota=new notaJual(array(
            'tgl'=>$tgl,
            'telp'=>$telp,
            'jenis_pembayaran'=>$pembayaran,
            'total_harga'=>$grantot,
            'id_customer'=>$id_customer,
            'id_user'=>auth::user()->id,
            'status'=>$status,
            'catatan'=>'',
            'nama_bank'=>$bank,
            'no_rek'=>$no_rek,
            'pengirim'=>$pengirim
            ));
        $nota->save();

        $hpp=0;
        $baris=0;
        $rp=0;
        for($i=0;$i<sizeof($qty);$i++){

            $sub_total=$qty[$i]*$harsat[$i];
            $detail=new detailJualBarang(array('id_nota'=>$nota->id,
                'id_barang'=>$barang[$i],
                'qty'=>$qty[$i],
                'sub_total'=>$sub_total,
                'harga'=>$harsat[$i],
                'no_baris_paket'=>0,
                'tipe_paket'=>'satuan',
                'id_paket'=>null,     
                ));
            $detail->save();
            $rp+=$sub_total;
            if($status=="lunas"){           
              $bar=barang::find($barang[$i]);
              echo $bar->stok_baik.' ';
              $bar->stok_baik-=$qty[$i];
              echo $bar->stok_baik.' ';
              $bar->save();
              $hpp+=$bar->harga_beli_rata*$qty[$i];
            } 
        }
        // exit();
        // if($status=="lunas" && sizeof($qty)>0){
        //     $detailbarangs=detailJualBarang::whereIdNota($nota->id)->whereNoBarisPaket('0')->get();

        //  foreach ($detailbarangs as $bar) {
        //    $barang=barang::find($bar->id_barang);
        //    $barang->stok_baik-=$bar->qty;
        //    $barang->save();
        //  }
        // }

         $keys=null;
        if(session()->has('customs')){
          $customs=session()->get('customs');
          $keys=array_keys($customs);
        }
        $hitung=1;
        for($i=0;$i<sizeof($qtypaket);$i++){
            $sub_total=$qtypaket[$i]*$harsatpaket[$i];
             if($keys){
              for($aa=1;$aa<=sizeof($qtypaket);$aa++){
                $hitung=$aa;
                if(in_array($hitung, $keys)){
                  $hitung++;
                  // continue;
                }else{
                  break;
                }
              }
            }

            // $id_pak=null;
            
            // if($paket[$i]!='custom')
                $id_pak=$paket[$i];
            if($id_pak!="custom"){
            $detail=new detailJualPaket(array('id_nota'=>$nota->id,
                'no_baris'=>$hitung,
                'id_paket'=>$id_pak,
                'qty'=>$qtypaket[$i],
                'sub_total'=>$sub_total,
                'harga'=>$harsatpaket[$i]
                ));
            $detail->save();
            $rp+=$detail->sub_total;
            
              $detailbarangs=barangPaket::whereIdPaket($id_pak)->get();
              foreach ($detailbarangs as $value) {
                $barang=barang::find($value->id_barang);
                 $detail=new detailJualBarang(array('id_nota'=>$nota->id,
                      'id_barang'=>$barang->id,
                      'no_baris_paket'=>$hitung,
                      'tipe_paket'=>'default',
                      'id_paket'=>$value->id_paket,
                      'qty'=>$qtypaket[$i],
                      'sub_total'=>$barang->harga_jual*$qtypaket[$i],
                      'harga'=>$barang->harga_jual
                    ));
                 $detail->save();
              }
            }
           
           $hitung++;
           

        }

        $hitung=1;
        if(session()->has('customs')){

            $customs=session()->get('customs');
            $keys=array_keys($customs);
            $hitung=1;
            for($a=0;$a<sizeof($qtypaket);$a++) {
               
                
            if(in_array($hitung, $keys)){
              
            $detail=new detailJualPaket(array('id_nota'=>$nota->id,
                'id_barang'=>null,
                'qty'=>$qtypaket[$a],
                'no_baris'=>$hitung,
                'sub_total'=>$customs[$hitung]['jual']*$qtypaket[$a],
                'harga'=>$customs[$hitung]['jual'],
                ));
            $detail->save();
            $rp+=$detail->sub_total;
            
            $custom=$customs[$hitung];
                for($i=0;$i<sizeof($custom['barang']);$i++) {
                      $id_barang=1;
                      if($custom['barang'][$i]&&$custom['barang'][$i]!='NaN')
                      $id_barang=$custom['barang'][$i];
                    $detail=new detailJualBarang(array('id_nota'=>$nota->id,
                      'id_barang'=>$id_barang,
                      'no_baris_paket'=>$hitung,
                      'tipe_paket'=>'custom',
                      'qty'=>$custom['qty'][$i]*$qtypaket[$a],
                      'sub_total'=>$custom['qty'][$i]*$custom['harga'][$i]*$qtypaket[$a],
                      'harga'=>$custom['harga'][$i]
                    ));
                    $detail->save();
               }
             }
            $hitung++;
                
            
            }

            // session()->forget('customs');
            $nota->total_harga=$rp;
            $nota->save();
        }

        if($status=='lunas' && sizeof($qtypaket)>0){
        $notarakit=new notaPerakitan(array('tgl'=>$tgl,
            'id_nota_jual'=>$nota->id,
            'biaya'=>0,
            'catatan'=>'',
            'id_user'=>auth::user()->id,
            'status'=>$status
            ));
        $notarakit->save();




        $keys=null;
        if(session()->has('customs')){
          $customs=session()->get('customs');
          $keys=array_keys($customs);
        }
        $hitung=1;
        for($i=0;$i<sizeof($qtypaket);$i++){
            $sub_total=$qtypaket[$i]*$harsatpaket[$i];
             if($keys){
              for($aa=1;$aa<=sizeof($qtypaket);$aa++){
                $hitung=$aa;
                if(in_array($hitung, $keys)){
                  $hitung++;
                  // continue;
                }else{
                  break;
                }
              }
            }

            // $id_pak=null;
            $rp=0;
            // if($paket[$i]!='custom')
                $id_pak=$paket[$i];
                if($id_pak!='custom'){
            $detail=new detailPerakitanPaket(array('id_nota'=>$notarakit->id,
                'no_baris'=>$hitung,
                'id_paket'=>$id_pak,
                'qty'=>$qtypaket[$i],
                'sub_total'=>$harsatpaket[$i],
                'harga'=>$sub_total
                ));
            $detail->save();
            $rp+=$detail->harga;
            
              $detailbarangs=barangPaket::whereIdPaket($id_pak)->get();
              foreach ($detailbarangs as $value) {
                $barang=barang::find($value->id_barang);
                 $detail=new detailPerakitanBarang(array('id_nota'=>$notarakit->id,
                      'id_barang'=>$barang->id,
                      'no_baris_paket'=>$hitung,
                      'tipe_paket'=>'default',
                      'id_paket'=>$value->id_paket,
                      'qty'=>$qtypaket[$i],
                      'sub_total'=>$barang->harga_jual*$qtypaket[$i],
                      'harga'=>$barang->harga_jual
                    ));
                 $detail->save();
                 $hpp+=$barang->harga_beli_rata*$qtypaket;
                 $barang->stok_baik-=$qtypaket[$i];
                $barang->save();
              }
            }
           
           $hitung++;
           
        }

        $hitung=1;
        if(session()->has('customs')){

            $customs=session()->get('customs');
            $keys=array_keys($customs);
            $hitung=1;
            for($a=0;$a<sizeof($qtypaket);$a++) {
               
                
            if(in_array($hitung, $keys)){
              
            $detail=new detailPerakitanPaket(array('id_nota'=>$notarakit->id,
                'id_barang'=>null,
                'qty'=>$qtypaket[$a],
                'no_baris'=>$hitung,
                'harga'=>$customs[$hitung]['jual']
                ));
            $detail->save();
            $rp+=$detail->harga;
            
            $custom=$customs[$hitung];
                for($i=0;$i<sizeof($custom['barang']);$i++) {
                      $id_barang=1;
                      if($custom['barang'][$i]&&$custom['barang'][$i]!='NaN')
                      $id_barang=$custom['barang'][$i];

                    $barang=barang::find($id_barang);
                    $detail=new detailPerakitanBarang(array('id_nota'=>$notarakit->id,
                      'id_barang'=>$id_barang,
                      'no_baris_paket'=>$hitung,
                      'tipe_paket'=>'custom',
                      'qty'=>$custom['qty'][$i]*$qtypaket[$a],
                      'sub_total'=>$custom['qty'][$i]*$custom['harga'][$i]*$qtypaket[$a],
                      'harga'=>$custom['harga'][$i]
                    ));
                    $detail->save();
                    $hpp+=$barang->harga_beli_rata*$qtypaket[$a]*$custom['qty'][$i];
                    $barang->stok_baik-=$custom['qty'][$i]*$qtypaket[$a];
                    $barang->save();
               }
             }
            $hitung++;
                
              
            }

            
            
        }

          

        $notarakit->biaya=$rp;
        $notarakit->save();

      }


      if($status=='lunas'){
        $date= date('Y-m-d');
        // $periode=periode::where('tgl_awal','<=',$date)->where('tgl_akhir','>=',$date)->first();
       $periode= periode::whereStatus('aktif')->first();
          if($pembayaran=='tunai'){
                $jurnal=new jurnal(array('tgl'=>$tgl,
                    'keterangan'=>"Transaksi Penjualan Tunai",
                    'no_bukti'=>$nota->id,
                    'jenis'=>'JU',
                    'id_periode'=>$periode->id
                    ));
                $jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>106,
                    'urutan'=>4,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$hpp
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>101,
                    'urutan'=>1,
                    'nominal_debet'=>$grantot,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
          }else{
                $jurnal=new jurnal(array('tgl'=>$tgl,
                    'keterangan'=>"Transaksi Penjualan Transfer ke Rekening ".$bank,
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
                    'nomor_akun'=>106,
                    'urutan'=>4,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$hpp
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>$noakun,
                    'urutan'=>1,
                    'nominal_debet'=>$grantot,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
          }

                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>401,
                    'urutan'=>2,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$grantot
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>501,
                    'urutan'=>3,
                    'nominal_debet'=>$hpp,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
      }

      session()->forget('customs');

        Session::flash('flash_message', 'notaJual added!');

        return redirect('nota-jual');
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
        $notajual = notaJual::findOrFail($id);
        $barangs= detailJualBarang::whereIdNota($id)->whereNoBarisPaket('0')->get();

        $pakets=$notajual->detailpaket;
        // echo $pakets->count();exit();

        return view('nota-jual.show', compact('notajual','barangs','pakets'));
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
        $barangs=barang::all();
        $notajual = notaJual::findOrFail($id);
        $detailpakets=$notajual->detailpaket;
        $aaa=$notajual->detailpaket;
        // $aaa->orderBy('no_baris','asc');
        $detailbarangs=detailJualBarang::whereIdNota($id)->whereNoBarisPaket('0')->get();
        $customers=customer::all();
        $pakets=paket::all();

        if(session()->has('customs')){
          session()->forget('customs');
        }

        // foreach ($detailpakets as $pak) {
        //   // print_r($pak->id_nota);
        //   if($pak->id_paket==null){
        //   $aa=$pak->detailcustom($pak->id_nota,$pak->no_baris);
        //   foreach ($aa as $a) {
        //     echo $a->no_baris_paket.' ';break;
        //   }
           
        //   }
        // } 
        // exit();

        return view('nota-jual.edit', compact('notajual','detailpakets','detailbarangs','barangs','customers','pakets'));
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
        
        $nota = notaJual::findOrFail($id);
        // $notajual->update($requestData);

           if(session()->has('customs')){
            $customs=session()->get('customs');
            echo sizeof($customs);

          }




        $requestData = $request->all();
        $barang=$request->get('barang');
        $qty=$request->get('qty');
        $harsat=$request->get('price');
        $total=$request->get('total');
        $grantot=$request->get('grandTot');
        $pembayaran=$request->get('pembayaran');
        $telp=$request->get('telp');
        $min=$request->get('min');
        $id_customer=$request->get('id_customer');
        $tgl=date('Y-m-d H:i:s');
        $paket=$request->get('paket');
        $qtypaket=$request->get('qtypaket');
        $harsatpaket=$request->get('pricepaket');
        $status=$request->get('status');

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

        // echo sizeof($qtypaket);


        $nota->update([
            'telp'=>$telp,
            'jenis_pembayaran'=>$pembayaran,
            'total_harga'=>$grantot,
            'id_customer'=>$id_customer,
            'id_user'=>auth::user()->id,
            'status'=>$status,
            'catatan'=>'',
            'nama_bank'=>$bank,
            'no_rek'=>$no_rek,
            'pengirim'=>$pengirim
            ]);
        $nota->save();


        $baris=0;
        $rp=0;
        detailJualBarang::whereIdNota($id)->delete();
        detailJualPaket::whereIdNota($id)->delete();
        // exit();
        $hpp=0;
        for($i=0;$i<sizeof($qty);$i++){

            $sub_total=$qty[$i]*$harsat[$i];
            $detail=new detailJualBarang(array('id_nota'=>$nota->id,
                'id_barang'=>$barang[$i],
                'qty'=>$qty[$i],
                'sub_total'=>$sub_total,
                'harga'=>$harsat[$i],
                'no_baris_paket'=>0,
                'tipe_paket'=>'satuan',
                'id_paket'=>null,     
                ));
            $detail->save();
            $rp+=$sub_total;
          if($status=="lunas"){           
             $bar=barang::findOrFail($barang[$i]);
             $bar->stok_baik-=$qty[$i];
             $hpp+=$qty[$i]*$bar->harga_beli_rata;
             echo $bar->stok_baik.' '.$qty[$i];
             $bar->save();
           // exit();
          } 
        }
        
       // exit();

         $keys=null;
        if(session()->has('customs')){
          $customs=session()->get('customs');
          $keys=array_keys($customs);
        }
        $hitung=1;
        for($i=0;$i<sizeof($qtypaket);$i++){
            $sub_total=$qtypaket[$i]*$harsatpaket[$i];
             if($keys){
              for($aa=1;$aa<=sizeof($qtypaket);$aa++){
                $hitung=$aa;
                if(in_array($hitung, $keys)){
                  $hitung++;
                  // continue;
                }else{
                  break;
                }
              }
            }

            // $id_pak=null;
            
            // if($paket[$i]!='custom')
                $id_pak=$paket[$i];
            if($id_pak!="custom"){
            $detail=new detailJualPaket(array('id_nota'=>$nota->id,
                'no_baris'=>$hitung,
                'id_paket'=>$id_pak,
                'qty'=>$qtypaket[$i],
                'sub_total'=>$sub_total,
                'harga'=>$harsatpaket[$i]
                ));
            $detail->save();
            $rp+=$detail->sub_total;
            
              $detailbarangs=barangPaket::whereIdPaket($id_pak)->get();
              foreach ($detailbarangs as $value) {
                $barang=barang::find($value->id_barang);
                 $detail=new detailJualBarang(array('id_nota'=>$nota->id,
                      'id_barang'=>$barang->id,
                      'no_baris_paket'=>$hitung,
                      'tipe_paket'=>'default',
                      'id_paket'=>$value->id_paket,
                      'qty'=>$qtypaket[$i],
                      'sub_total'=>$barang->harga_jual*$qtypaket[$i],
                      'harga'=>$barang->harga_jual
                    ));
                 $detail->save();
              }
            }
           
           $hitung++;
           

        }

        $hitung=1;
        if(session()->has('customs')){

            $customs=session()->get('customs');
            $keys=array_keys($customs);
            $hitung=1;
            for($a=0;$a<sizeof($qtypaket);$a++) {
               
                
            if(in_array($hitung, $keys)){
              
            $detail=new detailJualPaket(array('id_nota'=>$nota->id,
                'id_barang'=>null,
                'qty'=>$qtypaket[$a],
                'no_baris'=>$hitung,
                'sub_total'=>$customs[$hitung]['jual']*$qtypaket[$a],
                'harga'=>$customs[$hitung]['jual'],
                ));
            $detail->save();
            $rp+=$detail->sub_total;
            
            $custom=$customs[$hitung];
                for($i=0;$i<sizeof($custom['barang']);$i++) {
                      $id_barang=1;
                      if($custom['barang'][$i]&&$custom['barang'][$i]!='NaN')
                      $id_barang=$custom['barang'][$i];
                    $detail=new detailJualBarang(array('id_nota'=>$nota->id,
                      'id_barang'=>$id_barang,
                      'no_baris_paket'=>$hitung,
                      'tipe_paket'=>'custom',
                      'qty'=>$custom['qty'][$i]*$qtypaket[$a],
                      'sub_total'=>$custom['qty'][$i]*$custom['harga'][$i]*$qtypaket[$a],
                      'harga'=>$custom['harga'][$i]
                    ));
                    $detail->save();
               }
             }
            $hitung++;
                
            
            }

            // session()->forget('customs');
            $nota->total_harga=$rp;
            $nota->save();
        }

        if($status=='lunas' && sizeof($qtypaket)>0){
        $notarakit=new notaPerakitan(array('tgl'=>$tgl,
            'id_nota_jual'=>$nota->id,
            'biaya'=>0,
            'catatan'=>'',
            'id_user'=>auth::user()->id,
            'status'=>"menunggu"
            ));
        $notarakit->save();



        $keys=null;
        if(session()->has('customs')){
          $customs=session()->get('customs');
          $keys=array_keys($customs);
        }
        $hitung=1;
        for($i=0;$i<sizeof($qtypaket);$i++){
            $sub_total=$qtypaket[$i]*$harsatpaket[$i];
             if($keys){
              for($aa=1;$aa<=sizeof($qtypaket);$aa++){
                $hitung=$aa;
                if(in_array($hitung, $keys)){
                  $hitung++;
                  // continue;
                }else{
                  break;
                }
              }
            }

            // $id_pak=null;
            $rp=0;
            // if($paket[$i]!='custom')
                $id_pak=$paket[$i];
                if($id_pak!='custom'){
            $detail=new detailPerakitanPaket(array('id_nota'=>$notarakit->id,
                'no_baris'=>$hitung,
                'id_paket'=>$id_pak,
                'qty'=>$qtypaket[$i],
                'sub_total'=>$harsatpaket[$i],
                'harga'=>$sub_total
                ));
            $detail->save();
            $rp+=$detail->harga;
            
              $detailbarangs=barangPaket::whereIdPaket($id_pak)->get();
              foreach ($detailbarangs as $value) {
                $barang=barang::find($value->id_barang);
                 $detail=new detailPerakitanBarang(array('id_nota'=>$notarakit->id,
                      'id_barang'=>$barang->id,
                      'no_baris_paket'=>$hitung,
                      'tipe_paket'=>'default',
                      'id_paket'=>$value->id_paket,
                      'qty'=>$qtypaket[$i],
                      'sub_total'=>$barang->harga_jual*$qtypaket[$i],
                      'harga'=>$barang->harga_jual
                    ));
                 $detail->save();
                 $hpp+=$qtypaket[$i]*$barang->harga_beli_rata;
                 $barang->stok_baik-=$qtypaket[$i];
                $barang->save();
              }
            }
           
           $hitung++;
           
        }

        $hitung=1;
        if(session()->has('customs')){

            $customs=session()->get('customs');
            $keys=array_keys($customs);
            $hitung=1;
            for($a=0;$a<sizeof($qtypaket);$a++) {
               
                
            if(in_array($hitung, $keys)){
              
            $detail=new detailPerakitanPaket(array('id_nota'=>$notarakit->id,
                'id_barang'=>null,
                'qty'=>$qtypaket[$a],
                'no_baris'=>$hitung,
                'harga'=>$customs[$hitung]['jual']
                ));
            $detail->save();
            $rp+=$detail->harga;
            
            $custom=$customs[$hitung];
                for($i=0;$i<sizeof($custom['barang']);$i++) {
                      $id_barang=1;
                      if($custom['barang'][$i]&&$custom['barang'][$i]!='NaN')
                      $id_barang=$custom['barang'][$i];

                      $barang=barang::find($id_barang);
                    $detail=new detailPerakitanBarang(array('id_nota'=>$notarakit->id,
                      'id_barang'=>$id_barang,
                      'no_baris_paket'=>$hitung,
                      'tipe_paket'=>'custom',
                      'qty'=>$custom['qty'][$i]*$qtypaket[$a],
                      'sub_total'=>$custom['qty'][$i]*$custom['harga'][$i]*$qtypaket[$a],
                      'harga'=>$custom['harga'][$i]
                    ));
                    $detail->save();
                    $hpp+=$custom['qty'][$i]*$qtypaket[$a]*$barang->harga_beli_rata;
                    $barang->stok_baik-=$custom['qty'][$i]*$qtypaket[$a];
                    $barang->save();
               }
             }
            $hitung++;
                
              
            }

            
            
        }


       



      

        $notarakit->biaya=$rp;
        $notarakit->save();

      }


       if($status=='lunas'){
          // $periode=periode::where('tgl_awal','<=',date('Y-m-d'))->where('tgl_akhir','>=',date('Y-m-d'))->first();
        $periode=periode::whereStatus('aktif')->first();
          if($pembayaran=='tunai'){
                $jurnal=new jurnal(array('tgl'=>$tgl,
                    'keterangan'=>"Transaksi Penjualan Tunai",
                    'no_bukti'=>$nota->id,
                    'jenis'=>'JU',
                    'id_periode'=>$periode->id
                    ));
                $jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>106,
                    'urutan'=>4,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$grantot
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>101,
                    'urutan'=>1,
                    'nominal_debet'=>$grantot,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
          }else{
                $jurnal=new jurnal(array('tgl'=>$tgl,
                    'keterangan'=>"Transaksi Penjualan Transfer ke Rekening ".$bank,
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
                    'nomor_akun'=>106,
                    'urutan'=>4,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$grantot
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>$noakun,
                    'urutan'=>1,
                    'nominal_debet'=>$grantot,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
          }

                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>401,
                    'urutan'=>2,
                    'nominal_debet'=>0,
                    'nominal_kredit'=>$grantot
                ));
                $detail_jurnal->save();
                $detail_jurnal=new akunJurnal(array('id_jurnal'=>$jurnal->id,
                    'nomor_akun'=>501,
                    'urutan'=>3,
                    'nominal_debet'=>$grantot,
                    'nominal_kredit'=>0
                ));
                $detail_jurnal->save();
      }

      session()->forget('customs');

        Session::flash('flash_message', 'notaJual updated!');

        return redirect('nota-jual');
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
        notaJual::destroy($id);

        Session::flash('flash_message', 'notaJual deleted!');

        return redirect('nota-jual');
    }


    public function clearcustom(){
      return;
    }

    public function ceksession(){
      if(session()->has('customs')){
        $customs=session()->get('customs');
        print_r($customs);
      }else{
        echo "tidak ada session";
      }
      return;
    }

     public function jumitung($baris)
    {
       if(session()->has('customs')){
            $customs=session()->get('customs');
            $custom=$customs[$baris];
           
             echo sizeof($custom['barang']);
        }else{
            echo '0';
        }
    }

     public function jumitungedit($baris,$idnota)
    {
       if(session()->has('customs')){
            $customs=session()->get('customs');
            
            if(isset($customs[$baris])){
              $custom=$customs[$baris];
             echo sizeof($custom['barang']);
            }
            elseif(detailJualBarang::whereIdNota($idnota)->whereNoBarisPaket($baris)->get()){
              echo detailJualBarang::whereIdNota($idnota)->whereNoBarisPaket($baris)->count('id_barang');
            }
        }else{
            echo '0';
        }
    }

      public function hitungtotal($baris)
    {
       if(session()->has('customs')){
            $customs=session()->get('customs');
            $custom=$customs[$baris];
            $totot=0;

             for($i=0;$i<sizeof($custom['barang']);$i++) {
                $totot+=$custom['qty'][$i]*$custom['harga'][$i];
             }
             echo $baris."_".$custom['jual']."_".$totot;
        }else{
            echo $baris."_0_0";
        }
    }

       public function hitungtotaledit($baris,$idnota)
    {
       if(session()->has('customs')){
            $customs=session()->get('customs');
        
            $totot=0;
            if(isset($customs[$baris])){
                  $custom=$customs[$baris];
             for($i=0;$i<sizeof($custom['barang']);$i++) {
                $totot+=$custom['qty'][$i]*$custom['harga'][$i];
             }
             echo $baris."_".$custom['jual']."_".$totot;
            }elseif(detailJualBarang::whereIdNota($idnota)->whereNoBarisPaket($baris)->get()){
                $detailbarangs=detailJualBarang::whereIdNota($idnota)->whereNoBarisPaket($baris)->get();
                $paket=detailJualPaket::whereNoBaris($baris)->whereIdNota($idnota)->first();
                    foreach ($detailbarangs as $bar) {
                      $qty=$bar->getqty($bar->id_nota,$bar->no_baris_paket,$bar->id_barang);
                      $totot+=$qty*$bar->harga;
                    }
                echo $baris."_".$paket->harga."_".$totot;
            }
        }else{
            echo $baris."_0_0";
        }
    }

    public function tampilcustom($baris)
    {
         $barangs = barang::all();
         if(session()->has('customs')){
            $customs=session()->get('customs');
            $custom=$customs[$baris];
            // print_r($customs);
            $itung=0;
            for($i=0;$i<sizeof($custom['barang']);$i++) {
                $itung++;
               echo "<tr  id='nobardetail".$itung."'>
                            <td>

                                <select id='barangdet".$itung."' name='barangdet[]' class='barang form-control' onchange='getHargaDet(".$itung.")'><option>-- pilih barang --</option>";
                                    foreach ($barangs as $item){
                                        if($custom['barang'][$i]==$item->id)
                                       echo "<option value='".$item->id ."' selected > '".$item->nama."}}</option>";
                                        else
                                         echo "<option value='".$item->id ."' > '".$item->nama."}}</option>";
                                    }
                                echo "</select>
                            </td>
                            <td><input type='number' name='qtydet[]' class='qty form-control' id='qtydet".$itung."' min='0' onchange='getTotaldet(".$itung.")' value='".$custom['qty'][$i]."'></td>
                           <td><input type='number' min='0' class='form-control' value='".$custom['harga'][$i]."' name='pricedet[]' id='pricedet".$itung."' ></td>
                            <td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='det".$itung."'  onclick='hapusdet(".$itung.",event)' class='form-control btn btnhapus' >X</a></td>
                            </tr>";
            }
        }else{
            echo "";
        }
        return;
    }

    public function tampilcustomedit($baris,$idnota)
    {
         $barangs = barang::all();
         if(session()->has('customs')){
            $customs=session()->get('customs');
            
            // print_r($customs);
            $itung=0;
            if(isset($customs[$baris])){
              $custom=$customs[$baris];
              for($i=0;$i<sizeof($custom['barang']);$i++) {
                  $itung++;
                 echo "<tr  id='nobardetail".$itung."'>
                        <td>

                            <select id='barangdet".$itung."' name='barangdet[]' class='barang form-control' onchange='getHargaDet(".$itung.")'><option>-- pilih barang --</option>";
                                foreach ($barangs as $item){
                                    if($custom['barang'][$i]==$item->id)
                                   echo "<option value='".$item->id ."' selected > '".$item->nama."}}</option>";
                                    else
                                     echo "<option value='".$item->id ."' > '".$item->nama."}}</option>";
                                }
                            echo "</select>
                        </td>
                        <td><input type='number' name='qtydet[]' class='qty form-control' id='qtydet".$itung."' min='0' onchange='getTotaldet(".$itung.")' value='".$custom['qty'][$i]."'></td>
                       <td><input type='number' min='0' class='form-control' value='".$custom['harga'][$i]."' name='pricedet[]' id='pricedet".$itung."' ></td>
                        <td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='det".$itung."'  onclick='hapusdet(".$itung.",event)' class='form-control btn btnhapus' >X</a></td>
                        </tr>";
              }
            }elseif(detailJualBarang::whereIdNota($idnota)->whereNoBarisPaket($baris)->get()){
                    $detailbarangs=detailJualBarang::whereIdNota($idnota)->whereNoBarisPaket($baris)->get();
                     // $paket=detailJualPaket::whereNoBaris($baris)->whereIdNota($idnota)->first();
                    foreach ($detailbarangs as $bar) {

                      $qty=$bar->getqty($bar->id_nota,$bar->no_baris_paket,$bar->id_barang);
                      $this->cobastorecus($baris,$bar->id_barang,$qty,$bar->harga,$bar->sub_total);
                      echo "<tr  id='nobardetail".$itung."'>
                          <td>

                              <select id='barangdet".$itung."' name='barangdet[]' class='barang form-control' onchange='getHargaDet(".$itung.")'><option>-- pilih barang --</option>";
                                  foreach ($barangs as $item){
                                      if($bar->id_barang==$item->id)
                                     echo "<option value='".$item->id ."' selected > '".$item->nama."}}</option>";
                                      else
                                       echo "<option value='".$item->id ."' > '".$item->nama."}}</option>";
                                  }
                              echo "</select>
                          </td>
                          <td><input type='number' name='qtydet[]' class='qty form-control' id='qtydet".$itung."' min='0' onchange='getTotaldet(".$itung.")' value='".$qty."'></td>
                         <td><input type='number' min='0' class='form-control' value='".$bar->harga."' name='pricedet[]' id='pricedet".$itung."' ></td>
                          <td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='det".$itung."'  onclick='hapusdet(".$itung.",event)' class='form-control btn btnhapus' >X</a></td>
                          </tr>";
                    }
            }else{
               echo "";
            }
        }else{
            echo "";
        }
        return;
    }

    public function deletecustom($baris){
        $customs=session()->get('customs');
        if(sizeof($customs)>1){
            unset($customs[$baris]);
            session(['customs'=>$customs]);
        }else{
            unset($customs[$baris]);
            session()->forget('customs');
        }
        print_r(session()->get('customs'));
        return;
    }


    public function cobastorecus($baris,$barang,$qty,$harga,$jual)
    {
        $customs= array();
        $arrbar=explode("|", $barang);
        $arrqty=explode("|", $qty);
        $arrharga=explode("|", $harga);
        if(session()->has('customs')){
                $customs=session()->get('customs');
              $custom=array('barang'=>$arrbar,'qty'=>$arrqty,'harga'=>$arrharga,'jual'=>$jual);
                $customs[$baris]= $custom;
            session(['customs'=>$customs]);
        }else{
            $custom=array('barang'=>$arrbar,'qty'=>$arrqty,'harga'=>$arrharga,'jual'=>$jual);
            $customs[$baris]= $custom;
            session(['customs'=>$customs]);
        }
        print_r($custom);
        // return true;
    }
}
