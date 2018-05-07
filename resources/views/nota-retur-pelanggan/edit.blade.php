@extends('layouts.app')
@section('title','Retur Pembelian Barang')
@section('content')
    <div class="container">
        <div class="row">
        @include('admin.sidebar')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Retur Jual Barang</div>
                    <div class="panel-body">

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif


                        @php
                            setlocale(LC_TIME, 'IND');
                            
                            $tgl= strftime('%d %B %Y', strtotime($notaretur->tgl));
                        @endphp

                        {!! Form::open(['url' => ['/nota-retur-pelanggan',$notaretur->id], 'method' => 'patch', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="row form-group">
                                <label class="col-md-2" style="text-align: right;">No Nota</label>
                                
                                <label  class="col-md-3" style="text-align: left;">{{ $notaretur->id }}</label>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Tanggal</label>
                                
                                <div  class="col-md-3"> {{$tgl}} {{date('H:i',strtotime($notaretur->tgl))}} </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Customer</label>
                            <div class="col-md-3">
                            <select class=" form-control" name="id_customer" id="id_customer">
                                @foreach($customers as $cus)
                                    @if($notaretur->id_supplier==$cus->id)
                                    <option value="{{$cus->id}}" selected>{{$cus->nama}}</option>
                                    @else
                                    <option value="{{$cus->id}}">{{$cus->nama}}</option>
                                    @endif                                    
                                @endforeach
                            </select>
                            </div>
                            <label class="col-md-2"></label>
                            <label class="col-md-2" style="text-align: right;">Tanggal Selesai</label>
                            <div class="col-md-3">
                            <input type="date" name="selesai" id='selesai' class="form-control" value="{{$notaretur->tgl_selesai}}">
                            </div>
                        </div>
                         <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Catatan</label>
                            <div class="col-md-3">
                            <textarea name="catatan" class="form-control" rows="3" style="resize: none">{{$notaretur->catatan}}</textarea>
                            </div>
                            <label class="col-md-2"></label>
                            <label class="col-md-2" style="text-align: right;">Jenis Retur</label>
                            <div class="col-md-3">
                            <select class=" form-control" name="jenis_retur" id="jenis_retur">
                                <option value="uang" {{($notaretur->jenis_retur=='uang')?"selected":''}}>Uang</option>
                                <option value="barang" {{($notaretur->jenis_retur=='barang')?"selected":''}}>Barang</option>
                            </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Status</label>
                            <div class="col-md-3">
                            <select class=" form-control" name="status" id="status">
                                <option value="menunggu" {{($notaretur->status=='menunggu')?"selected":''}}>Menunggu</option>
                                <option value="selesai" {{($notaretur->status=='selesai')?"selected":''}}>Selesai</option>
                            </select>
                            </div>
                        </div>      
                        <input type="hidden" id="no" value="{{$details->count()}}">
                        <table id="tabelBarang" class="table" >
                             <thead>
                                <th>Barang</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Qty Retur</th>
                                <th>Total Retur</th>
                                <th>Aksi</th>                              
                            </thead>    
                            <tbody id="detail">
                                  @php
                                        $itung=1;
                                        $grantot=0;
                                     
                                        @endphp

                                @foreach($details as $detail)
                                          <tr  id='no{{$itung}}'>
                                                <td>
                                                    <select id='barang{{$itung}}' name='barang[]' class='barang form-control' onchange='getHarga({{$itung}})'><option>-- pilih barang --</option>
                                                        @foreach ($barangs as $item)
                                                            @if($item->id==$detail->id_barang)

                                                           <option value='{{ $item->id }}' selected> {{$item -> nama}}</option>
                                                           @else
                                                           <option value='{{ $item->id }}'> {{$item -> nama}}</option>
                                                           @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td id='pricebuy{{$itung}}' >{{$detail->barang->harga_jual}}</td>
                                                <td id='stok{{$itung}}'>{{$detail->barang->stok_baik}}</td>
                                                <td><input type='number' name='qtyretur[]' value="{{$detail->qty}}" class='qty form-control' id='qtyretur{{$itung}}' min='0' value='0' onchange='getTotRetur({{$itung}})'></td>
                                                <td><input type='number' readonly name='totalretur[]' id='totalretur{{$itung}}' value="{{$detail->sub_total}}" class='form-control'></td>
                                                <td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='{{$itung}}'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>
                                                </tr>

                                        @php
                                        $itung++;
                                        $grantot+=$detail->sub_total;
                                        @endphp
                                        @endforeach
                            </tbody>
                            <tfoot>
                                            <tr>
                                             
                                                
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                 <td></td>
                                                <td></td>
                                                <td><a href='#' class='btn btn-default' id='tambah' align='right'> Tambah </a></td>
                                               
                                            </tr>
                                            <tr>
                                            
                                                
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td align="right">GRAND TOTAL</td>
                                                <td colspan="2">
                                                    <input type="text" class='form-control' readonly name="grandTot" value="{{$grantot}}" id="grandTot">
                                                </td>
                                                <td></td>
                                            </tr>
                                      
                                           
                                            <tr>
                                                <td></td>
                                                <td><a href="{{url('nota-retur-pelanggan')}}" class="btn btn-warning">Kembali</a></td>
                                                <td></td>
                                                <td><button class="btn btn-default"> Simpan </button></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                        </table>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

    $(document).ready( function ()
    {
    $('#tambah').click(function(){
        var itung=$("#no").val();

        itung++;
        var baris = "<tr  id='no"+itung+"'>"+
                                                "<td>"+
                                                    "<select id='barang"+itung+"' name='barang[]' class='barang form-control' onchange='getHarga("+itung+")'>"+"<option>-- pilih barang --</option>"+
                                                        @foreach ($barangs as $item)
                                                           "<option value='{{ $item->id }}'> {{$item -> nama}}</option>"+
                                                        @endforeach
                                                    "</select>"+
                                                "</td>"+
                                                "<td id='pricebuy"+itung+"' ></td>"+
                                                "<td id='stok"+itung+"'></td>"+
                                                "<td><input type='number' name='qtyretur[]' class='qty form-control' id='qtyretur"+itung+"' min='0' value='0' onchange='getTotRetur("+itung+")'></td>"+
                                                "<td><input type='number' readonly name='totalretur[]' id='totalretur"+itung+"' class='form-control'></td>"+
                                                "<td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>"
                                                "</tr>";
           
            
         
        
        $('#detail').append(baris);
        $('#no').val(itung);
        })

   


    $('#norek').hide();
});

    // function getBarang(){
    //         // var notapembelian_nonota = $("#notapembelian_nonota").val();
    //         // if(notapembelian_nonota){
    //         //     $.ajax({
    //         //     type: "get",
    //         //     url: "{{ url('returpembelianbarang/getbarang') }}",
    //         //     data:'notapembelian_nonota='+notapembelian_nonota,
    //         //     success: function(data){
    //         //         $("#tabelBarang").html('');
    //         //         $("#tabelBarang").html(data);
    //         //     }
    //         // });
    //     }
    // }

function hapus(param, e){
    e.preventDefault()
   

    $('#no'+param.id).remove();
    getGrandTotal()

    // return false;
}

function getHarga(no)
{
    

    var option = $("#barang"+no).val();
    var nomer=no;
    /* setting input box value to selected option value */
    var kodebarang = [
    @foreach ($barangs as $item)
        [ "{{ $item->id }}" ], 
    @endforeach
    ];
    var stok=[
        @foreach ($barangs as $item)
        [ "{{ $item->stok_baik }}" ], 
        @endforeach
    ];
    var harga = [
    @foreach ($barangs as $item)
         [ "{{ $item->harga_jual }}" ],
    @endforeach
    ];
    for(var i=0;i<kodebarang.length;i++){
        if(kodebarang[i]==option){
            $('#pricebuy'+no).html(harga[i]);
            $('#stok'+no).html(stok[i])
            $('#qtyretur'+no).attr({
                min:0,
                max:stok[i]
            })
            
            //price[itung].html(harga[i]);
        }
    }
}
    function getTotRetur(no){
        var satuan=parseInt($("#pricebuy"+no).html())
        var qty=$("#qtyretur"+no).val();
        var total=qty*satuan;
        $("#totalretur"+no).val(total);
        getGrandTotRetur();
    }

    function getGrandTotRetur(){
    var arraytotal = document.getElementsByName('totalretur[]');
    var tot=0;
    for(var i=0;i<arraytotal.length;i++){
        if(parseInt(arraytotal[i].value))
            tot += parseInt(arraytotal[i].value);
    }
    document.getElementById('grandTot').value = tot;
    }
    </script>
@endsection