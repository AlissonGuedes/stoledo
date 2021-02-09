@extends('layouts.app')

@section('container')

    <div class="row">
        <div class="col s6">
            <div class="input-field">
                <i class="material-icons prefix">search</i>
                <label for="">Pesquisar arquivo</label>
                <input type="search" class="dataTable_search black-text">
            </div>
        </div>
    </div>

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
                <th>Nome</th>
                <th>CNPJ</th>
                <th>Qtd. Notas</th>
                <th>V. Total Aquisições</th>
                <th data-orderable="false">Ação</th>
            </tr>
        </thead>
    </table>


@endsection
