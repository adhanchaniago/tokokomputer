<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\paket;
use App\barang;
use App\barangPaket;
use Illuminate\Http\Request;
use Session;

class paketController extends Controller
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
            $paket = paket::where('nama', 'LIKE', "%$keyword%")
				->orWhere('detail', 'LIKE', "%$keyword%")
				->orWhere('total_harga_jual', 'LIKE', "%$keyword%")
				->orWhere('total_harga_asli', 'LIKE', "%$keyword%")
				->orWhere('stok', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $paket = paket::paginate($perPage);
        }

        return view('paket.index', compact('paket'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $barangs=barang::all();
        return view('paket.create', compact('barangs'));
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
        $nama=$request->get('nama');
        $detail=$request->get('detail');
        $hargaasli=$request->get('total_harga_asli');
        $hargajual=$request->get('total_harga_jual');
        $barang=$request->get('barang');
        $stok=0;
        
        $paket=new paket(array('nama'=>$nama,
            'detail'=>$detail,
            'total_harga_jual'=>$hargajual,
            'total_harga_asli'=>$hargaasli,
            'stok'=>$stok
            ));
        $paket->save();

         for($i=0;$i<sizeof($barang);$i++){
            $barangpaket=new barangPaket(array('id_paket'=>$paket->id,
                'id_barang'=>$barang[$i]
                ));
            $barangpaket->save();

         }
        //paket::create($requestData);

        Session::flash('flash_message', 'paket added!');

        return redirect('paket');
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
        $paket = paket::findOrFail($id);

        return view('paket.show', compact('paket'));
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
        $paket = paket::findOrFail($id);
        $details=$paket->barang;
        $barangs=barang::all();

        return view('paket.edit', compact('paket','barangs','details'));
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
         
        $nama=$request->get('nama');
        $detail=$request->get('detail');
        $hargaasli=$request->get('total_harga_asli');
        $hargajual=$request->get('total_harga_jual');
        $barang=$request->get('barang');
        // $requestData = $request->all();
        
        $paket = paket::findOrFail($id);
        $paket->update(['nama'=>$nama,
            'detail'=>$detail,
            'total_harga_jual'=>$hargajual,
            'total_harga_asli'=>$hargaasli]);
        $paket->save();
        barangPaket::where('id_paket','=',$paket->id)->delete();
        for($i=0;$i<sizeof($barang);$i++){
            $barangpaket=new barangPaket(array('id_paket'=>$paket->id,
                'id_barang'=>$barang[$i]
                ));
            $barangpaket->save();

         }


        Session::flash('flash_message', 'paket updated!');

        return redirect('paket');
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
        paket::destroy($id);

        Session::flash('flash_message', 'paket deleted!');

        return redirect('paket');
    }
}
