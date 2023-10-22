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
        const categoryIds = response.categoryIds;
        let maxCategorySum = response.maxCategorySum;
        let maxCategoryname = response.maxCategoryName;
        let maxCategoryId = response.maxCategoryId
        
        const sumValues = Object.values(categorySums);
        
        const areSumsEqual = new Set(sumValues).size === 1;

        Object.keys(categorySums).forEach((categoryName) => {
            const sum = categorySums[categoryName];
            const ids = categoryIds[categoryName];

            if(sum > maxCategorySum){

                maxCategorySum = sum;
                maxCategoryname = categoryName;
                maxCategoryId = ids;

            }

        });
            
        (areSumsEqual == true) ? 'De las caracteristicas de un participante tiene de todo un poco!'
                        : 'Posee las caracteristicas de un tipo de participante:' ;
                        
        // Crear una variable para acumular los resultados
        let resultAlerts = [];

        Object.keys(categorySums).forEach((categoryName) => {
            let sum = categorySums[categoryName];

            let categ_id  =  categoryIds[categoryName]

            if (sum === maxCategorySum) {
                let resultAlert = '<b>'+categoryName+'</b>'+': '+ categoryDescriptions[categoryName];
                resultAlerts.push(resultAlert);
            }

            this.guardarDatos(sum, gmrId, categ_id);
            
        });


        if (resultAlerts.length > 0) {

            
            $('.cover-container').html('');
            
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
                
                    /*setTimeout(() => {
                        window.location.href = "/";
                    }, 3000);*/
                } 
            });
        }

    });
 
}

// Función para guardar los datos mediante AJAX
function guardarDatos(sum, gmrId, categ_id) {
  
    let route = `/saveResultsGamer`;

    let formData = {

        'value': sum,
        'gamer_id': gmrId,
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
