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

    <table class="datatable responsiveDatatable"
        data-link="{{ route('reports.sped.nao_escrituradas', [$cnpj, $data_inicio, $data_fim]) }}"
        data-placeholder="Pesquisar na NFe">
        <thead>
            <tr>
                <th class="disabled sortable white-text" width="1%" data-orderable="false">
                    <label>
                        <input type="checkbox" class="amber" id="check-all" disabled>
                        <span> </span>
                    </label>
                </th>
                <th>Chave NFe</th>
                <th>Num. NFe</th>
                <th>CNPJ Dest.</th>
                <th>Fornecedor</th>
                <th>Data Emissão</th>
                <th>V. BC.</th>
                <th>ICMS</th>
            </tr>
        </thead>
    </table>

@endsection
