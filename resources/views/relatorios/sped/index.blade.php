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

    <table class="datatable responsiveDatatable" data-link="{{ url('reports/sped/nao_escrituradas') }}"
        data-placeholder="Pesquisar na NFe">
        <thead>
            <tr>
                <th class="disabled sortable white-text" width="1%" data-orderable="false">
                    <label>
                        <input type="checkbox" class="amber" id="check-all" disabled>
                        <span> </span>
                    </label>
                </th>
                <th>Fornecedor</th>
                <th>CNPJ</th>
                <th>Data inicial</th>
                <th>Data final</th>
                <th>Perfil</th>
            </tr>
        </thead>
    </table>

@endsection
