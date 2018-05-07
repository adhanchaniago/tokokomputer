<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\detailReturPelanggan;
use Illuminate\Http\Request;
use Session;

class detailReturPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $detailreturpelanggan = detailReturPelanggan::where('id_nota', 'LIKE', "%$keyword%")
				->orWhere('id_barang', 'LIKE', "%$keyword%")
				->orWhere('qty', 'LIKE', "%$keyword%")
				->orWhere('sub_total', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detailreturpelanggan = detailReturPelanggan::paginate($perPage);
        }

        return view('detail-retur-pelanggan.index', compact('detailreturpelanggan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail-retur-pelanggan.create');
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
        
        detailReturPelanggan::create($requestData);

        Session::flash('flash_message', 'detailReturPelanggan added!');

        return redirect('detail-retur-pelanggan');
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
        $detailreturpelanggan = detailReturPelanggan::findOrFail($id);

        return view('detail-retur-pelanggan.show', compact('detailreturpelanggan'));
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
        $detailreturpelanggan = detailReturPelanggan::findOrFail($id);

        return view('detail-retur-pelanggan.edit', compact('detailreturpelanggan'));
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
        
        $detailreturpelanggan = detailReturPelanggan::findOrFail($id);
        $detailreturpelanggan->update($requestData);

        Session::flash('flash_message', 'detailReturPelanggan updated!');

        return redirect('detail-retur-pelanggan');
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
        detailReturPelanggan::destroy($id);

        Session::flash('flash_message', 'detailReturPelanggan deleted!');

        return redirect('detail-retur-pelanggan');
    }
}
