<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\jenisBarang;
use Illuminate\Http\Request;
use Session;

class jenisBarangController extends Controller
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
            $jenisbarang = jenisBarang::where('jenis_barang', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $jenisbarang = jenisBarang::paginate($perPage);
        }

        return view('jenis-barang.index', compact('jenisbarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('jenis-barang.create');
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
        
        jenisBarang::create($requestData);

        Session::flash('flash_message', 'jenisBarang added!');

        return redirect('jenis-barang');
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
        $jenisbarang = jenisBarang::findOrFail($id);

        return view('jenis-barang.show', compact('jenisbarang'));
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
        $jenisbarang = jenisBarang::findOrFail($id);

        return view('jenis-barang.edit', compact('jenisbarang'));
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
        
        $jenisbarang = jenisBarang::findOrFail($id);
        $jenisbarang->update($requestData);

        Session::flash('flash_message', 'jenisBarang updated!');

        return redirect('jenis-barang');
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
        jenisBarang::destroy($id);

        Session::flash('flash_message', 'jenisBarang deleted!');

        return redirect('jenis-barang');
    }
}
