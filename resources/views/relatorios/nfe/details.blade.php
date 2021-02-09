@extends('layouts.app')

@php
if (!isset($row)):
    header('Location: ' . url('reports/nfe'));
    die();
endif;
@endphp

@section('container')

    <!-- Header search bar starts -->
    <div class="page_title">

        <button data-href="{{ route('reports.nfe') }}"
            class="btn btn-floating waves-effect transparent white-text bt_ac btn-flat mr-1" data-tooltip="Voltar">
            <i class="material-icons black-text">arrow_back</i>
        </button>

        <h5>{{ cnpj($row->cnpj) }} - {{ $row->nome }} </h5>

    </div>

    <div class="row">

        <div id="dadosnfe" class="col s12 mt-3 mb-3">

            <h5>

                <button
                    data-href="{{ route('reports.fornecedores.baixar_xls', ['cnpj' => $row->cnpj, 'nfe' => $row->chNFe]) }}"
                    target="_self" class="btn btn-floating waves-effect blue lighten-3 white-text bt_ac btn-flat mr-1"
                    data-tooltip="Baixar para arquivo XLS">
                    <i class="material-icons black-text">download</i>
                </button>

                Informações da Nota Fiscal - {{ $row->nNF }}-{{ $row->serie }}

            </h5>

            <table>

                <thead>
                    <tr>
                        <th>Chave NFe</th>
                        <th>Número da NF</th>
                        <th>Data de Emissão</th>
                        <th>Tipo de Pagamento</th>
                        <th>Valor</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>{{ $row->idNFe }} </td>
                        <td>{{ $row->nNF }}-{{ $row->serie }}</td>
                        <td>{{ date('d/m/Y H:i:s', strtotime($row->dhEmi)) }} </td>
                        <td>{{ $row->tPag }}</td>
                        <td>R$ {{ number_format($row->vPag, 2, ',', '.') }} </td>
                    </tr>
                </tbody>

            </table>

        </div>

        <div id="duplicatas" class="black-text">

            @php
                $nfe_model = new App\Models\NFeModel();
                $duplicatas = $nfe_model->getDuplicatasByNFe('NFe' . $row->chNFe);
            @endphp

            @if ($duplicatas->count() > 0)


                <div class="row">
                    <div class="col">
                        <h5 class="col s12">Duplicatas</h5>
                    </div>
                </div>

                <div class="row">

                    <div class="col s12">

                        <table>

                            <thead>
                                <tr>
                                    <th>Número da duplicata</th>
                                    <th>Vencimento</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($duplicatas as $dup)
                                    <tr>
                                        <td> {{ $dup->nDup }} </td>
                                        <td> {{ date('d/m/Y', strtotime($dup->dVenc)) }} </td>
                                        <td> R$ {{ number_format($dup->vDup, 2, ',', '.') }} </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>

                </div>

            @else

                <p class="col s12">Não existem duplicatas para esta nota fiscal</p>

            @endif

        </div>

    </div>
@endsection
