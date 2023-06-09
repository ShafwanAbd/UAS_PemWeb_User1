@extends('layouts.app')

@section('content') 
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top: 15vh;">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <style> 
                    .card-header {
                        color: white;
                        background: rgb(0,68,167);
                        background: linear-gradient(40deg, rgba(0,68,167,1) 0%, rgba(112,170,255,1) 34%, rgba(13,110,253,1) 100%);
                    }
                </style>

                <div class="card-body">
                    <div class="d-flex justify-content-between p-5"> 
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h3>Ayo Bayar Zakat Fitrah</h3>

                        <div>
                            <div class="d-flex gap-2">
                                <a href="{{url('/zakatFitrah/dataMuzakki')}}" class="btn btn-primary">Zakat Fitrah</a>
                                <a href="{{url('/laporan/ringkasan')}}" class="btn border-2 border-primary text-primary">Laporan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
@endsection
