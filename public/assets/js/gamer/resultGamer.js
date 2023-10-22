$(function() {

    const id = $('#gamer-table').data('id');

    $('#gamer-table').DataTable({
        "language": {
                "url": "/assets/js/spanish.json"
        },
        processing: false,
        responsive: true,
        serverSide: true,
        ajax: `/auth/gamer/${id}`,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
            { data: 'name', name: 'name'},
            { data: 'questDesc', name: 'questDesc'},
            { data: 'contDesc', name: 'contDesc'},
            { data: 'value', name: 'value'},
        ],
        order: [[ 1, "asc" ]],
        pageLength: 8,
        lengthMenu: [2, 4, 6, 8, 10],
    });
});

function Cargar()
{
    let table = $('#gamer-table').DataTable();
    table.ajax.reload();
}

/*let gamer_id = $('.gamerId').data('id');
let categ_id = $(".categId").data('id');

let celdValue = $(".celdValue").text();

let subcadenas = celdValue.match(/.{1,2}/g);

// Convierte las subcadenas en números y crea un array
let arr = subcadenas.map(subcadena => parseInt(subcadena, 10));

if(gamer_id > 0 ){
    guardarDatos(gamer_id, categ_id, celdValue);
}

// Función para guardar los datos mediante AJAX
function guardarDatos(gamer_id, categ_id, celdValue) {
    
    let route = `/saveResultsGamer`;

    let formData = {

        'value': arr,
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
}*/