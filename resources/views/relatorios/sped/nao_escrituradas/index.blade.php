@extends('layouts.app')

@section('container')

    <!-- Header search bar starts -->
    <div class="row">

        <div class="col s6">
            <div class="page_title">
                <button data-href="{{ url('reports/sped/' . $cnpj . '/' . $data_inicio . '-' . $data_fim) }}"
                    class="btn btn-floating waves-effect transparent white-text bt_ac btn-flat mr-1" data-tooltip="Voltar">
                    <i class="material-icons black-text">arrow_back</i>
                </button>
                <h5>{{ cnpj($cnpj) }} - {{ $row -> xNome }}</h5>
            </div>
        </div>

        <div class="col s6">
            <div class="input-field">
                <i class="material-icons prefix">search</i>
                <label for="">Pesquisar arquivo</label>
                <input type="search" class="dataTable_search black-text">
            </div>
        </div>

    </div>
    <!-- Header search bar Ends -->

    <div class="row">

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

    </div>

@endsection
