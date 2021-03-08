@extends('layouts.app')

@section('header')

    <!-- Header search bar starts -->
    <div class="row">

        <div class="col s12">

            <div class="page_title">

                <div class="col s6">
                    <h5>Sped Fiscal</h5>
                </div>

                <div class="col s6">
                    <div class="input-field bordered">
                        <i class="material-icons prefix grey-text">search</i>
                        <input type="search" class="dataTable_search black-text" placeholder="Pesquisar Arquivo">
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- Header search bar Ends -->

@endsection

@section('container')

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
