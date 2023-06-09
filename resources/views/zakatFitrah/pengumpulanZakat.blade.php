@extends('layouts.app') 

@section('content')  

@if(Session::has('success'))
    <p class="alert alert-success mt-3" id="sixSeconds">{{ Session::get('success') }}</p>
@elseif (Session::has('failed'))
    <p class="alert alert-danger mt-3" id="sixSeconds">{{ Session::get('failed') }}</p>
@endif  

<div class="header flex">
 
    <div class="container_item d-flex mt-5 justify-content-between"> 
        <h1 class="title">Pengumpulan Zakat Fitrah</h1>

        <div>
            <button class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#modal_view">Pembayar</button>

            <div class="modal fade modal_nohide1" id="modal_view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Lihat Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="flex header">
                                <h3 class="title">Muzakki Yang Sudah Membayar Zakat</h3> 
                            </div>

                            <div class="container_table">
                                @if ($datas_accepted->isEmpty() != true)
                                <table class="table">
                                    <thead>
                                        <tr class="header-row">
                                            <th scope="col">No</th> 
                                            <th scope="col">Nama</th>
                                            <th scope="col">Tanggungan</th>
                                            <th scope="col">Tanggungan Dibayar</th>
                                            <th scope="col">Jenis Bayar</th>
                                            <th scope="col">Bayar</th>
                                            @if (auth()->check()) 
                                                <th>Hapus</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $totalUang = 0;
                                            $totalBeras = 0;
                                        @endphp
                                        @foreach($datas_accepted as $key3=>$value3)
                                        <tr class="id_row_clickable row_animate">
                                            <th scope="row">{{ $i++ }}</th> 
                                            <td>{{ $value3->namaKK }}</td>
                                            <td>{{ $value3->jumlahTanggungan }}</td>
                                            <td>{{ $value3->jumlahTanggunganDibayar }}</td>
                                            <td>{{ $value3->jenisBayar }}</td>
                                            @if ($value3->bayarUang != null)
                                                <td>{{ @money($value3->bayarUang) }}</td>
                                                @php
                                                    $totalUang += $value3->bayarUang; 
                                                @endphp
                                            @else
                                                <td>{{ $value3->bayarBeras }} Kg</td>
                                                @php
                                                    $totalBeras += $value3->bayarBeras; 
                                                @endphp
                                            @endif
                                            
                                            @if (auth()->check())
                                            <td class="container_button">
                                                <form method="POST" action="{{ url('/zakatFitrah/pengumpulanZakat/'.$value3->id) }}">
                                                @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    
                                                    <input value="{{ $value3->bayarBeras }}" name="bayarBeras" type="hidden">
                                                    <input value="{{ $value3->bayarUang }}" name="bayarUang" type="hidden">

                                                    <button type="submit" class="btn btn-danger">Hapus</button>      
                                                </form> 
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody> 
                                </table>
                                @else
                                <div class="container_empty inside"> 
                                    <h5>Data Masih Kosong!</h5>
                                </div>
                                @endif
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if (auth()->check())
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_tambah">Tambah</button>

                <div class="modal fade modal_nohide1" id="modal_tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Buat Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('/zakatFitrah/pengumpulanZakat') }}" method="POST">
                                @csrf
                                        
                                <div class="row align-items-start">   
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="kumpulZakat_select" class="col-form-label">Nama:</label>
                                            <select name="namaKK" type="text" class="form-select" id="kumpulZakat_select" required autofocus>
                                                <option value="" disabled selected>-- select --</option>
                                                @foreach($datas1 as $key=>$value)
                                                    <option value="{{ $value->namaMuzakki }}">{{ $value->namaMuzakki }}</option> 
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="kumpulZakat_select2" class="col-form-label">Jenis Bayar:</label>
                                            <select name="jenisBayar" type="text" class="form-select" id="kumpulZakat_select2" required>
                                                <option value="" disabled selected>-- select --</option>
                                                <option value="Beras">Beras</option>
                                                <option value="Uang">Uang</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="tanggunganDibayar" class="col-form-label">Jumlah Tanggungan Dibayar:</label>
                                            <input name="jumlahTanggunganDibayar" type="number" class="form-control" id="tanggunganDibayar" min="1" required> 
                                        </div> 
                                    </div>

                                    <div class="col">

                                        <div class="mb-3">
                                            <label for="kumpulZakat_text" class="col-form-label">Jumlah Tanggungan:</label>
                                            <input name="jumlahTanggungan" type="text" class="form-control" id="kumpulZakat_text" required>
                                        </div> 

                                        <div class="mb-3">
                                            <label id="labelFor_kumpulZakat_text2" for="kumpulZakat_text2" class="col-form-label">Bayar (Kg/Rp):</label>
                                            <input name="" type="text" class="form-control" id="kumpulZakat_text2" required> 
                                        </div>  

                                        <script>
                                            $(document).ready(function(){
                                                $('#kumpulZakat_select').change(function(){ 
                                                    var namaMuzakki = $(this).val();
                                                    $.ajax({
                                                        url: '{{ url("get_jumlah_tanggungan_muzakki") }}' + '/' + namaMuzakki ,
                                                        success: function(response) {   
                                                            $('#kumpulZakat_text').val(response.jumlahTanggungan); 
                                                        },
                                                        error: function(xhr) {
                                                            console.log(xhr.responseText);
                                                        }
                                                    });
                                                });
                                            });
                                        </script>

                                        <script>
                                            $(document).ready(function() {
                                                var jenisBayar;
                                                $('#kumpulZakat_select2').on('input', function(){
                                                    jenisBayar = $(this).val();
                                                    jumlahBayar = $('#kumpulZakat_text2').val(); 
                                                    helperJTD = $('#helperJTD');
                                                    jumlahTanggunganDibayar = $('#tanggunganDibayar');
                                                    valueJenisBayar = $('#kumpulZakat_select2').val();

                                                    if (jenisBayar == 'Beras'){
                                                        $('#labelFor_kumpulZakat_text2').html('Beras (Kg)'); 
                                                        $('#kumpulZakat_text2').attr('name', 'bayarBeras'); 
                                                        if (jumlahBayar){
                                                            $('#kumpulZakat_text2').val(jumlahBayar/16000);
                                                        }
                                                    } else if (jenisBayar == 'Uang'){
                                                        $('#labelFor_kumpulZakat_text2').html('Uang (Rp)');
                                                        $('#kumpulZakat_text2').attr('name', 'bayarUang');
                                                        if (jumlahBayar){
                                                            $('#kumpulZakat_text2').val(jumlahBayar*16000);
                                                        }
                                                    }

                                                    if (valueJenisBayar !== ''){
                                                        helperJTD.addClass('hidden');
                                                        jumlahTanggunganDibayar.removeAttr('readonly');
                                                    }
                                                }) 

                                                // if user clicked before what planned [BERAS/UANG]
                                                $('#kumpulZakat_text2').on('click', function(){ 
                                                    BerasUang = $('#kumpulZakat_text2');
                                                    valueBerasUang = $('#kumpulZakat_text2').val();
                                                    helperJTD2 = $('#helperJTD2');

                                                    if (valueBerasUang === ''){
                                                        helperJTD2.removeClass('hidden');
                                                    } else {
                                                        helperJTD2.addClass('hidden'); 
                                                    } 
                                                })
                                                $('#kumpulZakat_text').on('click', function(){ 
                                                    BerasUang = $('#kumpulZakat_text');
                                                    valueBerasUang = $('#kumpulZakat_text').val();
                                                    helperJTD2 = $('#helperJTD2');

                                                    if (valueBerasUang === ''){
                                                        helperJTD2.removeClass('hidden');
                                                    } else {
                                                        helperJTD2.addClass('hidden'); 
                                                    } 
                                                })

                                                // if user clicked before what planned [JUMLAH TANGGUNGAN DIBAYAR]
                                                $('#tanggunganDibayar').on('click', function(){ 
                                                    JenisBayar = $('#kumpulZakat_select2');
                                                    valueJenisBayar = $('#kumpulZakat_select2').val();
                                                    helperJTD = $('#helperJTD');

                                                    BerasUang = $('#kumpulZakat_text2');
                                                    valueBerasUang = $('#kumpulZakat_text2').val();
                                                    helperJTD2 = $('#helperJTD2');

                                                    if (valueJenisBayar !== 'Beras' && valueJenisBayar !== 'Uang'){
                                                        helperJTD.removeClass('hidden');
                                                    } else {
                                                        helperJTD.addClass('hidden');
                                                        jumlahTanggunganDibayar.removeAttr('readonly');
                                                    } 

                                                    if (valueBerasUang !== ''){ 
                                                        helperJTD2.addClass('hidden'); 
                                                    } 
                                                })
                                                
                                                // fixed
                                                $('#tanggunganDibayar').on('input', function() {
                                                    var answ = $('#tanggunganDibayar').val();  

                                                    if (jenisBayar == 'Beras'){
                                                        $('#kumpulZakat_text2').val(2.5*answ);
                                                    } else if (jenisBayar == 'Uang') {
                                                        $('#kumpulZakat_text2').val(40000*answ);
                                                    }
                                                })
                                            });
                                        </script> 

                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Buat</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    

                    <script>
                                                    $(document).ready(function(){
                                                        $('#kumpulZakat_select').change(function(){ 
                                                            var namaMuzakki = $(this).val();
                                                            $.ajax({
                                                                url: '{{ url("get_jumlah_tanggungan_muzakki") }}' + '/' + namaMuzakki ,
                                                                success: function(response) {   
                                                                    $('#kumpulZakat_text').val(response.jumlahTanggungan); 
                                                                },
                                                                error: function(xhr) {
                                                                    console.log(xhr.responseText);
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>

                                                <script>
                                                    $(document).ready(function() {
                                                        var jenisBayar;
                                                        $('#kumpulZakat_select2').on('input', function(){
                                                            jenisBayar = $(this).val();
                                                            jumlahBayar = $('#kumpulZakat_text2').val(); 
                                                            helperJTD = $('#helperJTD');
                                                            jumlahTanggunganDibayar = $('#tanggunganDibayar');
                                                            valueJenisBayar = $('#kumpulZakat_select2').val();

                                                            if (jenisBayar == 'Beras'){
                                                                $('#labelFor_kumpulZakat_text2').html('Beras (Kg)'); 
                                                                $('#kumpulZakat_text2').attr('name', 'bayarBeras'); 
                                                                if (jumlahBayar){
                                                                    $('#kumpulZakat_text2').val(jumlahBayar/16000);
                                                                }
                                                            } else if (jenisBayar == 'Uang'){
                                                                $('#labelFor_kumpulZakat_text2').html('Uang (Rp)');
                                                                $('#kumpulZakat_text2').attr('name', 'bayarUang');
                                                                if (jumlahBayar){
                                                                    $('#kumpulZakat_text2').val(jumlahBayar*16000);
                                                                }
                                                            }

                                                            if (valueJenisBayar !== ''){
                                                                helperJTD.addClass('hidden');
                                                                jumlahTanggunganDibayar.removeAttr('readonly');
                                                            }
                                                        }) 
                                                    });
                                                </script> 

                </div>
            @endif
        </div>

    </div>
</div>

<div class="card p-2 container_table mt-5">
    <table class="table table-hover">
        @if ($datas->isEmpty() != true)
        <thead>
            <tr class="header-row">
                <th scope="col">No</th> 
                <th scope="col">Nama</th>
                <th scope="col">Tanggungan</th>
                <th scope="col">Tanggungan Dibayar</th>
                <th scope="col">Jenis Bayar</th>
                <th scope="col">Bayar</th>
                @if (auth()->check()) 
                    <th>Edit</th>
                    <th>Terima</th>
                    <th>Hapus</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
                $totalUang = 0;
                $totalBeras = 0;
            @endphp
            
            @foreach($datas as $key=>$value)
            <tr class="row_animate">
                <th scope="row">{{ $i++ }}</th> 
                <td>{{ $value->namaKK }}</td>
                <td>{{ $value->jumlahTanggungan }}</td>
                <td>{{ $value->jumlahTanggunganDibayar }}</td>
                <td>{{ $value->jenisBayar }}</td>
                @if ($value->bayarUang != null)
                    <td>{{ @money($value->bayarUang) }}</td>
                    @php
                        $totalUang += $value->bayarUang
                    @endphp
                @else
                    <td>{{ $value->bayarBeras }} Kg</td>
                    @php
                        $totalBeras += $value->bayarBeras
                    @endphp
                @endif

                
                @if (auth()->check())  
                <td class="container_button"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{$value->id}}">Edit</button></td>

                <div class="modal fade" id="editModal{{$value->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('/zakatFitrah/pengumpulanZakat/'.$value->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="PATCH">
                                
                                <div class="row align-items-start">   
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="kumpulZakat_select_edit{{ $value->id }}" class="col-form-label">Nama:</label>
                                            <select name="namaKK" type="text" class="form-select" id="kumpulZakat_select_edit{{ $value->id }}" required autofocus>
                                                <option value="" disabled>-- select --</option>
                                                @foreach($datas1 as $key1=>$value1)
                                                    <option value="{{ $value1->namaMuzakki }}"  {{ $value->namaKK == $value1->namaMuzakki ? 'selected' : '' }}>{{ $value1->namaMuzakki }}</option> 
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="kumpulZakat_select2{{ $value->id }}" class="col-form-label">Jenis Bayar:</label>
                                            <select name="jenisBayar" type="text" class="form-select" id="kumpulZakat_select2{{ $value->id }}" required>
                                                <option value="" disabled>-- select --</option>  
                                                <option value="Beras"  {{ $value->jenisBayar == 'Beras' ? 'selected' : '' }}>Beras</option>
                                                <option value="Uang" {{ $value->jenisBayar == 'Uang' ? 'selected' : '' }}>Uang</option>
                                            </select>
                                        </div> 

                                        <div class="mb-3">
                                            <label for="tanggunganDibayar{{ $value->id }}" class="col-form-label">Jumlah Tanggungan Dibayar:</label>
                                            <input value="{{$value->jumlahTanggunganDibayar}}" name="jumlahTanggunganDibayar" type="number" class="form-control" id="tanggunganDibayar{{ $value->id }}" min="1" required>
                                        </div>
                                    </div>
                                    <div class="col">

                                        <div class="mb-3">
                                            <label for="kumpulZakat_text_edit{{ $value->id }}" class="col-form-label">Jumlah Tanggungan:</label>
                                            <input value="{{ $value->jumlahTanggungan }}" name="jumlahTanggungan" type="text" class="form-control" id="kumpulZakat_text_edit{{ $value->id }}" readonly>
                                        </div> 

                                        <div class="mb-3">
                                            <label id="labelFor_kumpulZakat_text2{{ $value->id }}" for="kumpulZakat_text2{{ $value->id }}" class="col-form-label">Bayar (Kg/Rp):</label>
                                            @if ($value->jenisBayar == 'Beras')
                                                <input value="{{ $value->bayarBeras }}" name="bayarBeras" type="text" class="form-control" id="kumpulZakat_text2{{ $value->id }}" readonly>
                                            @elseif ($value->jenisBayar == 'Uang')
                                                <input value="{{ $value->bayarUang }}" name="bayarUang" type="text" class="form-control" id="kumpulZakat_text2{{ $value->id }}" readonly>
                                            @endif
                                        </div> 

                                        <script>
                                            $(document).ready(function(){
                                                $('#kumpulZakat_select_edit{{ $value->id }}').change(function(){ 
                                                    var namaMuzakki = $(this).val(); 
                                                    $.ajax({
                                                        url: '{{ url("get_jumlah_tanggungan_muzakki") }}' + '/' + namaMuzakki ,
                                                        success: function(response) {   
                                                            $('#kumpulZakat_text_edit{{ $value->id }}').val(response.jumlahTanggungan); 
                                                        },
                                                        error: function(xhr) {
                                                            console.log(xhr.responseText);
                                                        }
                                                    });
                                                });
                                            });
                                        </script>

                                        <script>
                                            $(document).ready(function() {
                                                var jenisBayar;
                                                $('#kumpulZakat_select2{{ $value->id }}').on('input', function(){
                                                    jenisBayar = $(this).val();
                                                    jumlahBayar = $('#kumpulZakat_text2{{ $value->id }}').val(); 
                                                    helperJTD = $('#helperJTD{{ $value->id }}');
                                                    jumlahTanggunganDibayar = $('#tanggunganDibayar');

                                                    if (jenisBayar == 'Beras'){
                                                        $('#labelFor_kumpulZakat_text2{{ $value->id }}').html('Beras (Kg)'); 
                                                        $('#kumpulZakat_text2{{ $value->id }}').attr('name', 'bayarBeras'); 
                                                        if (jumlahBayar){
                                                            $('#kumpulZakat_text2{{ $value->id }}').val(jumlahBayar/16000);
                                                        }
                                                    } else if (jenisBayar == 'Uang'){
                                                        $('#labelFor_kumpulZakat_text2{{ $value->id }}').html('Uang (Rp)');
                                                        $('#kumpulZakat_text2{{ $value->id }}').attr('name', 'bayarUang');
                                                        if (jumlahBayar){
                                                            $('#kumpulZakat_text2{{ $value->id }}').val(jumlahBayar*16000);
                                                        }
                                                    } 
                                                })  
                                                
                                                // fixed
                                                $('#tanggunganDibayar{{ $value->id }}').on('input', function() { 
                                                    var answ = $('#tanggunganDibayar{{ $value->id }}').val();  

                                                    if (jenisBayar == 'Beras'){
                                                        $('#kumpulZakat_text2{{ $value->id }}').val(2.5*answ);
                                                    } else if (jenisBayar == 'Uang') {
                                                        $('#kumpulZakat_text2{{ $value->id }}').val(40000*answ);
                                                    } 
                                                })
                                            });
                                        </script> 
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-secondary">Edit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <td class="container_button">
                    <form method="POST" action="{{ url('/zakatFitrah/pengumpulanZakat/addTerima/'.$value->id) }}">
                        @csrf
                        <input value="{{ $value->bayarBeras }}" name="bayarBeras" type="hidden">
                        <input value="{{ $value->bayarUang }}" name="bayarUang" type="hidden">
                        
                        <button class="btn btn-primary" type="submit"> 
                                <a>Terima</a>
                        </button> 
                    </form>
                </td>

                <td class="container_button"><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal{{$value->id}}">Hapus</button></td>
                
                <div class="modal fade hapusModal" id="hapusModal{{$value->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">CAUTION!</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
 
                                <h5>Apakah Anda Yakin?</h5>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                
                                <form method="POST" action="{{ url('/zakatFitrah/pengumpulanZakat/'.$value->id) }}">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-secondary">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> 
                @endif
            </tr>
            @endforeach
        </tbody> 
        @else 
            <h5>Data Masih Kosong!</h5> 
        @endif
    </table>
</div> 

@endsection