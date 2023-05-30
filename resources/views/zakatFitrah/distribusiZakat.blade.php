@extends('layouts.app') 

@section('content') 

@if(Session::has('success'))
    <p class="alert alert-success mt-3" id="sixSeconds">{{ Session::get('success') }}</p>
@elseif (Session::has('failed'))
    <p class="alert alert-danger mt-3" id="sixSeconds">{{ Session::get('failed') }}</p>
@endif  

<div class="header flex">

    <div class="container_item d-flex mt-5 justify-content-between"> 
        <h1 class="title">Distribusi Zakat Fitrah Warga</h1>

        <div>
            <button class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#modal_view">Penerima</button>

            <div class="modal fade modal_nohide1" id="modal_view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Lihat Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body"> 

                            <div class="container_table">
                                @if ($datas_accepted->isEmpty() != true)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th> 
                                            <th scope="col">Nama</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">Diterima</th>
                                            <th scope="col">Hak</th>
                                            <th scope="col">Dibuat Pada</th>
                                            @if (Auth()->user())
                                                <th scope="col">Hapus</th> 
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $totalUang = 0;
                                            $totalBeras = 0;
                                            $totalUangButuh = 0;
                                            $totalBerasButuh = 0;
                                        @endphp
                                        @foreach($datas_accepted as $key3=>$value3)  
                                        <tr class="id_row_clickable row_animate">
                                            <th scope="row">{{ $i++ }}</th> 
                                            <td>{{ $value3->nama }}</td>
                                            <td>{{ $value3->kategori }}</td>
                                            <td>{{ $value3->jenisTerima }}</td>
                                            @if ($value3->jenisTerima == 'Beras')
                                                <td>{{ number_format($value3->hak/16000, 2) }} Kg</td>
                                            @else
                                                <td>{{ @money($value3->hak) }}</td>
                                            @endif
                                            @php
                                                if ($value3->jenisTerima == 'Uang'){
                                                    $totalUangButuh += $value3->hak;
                                                } else {
                                                    $totalBerasButuh += ($value3->hak / 16000);
                                                }
                                            @endphp
                                            <td>{{ $value3->updated_at->format('h:i, d/m/Y') }}</td>
                                            @if (Auth()->user())
                                            <td class="container_button">
                                                <form method="POST" action="{{ url('/zakatFitrah/distribusiZakat/'.$value3->id) }}">
                                                @csrf
                                                    <input type="hidden" name="_method" value="DELETE">   

                                                    <button type="submit" class="btn btn-primary">Hapus</button>      
                                                </form> 
                                            </td>
                                            @endif
                                        </tr> 
                                        @endforeach  
                                    </tbody> 
                                </table>
                                @else
                                <div class="card p-5"> 
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
                            <form action="{{ url('/zakatFitrah/distribusiZakat') }}" method="POST">
                            @csrf
                                    
                            <div class="row align-items-start">   
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="kumpulZakat_select" class="col-form-label">Nama:</label>
                                        <select name="nama" type="text" class="form-select" id="kumpulZakat_select" required autofocus>
                                            <option value="" disabled selected>-- select --</option>
                                            @foreach($datas1 as $key1=>$value1)
                                                <option value="{{ $value1->namaMuzakki }}">{{ $value1->namaMuzakki }}</option> 
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="kumpulZakat_text" class="col-form-label">Kategori:</label>
                                        <select name="kategori" type="text" class="form-select" id="kumpulZakat_text" required> 
                                            <option value="" disabled selected>-- select --</option>
                                            @foreach($datas2_warga as $key2=>$value2)
                                                <option value="{{ $value2->namaKategori }}">{{ $value2->namaKategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>  

                                    <div class="mb-3">
                                        <label for="input_hak" class="col-form-label">Hak:</label>
                                        <input name="hak" type="text" class="form-control" id="input_hak" type="number" required>
                                    </div> 
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
            </div> 
            @endif 
        </div>
    </div>
</div>

<div class="container_table mt-5">
    <table class="table table-hover">
        @if ($datas->isEmpty() != true)
        <thead>
            <tr class="header-row">
                <th scope="col">No</th> 
                <th scope="col">Nama</th>
                @if(Auth()->check())
                    <th scope="col">Kategori</th>
                @else
                    <th scope="col" colspan="2">Kategori</th>
                @endif
                <th scope="col">Hak</th> 
                <th scope="col">Dibuat Pada</th>
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
                $totalUangButuh = 0;
            @endphp
            
            @foreach($datas as $key=>$value)
            <tr class="row_animate">
                <th scope="row">{{ $i++ }}</th> 
                <td>{{ $value->nama }}</td>
                @if(Auth()->check())
                    <td>{{ $value->kategori }}</td>
                @else
                    <td colspan="2">{{ $value->kategori }}</td>
                @endif
                <td>{{ number_format($value->hak/16000, 2) }} Kg</td>
                @php
                    $totalUangButuh += $value->hak
                @endphp
                <td>{{ $value->created_at->format('h:i, d/m/Y') }}</td> 
                <!-- <td>{{ $value->created_at->format('h:i, d/m/Y') }}</td>  -->
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
                                <form action="{{ url('/zakatFitrah/distribusiZakat/'.$value->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="PATCH">
                                
                                <div class="row align-items-start">   
                            <div class="col">
                                <div class="mb-3">
                                    <label for="kumpulZakat_select" class="col-form-label">Nama:</label>
                                    <select name="nama" type="text" class="form-select" id="kumpulZakat_select" required autofocus>
                                        <option value="" disabled selected>-- select --</option>
                                        @foreach($datas1 as $key1=>$value1)
                                            <option value="{{ $value1->namaMuzakki }}" {{ $value->nama == $value1->namaMuzakki ? 'selected' : '' }}>{{ $value1->namaMuzakki }}</option> 
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="kumpulZakat_text{{$value->id}}" class="col-form-label">Kategori:</label>
                                        <select name="kategori" type="text" class="form-select" id="kumpulZakat_text{{$value->id}}" required> 
                                            <option value="" disabled selected>-- select --</option>
                                            @foreach($datas2_warga as $key2=>$value2)
                                                <option value="{{ $value2->namaKategori }}" {{ $value->kategori == $value2->namaKategori ? 'selected' : '' }}>{{ $value2->namaKategori }}</option>
                                            @endforeach
                                        </select>
                                </div>  

                                <div class="mb-3">
                                    <label for="input_hak{{ $value->id }}" class="col-form-label">Hak:</label>
                                    <input value='{{ $value->hak }}' name="hak" type="text" class="form-control" id="input_hak{{ $value->id }}" readonly>
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        $('#kumpulZakat_text{{$value->id}}').change(function() { 
                                            var answ = $(this).val(); 
                                            $.ajax({
                                                url: '{{ url("get_kategori_muzakki") }}' + '/' + answ,
                                                success: function(response) { 
                                                    $('#input_hak{{ $value->id }}').val(response.jumlahHak);
                                                },
                                                error: function(xhr) {
                                                    console.log(xhr.responseText);
                                                }
                                            });
                                        })
                                    })
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
                
                <td class="container_button"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#terimaModal{{$value->id}}">Terima</button></td>

                <div class="modal fade" id="terimaModal{{$value->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Terima Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                
                                <div class="row align-items-start">   
                                    <div class="col"> 
                                        <form method="POST" action="{{ url('/zakatFitrah/distribusiZakat/addTerima/'.$value->id) }}">
                                        @csrf
                                            <div class="mb-3">
                                                <label for="distZakat_select{{ $value->id }}" class="col-form-label">Jenis Bayar:</label>
                                                <select name="jenisBayar" class="form-select" id="distZakat_select{{ $value->id }}" required>
                                                    <option value="" disabled selected>-- select --</option>
                                                    <option value="Beras">Beras</option>
                                                    <option value="Uang">Uang</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label id="label_message-text-label{{ $value->id }}" for="message_text_label{{ $value->id }}" class="col-form-label">Bayar (Kg/Rp):</label>
                                                <input name="" type="text" class="form-control" id="message_text_label{{ $value->id }}" readonly>
                                            </div>

                                            <script>
                                                $(document).ready(function() {
                                                    var jenisBayar; 
                                                    $('#distZakat_select{{ $value->id }}').change(function(){
                                                        jenisBayar = $(this).val();
                                                        jumlahBayar = "{{ $value->hak }}";
                                                        if (jenisBayar == 'Beras'){ 
                                                            $('#label_message-text-label{{ $value->id }}').html('Beras (Kg)');
                                                            $('#message_text_label{{ $value->id }}').attr('name', 'bayarBeras');  
                                                            $('#message_text_label{{ $value->id }}').val(jumlahBayar/16000); 
                                                        } else if (jenisBayar == 'Uang'){
                                                            $('#label_message-text-label{{ $value->id }}').html('Uang (Rp)');
                                                            $('#message_text_label{{ $value->id }}').attr('name', 'bayarUang'); 
                                                            $('#message_text_label{{ $value->id }}').val(jumlahBayar); 
                                                        } 
                                                    });
                                                });
                                            </script>
                                        </div>
                                    
                                        <div class="col mt-2">
                                            <h4>Deskripsi</h4>
                                            <p>
                                                Silahkan pilih jenis pembayaran yang akan dikasihkan kepada mustahik.
                                            </p>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button> 
                                    <button type="submit" class="btn btn-primary">Terima</button>
                                </div> 
                            </form> 
                        </div>
                    </div>
                </div>

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
                                
                                <form method="POST" action="{{ url('/zakatFitrah/distribusiZakat/'.$value->id) }}">
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
        <div class="card p-5 mt-5"> 
            <h5>Data Masih Kosong</h5>
        </div>
        @endif
    </table>
</div>   

@endsection