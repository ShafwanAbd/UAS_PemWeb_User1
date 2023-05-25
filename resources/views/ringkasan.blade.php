@extends('layouts.app')

@section('content')
    <div class="container_zakatFitrah laporan ringkasan">

        @if(Session::has('success'))
            <p class="alert alert-success section" id="sixSeconds">{{ Session::get('success') }}</p>
        @endif 

        <div id="printThiss" class="container_isi mt-5"> 
            <div class="header flex laporan">
                <h1 class="title mx-3">Ringkasan</h1>
                
                <div class="container_item flex">    
                    <button class="btn btn-primary" id="printButton1">Download</button> 
                </div> 
            </div> 

            <div class="d-flex flex-column justify-content-center">
                <h3 class="text-center mt-5 fw-bolder">Kategori</h3>
                <div class="d-flex flex-wrap justify-content-around gap-4 w-100 mt-4">
                    <div class="btn btn-info px-5 mx-3">Fakir: {{ $datas['fakir'] }}</div>
                    <div class="btn btn-info px-5 mx-3">Miskin: {{ $datas['miskin'] }}</div>
                    <div class="btn btn-info px-5 mx-3">Mampu: {{ $datas['mampu'] }}</div>
                    <div class="btn btn-info px-5 mx-3">Amil: {{ $datas['amil'] }}</div>
                    <div class="btn btn-info px-5 mx-3">Muallaf: {{ $datas['muallaf'] }}</div>
                    <div class="btn btn-info px-5 mx-3">Riqab: {{ $datas['riqab'] }}</div>
                    <div class="btn btn-info px-5 mx-3">Gharim: {{ $datas['gharim'] }}</div>
                    <div class="btn btn-info px-5 mx-3">Fi Sabilillah: {{ $datas['fiSabilillah'] }}</div>
                    <div class="btn btn-info px-5 mx-3">Ibnu Sabil: {{ $datas['ibnuSabil'] }}</div>
                    <div class="btn btn-info px-5 mx-3">Lainnya: {{ $datas['lainnya'] }}</div>
                </div>
            </div>

            <div class="d-flex flex-column justify-content-center"> 
                <div class="d-flex flex-wrap justify-content-around gap-4 w-100 mt-4">
                    <div class="btn btn-primary px-5 mx-3">Total Beras: {{ $datas['result']->totalBeras }} Kg</div>
                    <div class="btn btn-primary px-5 mx-3">Total Uang: {{ @money($datas['result']->totalUang) }}</div> 
                    <div class="btn btn-primary px-5 mx-3">Total Muzakki: {{ $datas['muzakki'] }}</div>
                    <div class="btn btn-primary px-5 mx-3">Total Tanggungan: {{ $datas['tanggungan'] }}</div> 
                </div>
            </div>

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