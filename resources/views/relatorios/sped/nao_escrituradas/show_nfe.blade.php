@extends('layouts.app')

@php
if (!isset($row)):
    header('Location: ' . url('reports/nfe'));
    die();
endif;
@endphp

@section('container')


    <div class="row">

        <div class="col s9">

            <!-- Header search bar starts -->
            <div class="page_title">

                <button data-href="{{ route('reports.sped.nao_escrituradas', [$cnpj, $data_inicio, $data_fim]) }}"
                    class="btn btn-floating waves-effect transparent white-text btn-flat mr-1" data-tooltip="Voltar">
                    <i class="material-icons black-text">arrow_back</i>
                </button>

                <h5>{{ cnpj($cnpj) }} - {{ strtoupper($row->nome_razao_social_emit) }} </h5>

            </div>

        </div>

    </div>

    <div class="row">

        <div id="dadosnfe" class="col s12 mt-3 mb-3">

            <h5>

                <button data-href="{{ route('reports.sped.nao_escrituradas.baixar_xls', $nfe) }}" target="_self"
                    class="btn btn-floating waves-effect blue lighten-2 black-text mr-1 left" data-tooltip="Excel">
                    <i class="material-icons left black-text">download</i>
                </button>

                <button class="btn btn-floating waves-effect red lighten-2 black-text modal-trigger mr-1"
                    data-toggle="modal" data-target="modal-nfe" data-tooltip="PDF">
                    <i class="material-icons left black-text">picture_as_pdf</i>
                </button>

                Informações da Nota Fiscal - {{ $row->numero }}-{{ $row->serie }}

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
                        <td>{{ $row->chave_de_acesso }} </td>
                        <td>{{ $row->numero }}-{{ $row->serie }}</td>
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

    <!-- Modal Structure -->
    <div id="modal-nfe" class="modal">
        <div class="modal-content">
            @php $file = '../../../../../../storage/app/public/' . $pdf; @endphp
            @if (file_exists(storage_path('app/public/' . $pdf)))
                <embed src="{{ $file }}" frameborder="0">
            @endif
        </div>

        <div class="modal-footer">
            <button type="button" class="modal-close waves-effect waves-green btn-flat">
                <i class="material-icons left">close</i>
                Fechar
            </button>
        </div>
    </div>

    <style>
        .modal {
            z-index: 1003;
            top: 1% !important;
            left: 0% !important;
            right: 0% !important;
            max-height: 90%;
            margin: auto;
            bottom: 0;
        }

        .modal-content {
            padding: 0 !important;
        }

        embed {
            width: 100%;
            height: calc(100vh - 160px);
            position: ;
            left: 0;
            right: 0;
        }

    </style>
@endsection
