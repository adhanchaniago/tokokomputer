<div class="col-md-3">
    <div class="panel panel-default panel-flush">
        <div class="panel-heading">
            Menu Toko Komputer
        </div>

        <div class="panel-body">
            <ul class="nav" role="tablist">
                <li role="presentation">
                    <a href="{{ url('/barang') }}">
                        Master Barang
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/customer') }}">
                        Master Customer
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/jenis-barang') }}">
                        Master Jenis Barang
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/paket') }}">
                        Master Paket
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/supplier') }}">
                        Master Supplier
                    </a>
                </li>
            </ul>
            <ul class="nav" role="tablist">
                <li role="presentation">
                    <a href="{{ url('/nota-beli') }}">
                        Nota Beli
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/nota-penerimaan') }}">
                        Nota Penerimaan
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/nota-jual') }}">
                        Nota Jual
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/nota-perakitan') }}">
                        Nota Perakitan
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/nota-bayar') }}">
                        Nota Bayar
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/nota-retur-barang') }}">
                        Nota Retur Beli
                    </a>
                </li>
                 <li role="presentation">
                    <a href="{{ url('/nota-retur-pelanggan') }}">
                        Nota Retur Jual
                    </a>
                </li>
                 <li role="presentation">
                    <a href="{{ url('/nota-service') }}">
                        Nota Service
                    </a>
                </li>
                @if(Auth::user()->jabatan=="pemilik")
                <li role="presentation">
                    <a href="{{ url('/laporanjurnal') }}">
                        Laporan Jurnal
                    </a>
                </li>
                
                <li role="presentation">
                    <a href="{{ url('/laporanaruskas') }}">
                        Arus Kas
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/laporanlabarugi') }}">
                        Laporan Laba/Rugi
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/laporanekuitas') }}">
                        Perubahan Ekuitas
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/laporanneraca') }}">
                        Laporan Neraca
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/laporanbukubesar') }}">
                        Laporan Buku Besar
                    </a>
                </li>
                <li role="presentation">
                    <a href="{{ url('/periode') }}">
                        Periode
                    </a>
                </li>                      
                @endif
            </ul>
        </div>
    </div>
</div>
