@extends('layouts.app')

@section('content')
    <div class="container_zakatFitrah laporan ringkasan">

        @if(Session::has('success'))
            <p class="alert alert-success section" id="sixSeconds">{{ Session::get('success') }}</p>
        @endif 

        <div class="container_isi mt-5"> 
            <div class="header d-flex laporan justify-content-between">
                <h1 class="title mx-3">Ringkasan</h1>
                
                <div class="container_item">    
                    <button class="btn btn-primary mx-3" id="printButton1">Download</button> 
                </div> 
            </div> 

            <div id="printThiss" class="card p-4 mt-5" style="background: #EEE;">
                <div class="d-flex flex-column justify-content-center"> 
                    <div class="d-flex flex-wrap justify-content-around gap-4 w-100 mt-4">
                        <div class="btn btn-info">Fakir: {{ $datas['fakir'] }}</div>
                        <div class="btn btn-info">Miskin: {{ $datas['miskin'] }}</div>
                        <div class="btn btn-info">Mampu: {{ $datas['mampu'] }}</div>
                        <div class="btn btn-info">Amil: {{ $datas['amil'] }}</div>
                        <div class="btn btn-info">Muallaf: {{ $datas['muallaf'] }}</div>
                        <div class="btn btn-info">Riqab: {{ $datas['riqab'] }}</div>
                        <div class="btn btn-info">Gharim: {{ $datas['gharim'] }}</div>
                        <div class="btn btn-info">Fi Sabilillah: {{ $datas['fiSabilillah'] }}</div>
                        <div class="btn btn-info">Ibnu Sabil: {{ $datas['ibnuSabil'] }}</div>
                        <div class="btn btn-info">Lainnya: {{ $datas['lainnya'] }}</div>
                    </div>
                </div>

                <div class="d-flex flex-column justify-content-center"> 
                    <div class="d-flex flex-wrap justify-content-around gap-4 w-100 mt-4">
                        <div class="btn btn-primary">Total Beras: {{ $datas['result']->totalBeras }} Kg</div>
                        <div class="btn btn-primary">Total Uang: {{ @money($datas['result']->totalUang) }}</div> 
                        <div class="btn btn-primary">Total Muzakki: {{ $datas['muzakki'] }}</div>
                        <div class="btn btn-primary">Total Tanggungan: {{ $datas['tanggungan'] }}</div> 
                    </div>
                </div>
            </div>

            <style>
                .justify-content-around .btn {
                    padding: 1.5vh 3vw;
                    font-size: 1.5rem;
                    color: white;
                    transition: 0.5s;
                }
                .justify-content-around .btn:hover {
                    color: white;
                    scale: 1.05;
                    transition: 0.5s;
                }
            </style>

        </div> 
 
        <script>
            $(document).ready(function() {
                $('#printButton1').click(function() {
                    $('#printThiss').printThis({
                        pageTitle: "Ringkasan Laporan", 
                        filename: "example.pdf", 
                    });
                })
            })
        </script>
    </div>
</div>
@endsection