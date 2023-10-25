@php
    $areSumsEqual = count(array_unique($categorySums)) === 1; // Verificar si todas las sumas son iguales
    $first = true;
@endphp
<!-- Mostrar las sumas por categoría -->
    <!-- Mostrar las sumas por categoría -->
    
<table class="table table-bordered text-center">
    <thead class="thead-dark">
        <tr>
            <th colspan="2">Consolidado participante: {{ ucfirst($gamerName) }}</th>
        </tr>
        <tr>
            <th scope="col">Categoria</th>
            <th scope="col">Puntuación</th>
        </tr>
    </thead>
    <tbody>
        <form id="miFormulario">

            @foreach ($categorySums as $categoryName => $sum)
           
            <tr class="gamerId" data-id="{{ $id }}">
                <td>{{ $categoryName }}</td>
                <td class="celdValue">{{ $sum }}</td>
            </tr>
            @if ($sum > $maxCategorySum)
                @php
                    $maxCategorySum = $sum;
                    $maxCategoryName = $categoryName;
                @endphp
            @endif     
            @endforeach

        </form>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">
                <p class="description">
                    Posees las caracteristicas de un participante:
                </p>
                <ul class="list-unstyled">
                    @foreach ($categorySums as $categoryName => $sum)
                        @if ($sum === $maxCategorySum)
                            <li class="categId" data-id={{ $categoryIds[$categoryName]  }}>
                                <b>{{ $categoryName }}:</b> {{ $categoryDescriptions[$categoryName] }}
                            </li>
                        @endif
                    @endforeach
                </ul>
            </td> 
        </tr>
    </tfoot>
</table>
