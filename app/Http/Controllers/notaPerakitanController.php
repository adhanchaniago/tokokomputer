<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\notaJual;
use App\notaPerakitan;
use App\detailPerakitanBarang;
use App\detailPerakitanPaket;
use App\detailJualBarang;
use App\detailJualPaket;
use App\customer;
use App\barang;
use App\paket;
use App\barangPaket;
use Illuminate\Http\Request;
use Session;

class notaPerakitanController extends Controller
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
            $notaperakitan = notaPerakitan::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('tgl', 'LIKE', "%$keyword%")
				->orWhere('biaya', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $notaperakitan = notaPerakitan::paginate($perPage);
        }

        return view('nota-perakitan.index', compact('notaperakitan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('nota-perakitan.create');
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
        
        notaPerakitan::create($requestData);

        Session::flash('flash_message', 'notaPerakitan added!');

        return redirect('nota-perakitan');
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
        $notaperakitan = notaPerakitan::findOrFail($id);
        $barangs= detailPerakitanBarang::whereIdNota($id)->whereNoBarisPaket('0')->get();

        $pakets=$notaperakitan->detailpaket;

        return view('nota-perakitan.show', compact('notaperakitan','barangs','pakets'));
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
        $notaperakitan = notaPerakitan::findOrFail($id);
        $barangs= detailPerakitanBarang::whereIdNota($id)->whereNoBarisPaket('0')->get();

        $pakets=$notaperakitan->detailpaket;

        return view('nota-perakitan.edit', compact('notaperakitan','barangs','pakets'));
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
        
        $notaperakitan = notaPerakitan::findOrFail($id);
        $notaperakitan->update(['status'=>$request->get('status')]);

        Session::flash('flash_message', 'notaPerakitan updated!');

        return redirect('nota-perakitan');
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
        notaPerakitan::destroy($id);

        Session::flash('flash_message', 'notaPerakitan deleted!');

        return redirect('nota-perakitan');
    }
}
