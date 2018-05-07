<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\detailJualBarang;
use Illuminate\Http\Request;
use Session;

class detailJualBarangController extends Controller
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
            $detailjualbarang = detailJualBarang::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('id_barang', 'LIKE', "%$keyword%")
				->orWhere('qty', 'LIKE', "%$keyword%")
				->orWhere('sub_total', 'LIKE', "%$keyword%")
				->orWhere('harga', 'LIKE', "%$keyword%")
				->orWhere('minimum', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detailjualbarang = detailJualBarang::paginate($perPage);
        }

        return view('detail-jual-barang.index', compact('detailjualbarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail-jual-barang.create');
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
        
        detailJualBarang::create($requestData);

        Session::flash('flash_message', 'detailJualBarang added!');

        return redirect('detail-jual-barang');
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
        $detailjualbarang = detailJualBarang::findOrFail($id);

        return view('detail-jual-barang.show', compact('detailjualbarang'));
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
        $detailjualbarang = detailJualBarang::findOrFail($id);

        return view('detail-jual-barang.edit', compact('detailjualbarang'));
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
        
        $detailjualbarang = detailJualBarang::findOrFail($id);
        $detailjualbarang->update($requestData);

        Session::flash('flash_message', 'detailJualBarang updated!');

        return redirect('detail-jual-barang');
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
        detailJualBarang::destroy($id);

        Session::flash('flash_message', 'detailJualBarang deleted!');

        return redirect('detail-jual-barang');
    }
}
