@extends('layouts.app')

@section('content')  

@if(Session::has('success'))
    <p class="alert alert-success mt-3" id="sixSeconds">{{ Session::get('success') }}</p>
@elseif (Session::has('failed'))
    <p class="alert alert-danger mt-3" id="sixSeconds">{{ Session::get('failed') }}</p>
@endif  

<div class="header flex">
    <div class="container_item d-flex mt-5 justify-content-between">  

        <h1 class="title">Kategori Mustahik</h1>

        @if (auth()->check())
        <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">Tambah</button>

        </div>

        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Buat Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/zakatFitrah/dataKategoriMustahik') }}" method="POST">
                        @csrf
                                
                        <div class="row align-items-start">   
                            <div class="col">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Nama Kategori:</label>
                                    <input name="namaKategori" class="form-control" id="message-text" required>
                                </div>

                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">Jumlah Hak:</label>
                                    <input name="jumlahHak" type="text" class="form-control" id="message-text" required> 
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
        @else
        <div>
        <button class="btn btn-primary" href="{{ url('login') }}">Tambah</button>

        </div>
        @endif
    </div>
</div>

<div class="container_table mt-5">
    <table class="table table-hover">
        @if ($datas->isEmpty() != true)
        <thead>
            <tr class="header-row">
                <th scope="col">No</th> 
                <th scope="col">Nama Kategori</th>
                <th scope="col">Jumlah Hak</th>
                @if(auth()->check())    
                <th>Edit</th>
                <th>Hapus</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1
            @endphp
            
            @foreach($datas as $key=>$value)
            <tr class="row_animate">
                <th scope="row">{{ $i++ }}</th> 
                <td>{{ $value->namaKategori }}</td> 
                <td>{{ @money($value->jumlahHak) }}</td>
                @if(auth()->check()) 

                <td class="container_button"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{$value->id}}">Edit</button></td>

                <div class="modal fade" id="editModal{{$value->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('/zakatFitrah/dataKategoriMustahik/'.$value->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="PATCH">
                                
                                <div class="row align-items-start">   
                            <div class="col">
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Nama Kategori:</label>
                                    <input value="{{ $value->namaKategori }}" name="namaKategori" class="form-control" id="message-text" required> 
                                </div>

                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">Jumlah Hak:</label>
                                    <input value="{{ $value->jumlahHak }}" name="jumlahHak" type="text" class="form-control" id="message-text" required>
                                </div>
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
                
                <td class="container_button"><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal{{$value->id}}">Hapus</button></td>
                
                <div class="modal fade hapusModal" id="hapusModal{{$value->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">CAUTION!</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body"> 

                                <h5>Apakah Kamu Yakin?</h5>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                
                                <form method="POST" action="{{ url('/zakatFitrah/dataKategoriMustahik/'.$value->id) }}">
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
        <div class="container_empty"> 
            <h5>Data Masih Kosong!</h5>
        </div>
        @endif
    </table>
</div> 

@endsection