@extends('layouts.app')

@php
if (!isset($row)):
    header('Location: ' . url('reports/fornecedores'));
    die();
endif;
@endphp

@section('container')

    <!-- Header search bar starts -->
    <div class="page_title">

        <button data-href="{{ route('reports.fornecedores') }}"
            class="btn btn-floating waves-effect transparent white-text bt_ac btn-flat mr-1" data-tooltip="Voltar">
            <i class="material-icons black-text">arrow_back</i>
        </button>

        <h5>{{ cnpj($row->cnpj) }} - {{ $row->nome }}</h5>

    </div>
    <!-- Header search bar Ends -->

    <div class="row">

        <div id="dadosnfe" class="col s12 mt-3 mb-3">

            <table class="datatable" data-link="{{ url('reports/fornecedores') }}">

                <thead>
                    <tr>
                        <th class="disabled sortable white-text" width="1%" data-orderable="false">
                            <label>
                                <input type="checkbox" class="amber" id="check-all" disabled>
                                <span> </span>
                            </label>
                        </th>
                        <th>CNPJ</th>
                        <th>Destinatário</th>
                        <th>Número Danfe</th>
                        <th>V. Total Aquisições</th>
                        <th>Tipo de Pagamento</th>
                        <th>Qtd. Duplicatas</th>
                        <th data-orderable="false"></th>
                    </tr>
                </thead>

            </table>

        </div>

    </div>

@endsection
