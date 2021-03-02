@extends('layouts.app')

@section('container')
    {{-- <div class="row">
        <div class="col s6">
            <div class="input-field">
                <i class="material-icons prefix">search</i>
                <label for="">Pesquisar arquivo</label>
                <input type="search" class="dataTable_search black-text">
            </div>
        </div>
    </div> --}}

    <!-- Header search bar starts -->
    <div class="row">

        <div class="col s6">
            <div class="page_title">
                {{-- <button data-href="{{ route('reports.sped') }}"
                    class="btn btn-floating waves-effect transparent white-text bt_ac btn-flat mr-1" data-tooltip="Voltar">
                    <i class="material-icons black-text">arrow_back</i>
                </button> --}}
                <h5>Sped Fiscal</h5>
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

        <table class="datatable responsiveDatatable" data-link="{{ url('reports/sped') }}"
            data-placeholder="Pesquisar na NFe">
            <thead>
                <tr>
                    <th class="disabled" width="1%" data-orderable="false">
                        <label>
                            <input type="checkbox" class="amber" id="check-all" disabled>
                            <span> </span>
                        </label>
                    </th>
                    <th class="center-align" data-class="left-align">Fornecedor</th>
                    <th class="center-align" data-class="center-align">CNPJ</th>
                    <th class="center-align" data-class="center-align">Data inicial</th>
                    <th class="center-align" data-class="center-align">Data final</th>
                    <th class="center-align" data-class="center-align">Perfil</th>
                </tr>
            </thead>
        </table>

    </div>

@endsection
