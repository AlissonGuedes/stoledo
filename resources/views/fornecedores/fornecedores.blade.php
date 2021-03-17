@extends('_layouts.app')

@section('page-title', 'Fornecedores')

@section('header')

    {{-- <button data-href="{{ route('dashboard') }}" class="btn btn-floating waves-effect transparent white-text btn-flat"
        data-tooltip="Voltar">
        <i class="material-icons">arrow_back</i>
    </button> --}}

    @parent

@endsection

@section('placeholder', 'Pesquisar fornecedor')

@section('search')
    @parent
@endsection

@section('container')

    <table class="datatable responsiveDatatable" data-link="{{ url('reports/fornecedores') }}"
        data-placeholder="Pesquisar Fornecedor">
        <thead>
            <tr>
                <th data-clickable="false" width="1%" data-orderable="false">
                    <label>
                        <input type="checkbox" class="light-blue" id="check-all">
                        <span> </span>
                    </label>
                </th>
                <th style="width: 40%">Nome</th>
                <th style="width: 15%">CNPJ</th>
                <th style="width: 15%">Qtd. Notas</th>
                <th style="width: 15%">V. Total Aquisições</th>
                <th style="width: 15%" data-orderable="false">Ação</th>
            </tr>
        </thead>
    </table>

@endsection
