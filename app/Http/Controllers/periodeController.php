<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\akun;
use App\akunJurnal;
use App\jurnal;
use App\laporan;
use App\laporanAkun;
use App\periode;
use App\periodeAkun;
use Illuminate\Http\Request;
use Session;

class periodeController extends Controller
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
            $periode = periode::where('tgl_awal', 'LIKE', "%$keyword%")
				->orWhere('tgl_akhir', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $periode = periode::paginate($perPage);
        }

        $jum=periode::where('tgl_awal','<=',date('Y-m-d'))->where('tgl_akhir','>=',date('Y-m-d'))->count('id');
        if($jum)
           $aktif= periode::where('tgl_awal','<=',date('Y-m-d'))->where('tgl_akhir','>=',date('Y-m-d'))->first();
        else
            $aktif=periode::orderBy('id','desc')->first();
        return view('periode.index', compact('periode','aktif'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $periode=periode::whereStatus('selesai')->orderBy('id','desc')->first();
        return view('periode.create', compact('periode'));
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
        
        // periode::create($requestData);

        $periode=new periode(array('tgl_awal'=>$request->get('tgl_awal'),
            'tgl_akhir'=>$request->get('tgl_akhir'),
            'status'=>$request->get('status')
            ));
        $periode->save();

        // $sebelum=periode::where('id','<',$periode->id)->orderBy('id','desc')->first();
        $akuns=periodeAkun::whereIdPeriode($request->get('id_sebelum'))->get();
        foreach ($akuns as $akun) {
            $periodeAkun=new periodeAkun(array(
                'id_periode'=>$periode->id,
                'nomor_akun'=>$akun->nomor_akun,
                'saldo_awal'=>$akun->saldo_akhir,
                'saldo_akhir'=>0
            ));
            $periodeAkun->save();
        }

        Session::flash('flash_message', 'periode added!');

        return redirect('periode');
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
        $periode = periode::findOrFail($id);

        return view('periode.show', compact('periode'));
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
        $periode = periode::findOrFail($id);

        return view('periode.edit', compact('periode'));
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
        
        $periode = periode::findOrFail($id);
        $periode->update($requestData);

        Session::flash('flash_message', 'periode updated!');

        return redirect('periode');
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
        periode::destroy($id);

        Session::flash('flash_message', 'periode deleted!');

        return redirect('periode');
    }
}
