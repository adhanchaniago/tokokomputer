<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\detailJualPaket;
use Illuminate\Http\Request;
use Session;

class detailJualPaketController extends Controller
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
            $detailjualpaket = detailJualPaket::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('id_paket', 'LIKE', "%$keyword%")
				->orWhere('qty', 'LIKE', "%$keyword%")
				->orWhere('sub_total', 'LIKE', "%$keyword%")
				->orWhere('harga', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detailjualpaket = detailJualPaket::paginate($perPage);
        }

        return view('detail-jual-paket.index', compact('detailjualpaket'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail-jual-paket.create');
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
        
        detailJualPaket::create($requestData);

        Session::flash('flash_message', 'detailJualPaket added!');

        return redirect('detail-jual-paket');
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
        $detailjualpaket = detailJualPaket::findOrFail($id);

        return view('detail-jual-paket.show', compact('detailjualpaket'));
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
        $detailjualpaket = detailJualPaket::findOrFail($id);

        return view('detail-jual-paket.edit', compact('detailjualpaket'));
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
        
        $detailjualpaket = detailJualPaket::findOrFail($id);
        $detailjualpaket->update($requestData);

        Session::flash('flash_message', 'detailJualPaket updated!');

        return redirect('detail-jual-paket');
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
        detailJualPaket::destroy($id);

        Session::flash('flash_message', 'detailJualPaket deleted!');

        return redirect('detail-jual-paket');
    }
}
