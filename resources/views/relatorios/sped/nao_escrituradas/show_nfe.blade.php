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

                <button
                    data-href="{{ url('reports/sped/' . $cnpj . '/' . $data_inicio . '-' . $data_fim . '/' . str_replace(['.', '/', '-'], '', $row->cpf_cnpj_emit)) }}"
                    class="btn btn-floating waves-effect transparent white-text btn-flat mr-1" data-tooltip="Voltar">
                    <i class="material-icons black-text">arrow_back</i>
                </button>

                <h5> {{ cnpj($cnpj) }} - {{ $row->nome_razao_social_dest }} </h5>

            </div>

            <ul class="tabs">
                <li class="tab"><a href="#nfe"></a>Título</li>
                <li class="tab"><a href="#duplicatas"></a>Duplicatas</li>
            </ul>

		</div>

    </div>

    <div id="titulo">

        <div class="row">

            <div class="col s12 mt-2">
                <h5>

                    <button data-href="{{ route('reports.sped.nao_escrituradas.baixar_xls', $nfe) }}" target="_self"
                        class="btn btn-floating waves-effect blue lighten-2 black-text mr-1 left" data-tooltip="Excel">
                        <i class="material-icons left black-text">download</i>
                    </button>

                    <button class="btn btn-floating waves-effect red lighten-2 black-text modal-trigger mr-1"
                        data-toggle="modal" data-target="modal-nfe" data-tooltip="PDF">
                        <i class="material-icons left black-text">picture_as_pdf</i>
                    </button>

                    {{-- <button class="btn btn-floating waves-effect red lighten-2 black-text modal-trigger mr-1"
                    data-href="{{ route('reports.sped.nao_escrituradas.pdf', $nfe) }}" target="_blank" data-tooltip="PDF">
                    <i class="material-icons left black-text">picture_as_pdf</i>
                </button> --}}

                    Informações da Nota Fiscal - {{ $row->numero }}-{{ $row->serie }}

                </h5>

            </div>

        </div>

    </div>

    <div id="nfe">

        <!-- dados do emitente -->
        <div id="dados_emitente">

            <div class="row">

                <div class="col s12 mt-2">

                    <div class="row">
                        <div class="col s12">
                            <h6>Dados do Emitente</h6>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col s12 l4">
                            <div class="input-field bordered">
                                <label class="active"> Nome/Razão Social: </label>
                                <div class="" name="emitente">{{ $row->nome_razao_social_emit }}</div>
                            </div>
                        </div>

                        <div class="col s12 l3">
                            <div class="input-field bordered">
                                <label class="active"> CPF/CNPJ: </label>
                                <div class="" name="emitente">{{ $row->cpf_cnpj_emit }}</div>
                            </div>
                        </div>

                        <div class="col s12 l3">
                            <div class="input-field bordered">
                                <label class="active"> Inscrição Estadual: </label>
                                <div class="" name="emitente">{{ $row->inscricao_estadual_emit }}</div>
                            </div>
                        </div>

                        <div class="col s12 l2">
                            <div class="input-field bordered">
                                <label class="active">Fone / Fax:</label>
                                {{ $row->fone_fax_emit }}
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col s12 l4">
                            <div class="input-field bordered">
                                <label class="active">Município / UF:</label>
                                {{ $row->municipio_emit }} - {{ $row->uf_emit }}
                            </div>
                        </div>

                        <div class="col s12 l8">
                            <div class="input-field bordered">
                                <label class="active"> Endereço / Bairro / CEP: </label>
                                <div class="" name="emitente">{{ $row->endereco_emit }},
                                    {{ $row->bairro_distrito_emit }}
                                    -
                                    {{ cep($row->cep_emit) }}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        <!-- FIM dados do emitente -->

        <!-- dados da NFe -->
        <div id="dados_nfe">

            <div class="row">

                <div class="col s12 mt-1">

                    <div class="row">
                        <div class="col s12">
                            <h6>Dados da Nota Fiscal</h6>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col s12 l3 m3">
                            <div class="input-field bordered">
                                <label class="active">Operação:</label>
                            @if ($row->operacao == 1) 0 - Entrada @else 1 - Saída
                                @endif
                            </div>
                        </div>

                        <div class="col s12 l3 m3">
                            <div class="input-field bordered">
                                <label class="active">Número / Série:</label>
                                {{ $row->numero }} - {{ $row->serie }}
                            </div>
                        </div>

                        <div class="col s12 l6 m6">
                            <div class="input-field bordered">
                                <label class="active"> Chave de Acesso: </label>
                                <div class="" name="emitente">
                                    {{ chave($row->chave_de_acesso) }}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        <!-- FIM dados da NFe -->


        {{-- DADOS DOS PRODUTOS / SERVIÇOS --}}
        <table class="dados_produtos">

            <caption>DADOS DOS PRODUTOS / SERVIÇOS</caption>

            <thead>

                <tr>
                    <th class="font-10" width="5%">Cód</th>
                    <th class="font-10" width="240px">DESCRIÇÃO</th>
                    <th class="font-10" width="45px">NCM/SH</th>
                    <th class="font-10" width="40px">O/CST</th>
                    <th class="font-10" width="30px">CFOP</th>
                    <th class="font-10" width="20px">UN</th>
                    <th class="font-10" width="45px">QTD</th>
                    <th class="font-10" width="45px">VALOR <br> UNIT</th>
                    <th class="font-10" width="45px">VALOR <br> TOTAL</th>
                    <th class="font-10" width="45px">B. CÁLC <br> ICMS</th>
                    <th class="font-10" width="45px">VALOR <br> ICMS</th>
                    <th class="font-10" width="45px">VALOR <br> IPI</th>
                    <th class="font-10" width="30px">ALÍQ. <br> ICMS</th>
                    <th class="font-10" width="30px">ALÍQ. <br> IPI</th>
                </tr>

            </thead>

            <tbody>

                @php

                    $sped_model = new \App\Models\SpedModel();
                    $produtos = $sped_model
                        ->distinct()
                        ->select('nr_item', 'cod_prod', 'descricao_do_produto_ou_servicos', 'ncm_prod', 'cst_prod', 'cfop_prod', 'unid_prod_trib', 'unid_prod_com', 'quant_prod_trib', 'quant_prod_com', 'valor_unit_prod_trib', 'valor_unit_prod_com', 'valor_total_prod', 'valor_desconto_item', 'bc_icms_prod', 'valor_icms_prod', 'valor_ipi_prod', 'aliq_icms_prod', 'aliq_ipi_prod')
                        ->from('tb_lista_nfe')
                        ->where('chave_de_acesso', $row->chave_de_acesso)
                        // -> where('')
                        ->get();

                @endphp

                @foreach ($produtos as $produto)

                    <tr>

                        {{-- CÓDIGO --}}
                        <td class="center-align">
                            {{ $produto->cod_prod }}
                        </td>
                        {{-- FIM CÓDIGO --}}

                        {{-- DESCRIÇÃO DO PRODUTO / SERVIÇO --}}
                        <td class="left-align">
                            {{ $produto->descricao_do_produto_ou_servicos }}
                        </td>
                        {{-- FIM DESCRIÇÃO DO PRODUTO / SERVIÇO --}}

                        {{-- NCM/SH --}}
                        <td class="center-align">
                            {{ $produto->ncm_prod }}
                        </td>
                        {{-- FIM NCM/SH --}}

                        {{-- O/CST --}}
                        <td class="center-align">
                            {{ $produto->cst_prod }}
                        </td>
                        {{-- O/CST --}}

                        {{-- CFOP --}}
                        <td class="center-align">
                            {{ $produto->cfop_prod }}
                        </td>
                        {{-- CFOP --}}

                        {{-- UN --}}
                        <td class="center-align">
                            {{ $produto->unid_prod_com }}
                        </td>
                        {{-- UN --}}

                        {{-- QTD --}}
                        <td class="right-align">
                            {{ $row->quant_prod_com }} </td>
                        {{-- QTD --}}

                        {{-- VALOR UNITÁRIO --}}
                        <td class="right-align">
                            {{ $produto->valor_unit_prod_com }} </td>
                        {{-- VALOR UNITÁRIO --}}

                        {{-- VALOR TOTAL --}}
                        <td class="right-align">
                            {{ $produto->valor_total_prod }} </td>
                        {{-- VALOR TOTAL --}}

                        {{-- B. CÁLC ICMS --}}
                        <td class="right-align">
                            {{ $produto->bc_icms_prod }} </td>
                        {{-- B. CÁLC ICMS --}}

                        {{-- VALOR ICMS --}}
                        <td class="right-align">
                            {{ $produto->valor_icms_prod }} </td>
                        {{-- VALOR ICMS --}}

                        {{-- VALOR IPI --}}
                        <td class="right-align">
                            {{ $produto->valor_ipi_prod }} </td>
                        {{-- VALOR IPI --}}

                        {{-- ALÍQ. ICMS --}}
                        <td class="right-align">
                            {{ $produto->aliq_icms_prod }} </td>
                        {{-- ALÍQ. ICMS --}}

                        {{-- ALÍQ. IPI --}}
                        <td class="right-align">
                            {{ $produto->aliq_ipi_prod }} </td>
                        {{-- ALÍQ. IPI --}}

                    </tr>
                @endforeach

            </tbody>

        </table>
        {{-- FIM DAS TRANSPORTADOR / VOLUMES TRANSPORTADOS --}}

    </div>

    <div id="duplicatas">

        <div class="row">

            <div id="dadosnfe" class="col s12 mt-3 mb-3">

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

            <div id="" class="black-text">

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

    </div>



    <!-- Modal Structure -->
    <div id="modal-nfe" class="modal">
        <div class="modal-content">
            @php $file = '../../../../../../storage/app/public/' . $pdf; @endphp
            @if (file_exists(storage_path('app/public/' . $pdf)))
                <iframe src="{{ $file }}" frameborder="0"></iframe>
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

        iframe {
            width: 100%;
            height: calc(100vh - 160px);
            position: ;
            left: 0;
            right: 0;
        }

    </style>
@endsection
