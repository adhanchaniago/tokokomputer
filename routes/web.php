<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('settagihan/{id}','notaBayarController@settagihan');
Route::get('loaddetail/{tipe}/{id}', 'notaPenerimaanController@loaddetail');
Route::get('loadsupplier/{tipe}/{id}', 'notaPenerimaanController@loadsupplier');
Route::get('tampilcustom/{baris}', 'notaJualController@tampilcustom');
Route::get('hapuscustom/{baris}', 'notaJualController@deletecustom');
Route::get('hitungtotal/{baris}', 'notaJualController@hitungtotal');
Route::get('getjumitung/{baris}', 'notaJualController@jumitung');
Route::get('storecustom/{baris}/{barang}/{qty}/{harga}/{jual}', 'notaJualController@cobastorecus');
Route::get('insertperiodeakun', 'laporanController@insertperiodeakun');
Route::get('ekuitas', 'laporanController@insertekuitas');
Route::get('aruskas', 'laporanController@insertaruskas');

Route::get('neraca', 'laporanController@insertneraca');
Route::get('labarugi', 'laporanController@insertlabarugi');
Route::get('tutupperiode/{id}', 'laporanController@tutupperiode');
//=======================tampilan laporan =================================
	
Route::get('laporanaruskas', 'laporanController@tampilaruskas');
Route::get('laporanlabarugi', 'laporanController@tampillabarugi');
Route::get('laporanjurnal', 'laporanController@tampiljurnal');
Route::get('laporanekuitas', 'laporanController@tampilekuitas');
Route::get('laporanneraca', 'laporanController@tampilneraca');
Route::get('laporanbukubesar', 'laporanController@tampilbukubesar');


Route::post('laporanaruskas', 'laporanController@tampilaruskaspost');
Route::post('laporanlabarugi', 'laporanController@tampillabarugipost');
Route::post('laporanjurnal', 'laporanController@tampiljurnalpost');
Route::post('laporanekuitas', 'laporanController@tampilekuitaspost');
Route::post('laporanneraca', 'laporanController@tampilneracapost');
Route::post('laporanbukubesar', 'laporanController@tampilbukubesarpost');
// Route::get('laporanbukuclosing/{id}', 'laporanController@tampilbukuclosing');

//======================== end tampilan laporan =========================== 
Route::resource('jenis-barang', 'jenisBarangController');
Route::resource('barang', 'barangController');
Route::resource('paket', 'paketController');
Route::resource('customer', 'customerController');
Route::resource('customer', 'customerController');
Route::resource('supplier', 'supplierController');
Route::resource('nota-retur-barang', 'notaReturBarangController');
Route::resource('detail-nota-retur', 'detailNotaReturController');
Route::resource('nota-beli', 'notaBeliController');
Route::resource('detail-nota-beli', 'detailNotaBeliController');
Route::resource('nota-bayar', 'notaBayarController');
Route::resource('nota-perakitan', 'notaPerakitanController');
Route::resource('detail-perakitan-barang', 'detailPerakitanBarangController');
Route::resource('detail-perakitan-paket', 'detailPerakitanPaketController');
Route::resource('nota-service', 'notaServiceController');
Route::resource('detail-nota-service', 'detailNotaServiceController');
Route::resource('nota-jual', 'notaJualController');
Route::resource('detail-jual-barang', 'detailJualBarangController');
Route::resource('detail-jual-paket', 'detailJualPaketController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('barang-paket', 'barangPaketController');
Route::resource('nota-penerimaan', 'notaPenerimaanController');
Route::resource('detail-penerimaan', 'detailPenerimaanController');
Route::resource('nota-retur-pelanggan', 'notaReturPelangganController');
Route::resource('detail-retur-pelanggan', 'detailReturPelangganController');
Route::resource('detail-sperparts', 'detailSperpartsController');
Route::resource('periode', 'periodeController');
Route::resource('laporan', 'laporanController');
Route::resource('akun', 'akunController');
Route::resource('periode-akun', 'periodeAkunController');
Route::resource('jurnal', 'jurnalController');
Route::resource('laporan-akun', 'laporanAkunController');
Route::resource('akun-jurnal', 'akunJurnalController');