@extends('layouts.app')

@section('container')

    <div class="row">
        <div class="col s6">
            <div class="input-field">
                <i class="material-icons prefix">search</i>
                <label for="">Pesquisar NF-e</label>
                <input type="search" class="dataTable_search black-text">
            </div>
        </div>
    </div>

    <table class="datatable responsiveDatatable" data-link="{{ route('reports.nfe.view') }}" data-placeholder="Pesquisar na NFe">
        <thead>
            <tr>
                <th class="disabled sortable white-text" width="1%" data-orderable="false">
                    <label>
                        <input type="checkbox" class="amber" id="check-all">
                        <span> </span>
                    </label>
                </th>
                <th>Chave NFe</th>
                <th>NFe/Série</th>
                <th>CNPJ</th>
                <th>Emitente</th>
                <th>V. Orig</th>
                <th>Base de Cálculo</th>
                <th>ICMS</th>
            </tr>
        </thead>
    </table>

@endsection
