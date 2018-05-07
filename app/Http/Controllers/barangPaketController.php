<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\barangPaket;
use Illuminate\Http\Request;
use Session;

class barangPaketController extends Controller
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
            $barangpaket = barangPaket::where('id_paket', 'LIKE', "%$keyword%")
				->orWhere('id_barang', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $barangpaket = barangPaket::paginate($perPage);
        }

        return view('barang-paket.index', compact('barangpaket'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('barang-paket.create');
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
        
        barangPaket::create($requestData);

        Session::flash('flash_message', 'barangPaket added!');

        return redirect('barang-paket');
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
        $barangpaket = barangPaket::findOrFail($id);

        return view('barang-paket.show', compact('barangpaket'));
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
        $barangpaket = barangPaket::findOrFail($id);

        return view('barang-paket.edit', compact('barangpaket'));
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
        
        $barangpaket = barangPaket::findOrFail($id);
        $barangpaket->update($requestData);

        Session::flash('flash_message', 'barangPaket updated!');

        return redirect('barang-paket');
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
        barangPaket::destroy($id);

        Session::flash('flash_message', 'barangPaket deleted!');

        return redirect('barang-paket');
    }
}
