@extends('_layouts.app')

@section('page-title', 'Dashboard')

@section('header')
    {{-- <button data-href="{{ route('dashboard') }}" class="btn btn-floating waves-effect transparent white-text btn-flat"
        data-tooltip="Voltar">
        <i class="material-icons">arrow_back</i>
    </button> --}}
    @parent
@endsection

{{-- @section('placeholder', 'Pesquisar') --}}

@section('search')
    {{-- @parent --}}
@endsection

@section('content')

    {{-- @if (shell_exec())

	Arquivo sendo importado

	@endif --}}

@endsection
