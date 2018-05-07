<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\detailPerakitanPaket;
use Illuminate\Http\Request;
use Session;

class detailPerakitanPaketController extends Controller
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
            $detailperakitanpaket = detailPerakitanPaket::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('id_paket', 'LIKE', "%$keyword%")
				->orWhere('qty', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detailperakitanpaket = detailPerakitanPaket::paginate($perPage);
        }

        return view('detail-perakitan-paket.index', compact('detailperakitanpaket'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail-perakitan-paket.create');
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
        
        detailPerakitanPaket::create($requestData);

        Session::flash('flash_message', 'detailPerakitanPaket added!');

        return redirect('detail-perakitan-paket');
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
        $detailperakitanpaket = detailPerakitanPaket::findOrFail($id);

        return view('detail-perakitan-paket.show', compact('detailperakitanpaket'));
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
        $detailperakitanpaket = detailPerakitanPaket::findOrFail($id);

        return view('detail-perakitan-paket.edit', compact('detailperakitanpaket'));
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
        
        $detailperakitanpaket = detailPerakitanPaket::findOrFail($id);
        $detailperakitanpaket->update($requestData);

        Session::flash('flash_message', 'detailPerakitanPaket updated!');

        return redirect('detail-perakitan-paket');
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
        detailPerakitanPaket::destroy($id);

        Session::flash('flash_message', 'detailPerakitanPaket deleted!');

        return redirect('detail-perakitan-paket');
    }
}
