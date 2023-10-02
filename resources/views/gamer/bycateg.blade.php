@extends('layouts.principal')

@section('title', 'Resultados')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Resultados y respuestas participante</h6>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered text-center" id="gamer-table" data-id="{{ $id }}" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th colspan="6">Resultados por pregunta</th>
                    </tr>
                    <th>#</th>
                    <th>Categoria</th>
                    <th>Participante</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($gmrCateg as $index => $gmc)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $gmc->category_name }}</td>
                        <td>{{ $gmc->name }}</td>    
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><br>

      
    </div>
</div>
@endsection

@push('styles')
    <!-- Style Datatables -->
    <link href="{{ secure_asset('assets/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
      .typeDisease{
        text-align: justify;
        text-justify: inter-word;
      }
    </style>
@endpush

@push('scripts')
    <!-- Datatables -->
    <script src="{{ secure_asset('assets/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ secure_asset('assets/js/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>
    
    <script>
        $(function() {

            const id = $('#gamer-table').data('id');

            $('#gamer-table').DataTable({
                "language": {
                        "url": "/assets/js/spanish.json"
                },
                processing: false,
                responsive: true,
                serverSide: true,
                ajax: `/auth/gamer/categories/${id}`,
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
                    { data: 'category_name', name: 'category_name'},
                    { data: 'name', name: 'name' },
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
