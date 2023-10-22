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
    <script>
        let count =  0;
let qstId = '';
let gmrId = '';
let categId = '';
let totalQu = '';
let maxValue = 0;

let atras = false;
let contVal;

 // Obtener preguntas
function question(count){

    $.get("/showQuestion/"+ count, (response) => {

        const quest = response.question;
        const totalQ = response.totalQuest;

        qstId = quest.id;
        totalQu = totalQ;

        $('#exampleModalLabel').html(quest.category.id + ". "+ quest.category.name);
        $('.description').html("¿" + quest.description +"?");

        if(atras == true){
            this.answerGamer(gmrId, qstId);
        }
        else
        {
            this.answer()
        }
                 
    });

}

// Obtener respuestas
function answer(contVal){

    $.get("/getContent", (response) => {

        const content = response.content;
        let cnt = '';

        content.forEach((element) => {

            const isChecked = (element.value === contVal || element.value === 1) ? 'checked' : '';

            cnt += `<div class="form-check form-check-inline">
                    <input class="form-check-input inlineRadio1" type="radio" name="content_id" id="inlineRadio${element.value}" value="${element.value}" ${isChecked}>
                    <label class="form-check-label" for="inlineRadio${element.value}">${element.description}</label>
                </div>`;

        });

        $('.rbtn').html(cnt);


    });

}

function answerGamer(gmrId, qstId){

    $.get('/getContentAns/'+ gmrId + '/'+ qstId, (response) => {

        let content = response.answers;
    
        
        content.forEach((element) => {

          contVal = element.content.value;

        });
        
        this.answer(contVal);
   
    });

}

// Guardar datos gamer que comienza la encuesta
function guardar() {
    count++;
    this.question(count);

    let route = '/people';
    let inputName = $('#inputName');

    if ($.trim(inputName.val()) === '') {
        $('#name-error').text('Por favor dime tu nombre');
        inputName.focus();
        return; 
    }
    else{
        $('#name-error').text('');
        $('#myModal').modal({backdrop: 'static', keyboard: false});
    
        let r = '<button type="button" id="atras" class="btn btn-primary atras" title="Atrás" onclick="questionRTN(event)" disabled><i class="fa fa-arrow-left" aria-hidden="true"></i></button>'+
                '<button type="button" id="siguiente" class="btn btn-primary siguiente" title="Siguiente" onclick="questionGMR(event)"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>'+
                '<button type="button" id="final" class="btn btn-success finalizar" title="Finalizar" onclick="saveResult(event)"disabled><i class="fa fa-check" aria-hidden="true"></i></button>';

        $(".modal-footer").html(r); 

        // let conf= confirm("¿Desea desmatricular completamente al estudiante");

        let ajax_data = {

            name: $('#inputName').val(),
            grade: $('#inputGrade').val(),
            section: $('#inputSection').val(),
        
        };

        //if(conf){
        $.ajax({
            url: route,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            dataType: 'json',
            data: ajax_data,
        }).then(response => {

            gmrId = response.gamer.id
    
        })
        .catch(error => {
            // handle error
        });
    }
    //}

}

// Guardar la respuesta de un gamer para cada pregunta y avanzar a la siguiente pregunta
function questionGMR(event){

    atras = false;

    $(".finalizar").prop('disabled', false);

    if (count < totalQu) {
        count++;
    } else if (count === totalQu) {

        $(".siguiente").prop('disabled', true);
        

    }
    
    this.question(count);

    (count > 1) ? $(".atras").prop('disabled', false) : $(".atras").prop('disabled', true);

    let route = '/saveAnswer';

    let ajax_data = {

        question_id: qstId,
        content_id: $('input[name="content_id"]:checked').val(),
        gamer_id: gmrId

    };

    //if(conf){
    $.ajax({
    url: route,
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    type: 'POST',
    dataType: 'json',
    data: ajax_data,
    }).then(response => {


    })
    .catch(error => {
    // handle error
    });
}

// Retroceder a la pregunta anterior
function questionRTN(event){

    atras = true;
    $(".siguiente").prop('disabled', false);
    event.preventDefault();
    count--;
    this.question(count);


    (count <= 1) ? $(".atras").prop('disabled', true) : $(".atras").prop('disabled', false);
    
}

// Mostrar resultados Gamer Encuesta
function saveResult()
{
    $('#myModal').modal('toggle');
    

    $.get("/showResultGamer/"+ gmrId, (response) => {

        const categorySums = response.categorySums;
        const categoryName = response.categoryName;
        const gamerName = response.gamerName;
        const categoryDescriptions = response.categoryDescriptions;
        let maxCategorySum = response.maxCategorySum;
        let maxCategoryname = response.maxCategoryName;
        
        const sumValues = Object.values(categorySums);
        
        const areSumsEqual = new Set(sumValues).size === 1;

        Object.keys(categorySums).forEach((categoryName) => {
            const sum = categorySums[categoryName];

            if(sum > maxCategorySum){

                maxCategorySum = sum;
                maxCategoryname = categoryName;
                categId = categoryName;
                maxValue = sum

            }

        });
            
        (areSumsEqual == true) ? 'De las caracteristicas de un participante tiene de todo un poco!'
                        : 'Posee las caracteristicas de un tipo de participante:' ;
                        
        // Crear una variable para acumular los resultados
        let resultAlerts = [];

        Object.keys(categorySums).forEach((categoryName) => {
            const sum = categorySums[categoryName];

            if (sum === maxCategorySum) {
                let resultAlert = '<b>'+categoryName+'</b>'+': '+ categoryDescriptions[categoryName];
                resultAlerts.push(resultAlert);
            }
        });

        if (resultAlerts.length > 0) {

            $('.cover-container').html('');
             // GUARDAR
             this.guardarDatos(gmrId, categId, maxValue);
            // Mostrar todos los resultados acumulados en el diálogo Swal
            Swal.fire({
                icon: 'info',
                title: '<b>' + gamerName + '</b>' + ' ' + 'posees las características de un tipo de participante:',
                html: resultAlerts.join('<br>'),
                confirmButtonText: 'Aceptar',
            })
            .then((result) => {
               
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'Super! gracias por participar '+ '<b>'+ gamerName + '</b>',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false,
                    });  
                
                    setTimeout(() => {
                        window.location.href = "/";
                    }, 3000);
                } 
            });
        }

    });
 
}

// Función para guardar los datos mediante AJAX
function guardarDatos(gamer_id, categ_id, maxValue) {
  
    let route = `/saveResultsGamer`;

    let formData = {

        'value': maxValue,
        'gamer_id': gamer_id,
        'category_id': categ_id

    };
    $.ajax({
        url: route,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        dataType: 'json',
        data: formData,
    success: function(response) {
        console.log("Datos guardados automáticamente");
    },
    error: function(xhr, status, error) {
        console.error("Error al guardar los datos: " + error);
    }
    });
}

    </script>
@endpush