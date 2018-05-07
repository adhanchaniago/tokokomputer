<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\detailNotaBeli;
use Illuminate\Http\Request;
use Session;

class detailNotaBeliController extends Controller
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
            $detailnotabeli = detailNotaBeli::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('id_barang', 'LIKE', "%$keyword%")
				->orWhere('qty', 'LIKE', "%$keyword%")
				->orWhere('sub_total', 'LIKE', "%$keyword%")
				->orWhere('harga', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detailnotabeli = detailNotaBeli::paginate($perPage);
        }

        return view('detail-nota-beli.index', compact('detailnotabeli'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail-nota-beli.create');
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
        
        detailNotaBeli::create($requestData);

        Session::flash('flash_message', 'detailNotaBeli added!');

        return redirect('detail-nota-beli');
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
        $detailnotabeli = detailNotaBeli::findOrFail($id);

        return view('detail-nota-beli.show', compact('detailnotabeli'));
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
        $detailnotabeli = detailNotaBeli::findOrFail($id);

        return view('detail-nota-beli.edit', compact('detailnotabeli'));
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
        
        $detailnotabeli = detailNotaBeli::findOrFail($id);
        $detailnotabeli->update($requestData);

        Session::flash('flash_message', 'detailNotaBeli updated!');

        return redirect('detail-nota-beli');
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
        detailNotaBeli::destroy($id);

        Session::flash('flash_message', 'detailNotaBeli deleted!');

        return redirect('detail-nota-beli');
    }
}
