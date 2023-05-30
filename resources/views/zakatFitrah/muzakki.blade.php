@extends('layouts.app')

@section('content') 

@if(Session::has('success'))
    <p class="alert alert-success mt-3" id="sixSeconds">{{ Session::get('success') }}</p>
@elseif (Session::has('failed'))
    <p class="alert alert-danger mt-3" id="sixSeconds">{{ Session::get('failed') }}</p>
@endif  

    <div class="header flex">
        <div class="container_item d-flex mt-5 justify-content-between"> 
            <h1 class="title">Data Muzakki</h1>

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
                            <form action="{{ url('/zakatFitrah/dataMuzakki') }}" method="POST">
                            @csrf
                                    
                            <div class="row align-items-start">   
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Nama: <span style="color: red;">*</span></label>
                                        <input name="namaMuzakki" type="text" class="form-control" id="recipient-name" required autofocus>
                                    </div>

                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Jumlah Tanggungan: <span style="color: red;">*</span></label>
                                        <input name="jumlahTanggungan" type="text" class="form-control" id="message-text" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Keterangan:</label>
                                        <textarea name="keterangan" type="text" class="form-control" id="message-text"></textarea>
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

    <div class="card p-2 mt-5">
        <table class="table table-hover">
            @if ($datas->isEmpty() != true)
            <thead>
                <tr class="header-row">
                    <th scope="col">No</th> 
                    <th scope="col">Nama</th>
                    <th scope="col">Jumlah Tanggungan</th>
                    <th scope="col">Keterangan</th>

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
                    <td>{{ $value->namaMuzakki }}</td>
                    <td>{{ $value->jumlahTanggungan }}</td>
                    @if (isset($value->keterangan))
                    <td>{{ $value->keterangan }}</td>
                    @else
                    <td>-</td>
                    @endif

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
                                    <form action="{{ url('/zakatFitrah/dataMuzakki/'.$value->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="PATCH">
                                    
                                    <div class="row align-items-start">   
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Nama:</label>
                                                <input value="{{ $value->namaMuzakki }}" name="namaMuzakki" type="text" class="form-control" id="recipient-name" required autofo
                                                >
                                            </div>

                                            <div class="mb-3">
                                                <label for="message-text" class="col-form-label">Jumlah Tanggungan:</label>
                                                <input value="{{ $value->jumlahTanggungan }}" name="jumlahTanggungan" type="text" class="form-control" id="message-text" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="message-text" class="col-form-label">Keterangan:</label>
                                                <textarea name="keterangan" type="text" class="form-control" id="message-text">{{ $value->keterangan }}</textarea>
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
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">CAUTION</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
 
                                    <h5>Apakah Kamu Yakin?</h5>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                    
                                    <form method="POST" action="{{ url('/zakatFitrah/dataMuzakki/'.$value->id) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-secondary">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif()
                </tr>
                @endforeach
                
                <script>
                    const targetElements = document.querySelectorAll('.row_animate');
                    
                    const observer = new IntersectionObserver(entries => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting && entry.intersectionRatio > 0) {
                                entry.target.classList.add('animate__animated');
                                entry.target.classList.add('animate__fadeIn');
                            } 
                        });
                    });
                    
                    targetElements.forEach(element => {
                        observer.observe(element);
                    });
                </script>
            </tbody>

            @else
            <div class="container_empty"> 
                <h5>Data Masih Kosong!</h5>
            </div>
            @endif
        </table>
    </div>  
@endsection