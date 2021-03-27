@extends('_layouts.app')

{? $tipo = request() -> route() -> parameters['tipo']; ?}
@section('page-title', cnpj($fornecedor->cnpj) . ' - ' . $fornecedor->nome)

@section('header')

    <button data-href="{{ route('reports.sped', $tipo) }}"
        class="btn btn-floating waves-effect transparent white-text btn-flat" data-tooltip="Voltar">
        <i class="material-icons">arrow_back</i>
    </button>

    @parent

@endsection

@section('placeholder', 'Pesquisar fornecedor')

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
                <th style="width: 15%">CNPJ</th>
                <th style="width: 20%">Destinatário</th>
                <th style="width: 10%">Número Danfe</th>
                <th style="width: 15%">V. Total Aquisições</th>
                <th style="width: 15%">Tipo de Pagamento</th>
                <th style="width: 10%">Qtd. Duplicatas</th>
                <th style="width: 15%" data-orderable="false"></th>
            </tr>
        </thead>
    </table>


@endsection
