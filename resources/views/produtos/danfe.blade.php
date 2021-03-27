@extends('nfe.danfe')

@section('page-title', cnpj($fornecedor->cnpj) . ' - ' . $fornecedor->nome)

@section('btn-back')
    <button data-href="{{ route('reports.fornecedores.notas_fiscais', $fornecedor->cnpj) }}"
        class="btn btn-floating waves-effect transparent white-text btn-flat" data-tooltip="Voltar">
        <i class="material-icons">arrow_back</i>
    </button>
@endsection

@section('search', '')
