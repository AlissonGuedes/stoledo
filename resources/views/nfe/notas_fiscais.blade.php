@extends('_layouts.app')

@section('page-title', 'Notas Fiscais' . (isset($tipo) ? ' - ' . $tipo : null))

@section('header')

    @parent

@endsection

@section('placeholder', 'Pesquisar NFe')

@section('search')
    @parent
@endsection

@section('container')


    <table class="datatable responsiveDatatable">
        <thead>
            <tr>
                <th data-clickable="false" width="1%" data-orderable="false">
                    <label>
                        <input type="checkbox" class="light-blue" id="check-all">
                        <span> </span>
                    </label>
                </th>
				<th>Chave NFe</th>
				<th>Numero/Série</th>
				<th>V. Orig</th>
				<th>V. Base de Cálculo</th>
				<th>ICMS</th>
				<th data-orderable="false"></th>
            </tr>
        </thead>
    </table>


@endsection
