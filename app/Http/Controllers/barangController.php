<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\barang;
use App\jenisBarang;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\ImageManagerStatic as Image;

class barangController extends Controller
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
            $barang = barang::where('kode_barang', 'LIKE', "%$keyword%")
				->orWhere('nama', 'LIKE', "%$keyword%")
				->orWhere('detail', 'LIKE', "%$keyword%")
				->orWhere('harga_jual', 'LIKE', "%$keyword%")
				->orWhere('harga_asli', 'LIKE', "%$keyword%")
				->orWhere('harga_beli_rata', 'LIKE', "%$keyword%")
				->orWhere('id_jenis_barang', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $barang = barang::paginate($perPage);
        }

        return view('barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $jenisbarangs=jenisBarang::all()->sortBy('jenis_barang', SORT_NATURAL | SORT_FLAG_CASE)->pluck('jenis_barang', 'id');
        return view('barang.create', compact('jenisbarangs'));
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
        
        // barang::create($requestData);
         
        $barang= new barang( array('nama' => $request->get('nama'),
        'detail' => null,
        'harga_jual' => $request->get('harga_jual'),
        'harga_beli' => $request->get('harga_asli'),
        'harga_beli_rata'=> $request->get('harga_asli'),
        'id_jenis_barang' => $request->get('id_jenis_barang'),
        'stok_baik' => $request->get('stok'),
        'stok_rusak'=>0 
            ));
        $barang->save();
        if($request->hasFile('detail')){
           
          $filename='';
      $image=$request->file('detail');
         $filename  = $barang->id . '.' . $image->getClientOriginalExtension();

         

        $path = public_path('img/' . $filename);

    
            Image::make($image->getRealPath())->resize(250, 250)->save($path);
            $barang->detail=$filename;
            $barang->save();
        }

        Session::flash('flash_message', 'barang added!');

        return redirect('barang');
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
        $barang = barang::findOrFail($id);

        return view('barang.show', compact('barang'));
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
        $barang = barang::findOrFail($id);
        $jenisbarangs=jenisBarang::all()->sortBy('jenis_barang', SORT_NATURAL | SORT_FLAG_CASE)->pluck('jenis_barang', 'id');

        return view('barang.edit', compact('barang', 'jenisbarangs'));
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

      
            $harga_beli_rata=0;
            $barang = barang::findOrFail($id);
            if($barang->harga_beli_rata)
            $harga_beli_rata=$barang->harga_beli_rata;
            $barang->update(['nama' => $request->get('nama'),
            'harga_jual' => $request->get('harga_jual'),
            'harga_beli_rata'=> $harga_beli_rata,
            'id_jenis_barang' => $request->get('id_jenis_barang') ]);

         if($request->hasFile('detail')){
                $image=$request->file('detail');
                 $filename  = $id . '.' . $image->getClientOriginalExtension();
                 

                $path = public_path('img/' . $filename);

            Image::make($image->getRealPath())->resize(250, 250)->save($path);
                $barang->detail=$filename;
                $barang->save();
            }


        Session::flash('flash_message', 'barang updated!');

        return redirect('barang');
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
        barang::destroy($id);

        Session::flash('flash_message', 'barang deleted!');

        return redirect('barang');
    }
}
