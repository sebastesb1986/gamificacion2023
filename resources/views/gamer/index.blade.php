@extends('layouts.principal')

@section('title', 'Resultados')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Resultados y respuestas participante: {{ ucfirst($gamerName) }}</h6>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered text-center" data-id="{{ $id }}" id="gamer-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th colspan="6">Resultados por pregunta</th>
                    </tr>
                    <th>#</th>
                    <th>Categoria</th>
                    <th>Pregunta</th>
                    <th>Calificación</th>
                    <th>Valor</th>
                </tr>
                </thead>
            </table>
        </div><br>

        <div class="table-responsive">
            @include('gamer.details')
        </div>
    </div>
</div>
@endsection

@push('styles')
    <!-- Style Datatables -->
    <link href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
      .typeDisease{
        text-align: justify;
        text-justify: inter-word;
      }
    </style>
@endpush

@push('scripts')
    <!-- Datatables -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/gamer/resultGamer.js') }}" type="text/javascript"></script>
@endpush
