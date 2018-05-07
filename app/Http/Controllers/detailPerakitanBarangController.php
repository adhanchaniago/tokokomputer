<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\detailPerakitanBarang;
use Illuminate\Http\Request;
use Session;

class detailPerakitanBarangController extends Controller
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
            $detailperakitanbarang = detailPerakitanBarang::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('id_barang', 'LIKE', "%$keyword%")
				->orWhere('qty', 'LIKE', "%$keyword%")
				->orWhere('sub_total', 'LIKE', "%$keyword%")
				->orWhere('harga', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detailperakitanbarang = detailPerakitanBarang::paginate($perPage);
        }

        return view('detail-perakitan-barang.index', compact('detailperakitanbarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail-perakitan-barang.create');
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
        
        detailPerakitanBarang::create($requestData);

        Session::flash('flash_message', 'detailPerakitanBarang added!');

        return redirect('detail-perakitan-barang');
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
        $detailperakitanbarang = detailPerakitanBarang::findOrFail($id);

        return view('detail-perakitan-barang.show', compact('detailperakitanbarang'));
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
        $detailperakitanbarang = detailPerakitanBarang::findOrFail($id);

        return view('detail-perakitan-barang.edit', compact('detailperakitanbarang'));
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
        
        $detailperakitanbarang = detailPerakitanBarang::findOrFail($id);
        $detailperakitanbarang->update($requestData);

        Session::flash('flash_message', 'detailPerakitanBarang updated!');

        return redirect('detail-perakitan-barang');
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
        detailPerakitanBarang::destroy($id);

        Session::flash('flash_message', 'detailPerakitanBarang deleted!');

        return redirect('detail-perakitan-barang');
    }
}
