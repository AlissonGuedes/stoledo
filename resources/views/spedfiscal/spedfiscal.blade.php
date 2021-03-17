@extends('_layouts.app')

@section('page-title', 'Sped Fiscal')

@section('header')
    @parent
@endsection

@section('placeholder', 'Pesquisar arquivo')

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
                <th style="width: 20%">Empresa</th>
                <th style="width: 15%">CNPJ</th>
                <th style="width: 20%">Contador(a)</th>
                <th style="width: 15%">Período</th>
                <th style="width: 15%" data-orderable="false">Ação</th>
            </tr>
        </thead>
    </table>

@endsection
