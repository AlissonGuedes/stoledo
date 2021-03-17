@extends('_layouts.app')

@section('page-title', 'Título da página')

@section('header')

    <button data-href="{{ route('dashboard') }}" class="btn btn-floating waves-effect transparent white-text btn-flat"
        data-tooltip="Voltar">
        <i class="material-icons">arrow_back</i>
    </button>

    @parent

@endsection

@section('placeholder', 'Pesquisar na página')

@section('search')
    @parent
@endsection

@section('container')

    <table class="datatable responsiveDatatable" data-link="{{ url('reports/fornecedores') }}"
        data-placeholder="Pesquisar Fornecedor">
        <thead>
            <tr>
                <th class="white-text" data-clickable="false" width="1%" data-orderable="false">
                    <label>
                        <input type="checkbox" class="amber" id="check-all">
                        <span> </span>
                    </label>
                </th>
                <th>Col 1</th>
                <th>Col 2</th>
                <th>Col 3</th>
                <th>Col 4</th>
                <th data-orderable="false">Ação</th>
            </tr>
        </thead>
    </table>

@endsection
