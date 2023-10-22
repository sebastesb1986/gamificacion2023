@extends('layouts.welcome')

@section('title', 'Bienvenido')

@section('content')


<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">¿Quien eres?</h3></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register.people') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGrade">¿De que grado eres?</label>
                                            </div>
                                            <select class="custom-select" id="inputGrade" name="grade">
                                            @php
                                                $nombres = [6 => 'Sexto', 7 => 'Septimo', 8 => 'Octavo', 9 => 'Noveno', 10 => 'Decimo', 11 => 'Once'];
                                            @endphp
                                                @for($i=6; $i<=11; $i++)
                                                    <option value="{{ $nombres[$i] }}" {{ ($i == 6) ? 'selected' : '' }}>{{ $nombres[$i] }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputSection">¿A que sección perteneces?</label>
                                            </div>
                                            <select class="custom-select" id="inputSection" name="section">
                                                <option value="A" selected>A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon3">¿Como te llamas?</span>
                                    </div>
                                    <input type="text" class="form-control" id="inputName" name="name" aria-describedby="basic-addon3" autofocus>
                                </div>
                                <div id="name-error" class="text-danger"></div>
                            </div>
                            
                            <div class="mt-4 mb-0">
                                <div class="d-grid">
                                    <button class="btn btn-success btn-block" type="button" onclick="guardar()" title="Comenzar!">
                                        <i class="fa fa-gamepad" aria-hidden="true"></i>
                                    </button>
                            </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@include('survey.modal')

@endsection

@push('styles')
<link href="{{ secure_asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ secure_asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/gamer/gamer.js') }}" type="text/javascript"></script>
@endpush