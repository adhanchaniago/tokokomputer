<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\laporanAkun;
use Illuminate\Http\Request;
use Session;

class laporanAkunController extends Controller
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
            $laporanakun = laporanAkun::where('id_laporan', 'LIKE', "%$keyword%")
				->orWhere('nomor_akun', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $laporanakun = laporanAkun::paginate($perPage);
        }

        return view('laporan-akun.index', compact('laporanakun'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('laporan-akun.create');
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
        
        laporanAkun::create($requestData);

        Session::flash('flash_message', 'laporanAkun added!');

        return redirect('laporan-akun');
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
        $laporanakun = laporanAkun::findOrFail($id);

        return view('laporan-akun.show', compact('laporanakun'));
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
        $laporanakun = laporanAkun::findOrFail($id);

        return view('laporan-akun.edit', compact('laporanakun'));
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
        
        $laporanakun = laporanAkun::findOrFail($id);
        $laporanakun->update($requestData);

        Session::flash('flash_message', 'laporanAkun updated!');

        return redirect('laporan-akun');
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
        laporanAkun::destroy($id);

        Session::flash('flash_message', 'laporanAkun deleted!');

        return redirect('laporan-akun');
    }
}
