@extends('layouts.principal')

@section('title', 'Resultados')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Resultados y respuestas participante</h6>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered text-center" id="gamer-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th colspan="6">Resultados por pregunta</th>
                    </tr>
                    <th>#</th>
                    <th>Categoria</th>
                    <th>Ver Participantes</th>
                </tr>
                </thead>
            </table>
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
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    
    <script>
        $(function() {

            $('#gamer-table').DataTable({
                "language": {
                        "url": "/assets/js/spanish.json"
                },
                dom: '<"top"Bflr>t<"bottom"ip>',
                buttons: [
                    {
                        text: '<i class="fas fa-file-excel" title="Exportar a Excel"></i>',
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [0, 1] // Indices de las columnas a exportar (0 y 3 en este caso)
                        },
                        className: 'btn btn-success', // Agregar la clase btn-success al botón de EXCEL

                    },
                    {
                        text: '<i class="fas fa-file-pdf" title="Exportar a PDF"></i>',
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1] // Indices de las columnas a exportar (0 y 3 en este caso)
                        },
                        className: 'btn btn-danger', // Agregar la clase btn-success al botón de PDF

                    },
                ],
                processing: false,
                responsive: true,
                serverSide: true,
                ajax: '/auth/categories/gamer',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
                    { data: 'name', name: 'name'},
                    { data: 'details', name: 'details'},
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

        // Mostrar Typedisease
        function Mostrar(btn)
        {
          let route = "typeDiseases/"+btn.value;
        
          $.get(route)
          .then(response => {

              $("#exampleModalLabel").text(response.types.name);
              $("#typeDesc").text(response.types.description);

          })
          .catch(error => {
              // handle error
              console.log(error);
          });
  

        }

        // Eliminar Disease
        function Delete(btn)
        {
          let route = "diseases/"+btn.value;
          let note = confirm('¿Esta seguro que desea eliminar enfermedad seleccionada?');

          if(note){

            $.ajax({ 
              url: route, 
              type: 'DELETE', 
              dataType: 'json', 
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} 
            })
            .then(response => {

                Cargar();

            })
            .catch(error => {
                // handle error
                console.log(error);
            });
            
          }

        }
    </script>
@endpush
