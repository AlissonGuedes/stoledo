@extends('_layouts.app')

@section('page-title', 'Nota Fiscal - ' . $nfe->nNF . ' - ' . $nfe->serie . ' | ' . chave($nfe->chNFe))

@section('btn-back')
    <button data-href="{{ route('reports.nfe') }}" class="btn btn-floating waves-effect transparent white-text btn-flat"
        data-tooltip="Voltar">
        <i class="material-icons">arrow_back</i>
    </button>
@endsection

@section('header')

    @yield('btn-back')

    @parent

@endsection

@section('search', '')

@section('container')

    {{-- BEGIN row --}}
    <div class="row">

        {{-- BEGIN col s12 --}}
        <div class="col s12">

            {{-- BEGIN card-content --}}
            <div class="card">

                <ul class="tabs horizontal no-padding no-margin">
                    <li class="tab"><a href="#nfe">Nota fiscal</a></li>
                    <li class="tab"><a href="#duplicatas">Duplicatas</a></li>
                </ul>

                {{-- BEGIN card-content --}}
                <div class="card-content">

                    {{-- BEGIN card-title --}}
                    <div class="card-title">

                        <button type="button"
                            class="btn btn-floating btn-flat waves-effect waves-block waves-light nfe-button"
                            style="position: absolute !important; top: 20px; right: 20px;" data-target="nfe-dropdown">
                            <i class="material-icons right black-text">more_vert</i>
                        </button>
                        <ul class="dropdown-content" id="nfe-dropdown" tabindex="0">
                            <li tabindex="0">
                                <a type="button" class="grey-text text-darken-2"
                                    href="{{ route('reports.sped.nao_escrituradas.baixar_pdf', $nfe->chNFe) }}">
                                    <i class="file-export-pdf"></i>
                                    Exportar PDF
                                </a>
                            </li>
                            <li tabindex="0">
                                <a type="button" class="grey-text text-darken-2"
                                    href="{{ route('reports.sped.nao_escrituradas.baixar_xls', $nfe->chNFe) }}">
                                    <i class="file-export-xls"></i>
                                    Exportar XLS
                                </a>
                            </li>
                        </ul>
                    </div>
                    {{-- BEGIN card-title --}}

                    {{-- BEGIN #nfe --}}
                    <div id="nfe">

                        <!-- dados da NFe -->
                        <div id="dados_nfe">

                            <div class="row">
                                <div class="col s12">
                                    <h6>Dados da Nota Fiscal</h6>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col s12 l3 m3">
                                    <div class="input-field bordered">
                                        {? $active=$nfe->tpNF ? 'active' : ''; ?}
                                        <label class="{{ $active }}">Tipo da nota:</label>
                                        <input type="text" value="@php echo $nfe->tpNF == 1 ? '1 - Saída' : '0 - Entrada'; @endphp" disabled="disabled" class="uppercase">
                                    </div>
                                </div>

                                <div class="col s12 l3 m3">
                                    <div class="input-field bordered">
                                        {? $active=$nfe->nNF ? 'active' : ''; ?}
                                        <label class="{{ $active }}">Número/Série:</label>
                                        <input type="text" value="{{ $nfe->nNF }} - {{ $nfe->serie }}"
                                            disabled="disabled" class="uppercase">
                                    </div>
                                </div>

                                <div class="col s12 l6 m6">
                                    <div class="input-field bordered">
                                        {? $active=$nfe->chNFe ? 'active' : ''; ?}
                                        <label class="{{ $active }}"> Chave de Acesso: </label>
                                        <input type="text" value="{{ chave($nfe->chNFe) }}" disabled="disabled"
                                            class="uppercase" class="uppercase" class="uppercase">
                                    </div>
                                </div>

                                <div class="col s12 l6 m6">
                                    <div class="input-field bordered">
                                        {? $active=$nfe->natOp ? 'active' : ''; ?}
                                        <label class="{{ $active }}"> Natureza da operação: </label>
                                        <input type="text" value="{{ $nfe->natOp }}" disabled="disabled"
                                            class="uppercase" class="uppercase" class="uppercase">
                                    </div>
                                </div>

                                <div class="col s12 l6 m6">
                                    <div class="input-field bordered">
                                        {{-- {? $active=$nfe->natOp ? 'active' : ''; ?} --}}
                                        <label class="active"> Protocolo de autorização de uso: </label>
                                        <input type="text" value="" disabled="disabled" class="uppercase" class="uppercase"
                                            class="uppercase">
                                    </div>
                                </div>

                                <div class="col s12 l6 m6">
                                    <div class="input-field bordered">
                                        {? $active=$nfe->dhEmi ? 'active' : ''; ?}
                                        <label class="{{ $active }}"> Data/Hora Emissão: </label>
                                        <input type="text" value="{{ date('d/m/Y H:i:s', strtotime($nfe->dhEmi)) }}"
                                            disabled="disabled" class="uppercase" class="uppercase" class="uppercase">
                                    </div>
                                </div>

                                <div class="col s12 l6 m6">
                                    <div class="input-field bordered">
                                        {? $active=$nfe->dhSaiEnt ? 'active' : ''; ?}
                                        <label class="{{ $active }}"> Data/Hora Saída/Entrada: </label>
                                        <input type="text" value="{{ date('d/m/Y H:i:s', strtotime($nfe->dhSaiEnt)) }}"
                                            disabled="disabled" class="uppercase" class="uppercase" class="uppercase">
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- FIM dados da NFe -->

                        <hr class="grey-border lighten-4">

                        <!-- dados do emitente -->
                        <div id="dados_emitente">

                            <div class="row">
                                <div class="col s12">
                                    <h6>Dados do Emitente</h6>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col s12 l4">
                                    <div class="input-field bordered">
                                        {? $active = $nfe->nomeEmit ? 'active' : ''; ?}
                                        <label class="{{ $active }}"> Nome/Razão Social: </label>
                                        <input type="text" value="{{ $nfe->nomeEmit }}" disabled="disabled"
                                            class="uppercase">
                                    </div>
                                </div>

                                <div class="col s12 l3">
                                    <div class="input-field bordered">
                                        {? $active = $nfe->cnpjEmit ? 'active' : ''; ?}
                                        <label class="{{ $active }}"> CPF/CNPJ: </label>
                                        <input type="text" value="{{ cnpj($nfe->cnpjEmit) }}" disabled="disabled"
                                            class="uppercase">
                                    </div>
                                </div>

                                <div class="col s12 l3">
                                    <div class="input-field bordered">
                                        {? $active = $nfe->ieEmit ? 'active' : ''; ?}
                                        <label class="{{ $active }}"> Inscrição Estadual: </label>
                                        <input type="text" value="{{ $nfe->ieEmit }}" disabled="disabled"
                                            class="uppercase">
                                    </div>
                                </div>

                                <div class="col s12 l2">
                                    <div class="input-field bordered">
                                        {? $active = $nfe->foneEmit ? 'active' : ''; ?}
                                        <label class="{{ $active }}">Fone / Fax:</label>
                                        <input type="text" value="{{ $nfe->foneEmit }}" disabled="disabled"
                                            class="uppercase">
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col s12 l4">

                                    <div class="input-field bordered">
                                        {? $active = $nfe->munEmit ? 'active' : ''; ?}
                                        <label class="{{ $active }}">Município/UF:</label>
                                        <input type="text" value="{{ $nfe->munEmit }} - {{ $nfe->ufEmit }}"
                                            disabled="disabled" class="uppercase">
                                    </div>

                                </div>

                                <div class="col s12 l8">
                                    <div class="input-field bordered">
                                        {? $active = $nfe->cnpjEmit ? 'active' : ''; ?}
                                        <label class="{{ $active }}"> Endereço/Bairro/CEP: </label>
                                        <input type="text"
                                            value="{{ $nfe->lgrEmit }}, {{ $nfe->nroEmit }} - {{ $nfe->bairroEmit }} - {{ cep($fornecedor->cepEmit ?? '00000000') }}"
                                            disabled="disabled" class="uppercase">
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- FIM dados do emitente -->

                        <hr class="grey-border lighten-4">

                        <!-- dados do destinatário -->
                        <div id="dados_destinatario">

                            <div class="row">
                                <div class="col s12">
                                    <h6>Dados do Destinatário</h6>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col s12 l4">
                                    <div class="input-field bordered">
                                        {? $active = $nfe->nomeDest ? 'active' : ''; ?}
                                        <label class="{{ $active }}"> Nome/Razão Social: </label>
                                        <input type="text" value="{{ $nfe->nomeDest }}" disabled="disabled"
                                            class="uppercase">
                                    </div>
                                </div>

                                <div class="col s12 l3">
                                    <div class="input-field bordered">
                                        {? $active = $nfe->cnpjDest ? 'active' : ''; ?}
                                        <label class="{{ $active }}"> CPF/CNPJ: </label>
                                        <input type="text" value="{{ cnpj($nfe->cnpjDest) }}" disabled="disabled"
                                            class="uppercase">
                                    </div>
                                </div>

                                <div class="col s12 l3">
                                    <div class="input-field bordered">
                                        {? $active = $nfe->ieDest ? 'active' : ''; ?}
                                        <label class="{{ $active }}"> Inscrição Estadual: </label>
                                        <input type="text" value="{{ $nfe->ieDest }}" disabled="disabled"
                                            class="uppercase">
                                    </div>
                                </div>

                                <div class="col s12 l2">
                                    <div class="input-field bordered">
                                        {? $active = $nfe->foneDest ? 'active' : ''; ?}
                                        <label class="{{ $active }}">Fone / Fax:</label>
                                        <input type="text" value="{{ $nfe->foneDest }}" disabled="disabled"
                                            class="uppercase">
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col s12 l4">

                                    <div class="input-field bordered">
                                        {? $active = $nfe->munDest ? 'active' : ''; ?}
                                        <label class="{{ $active }}">Município/UF:</label>
                                        <input type="text" value="{{ $nfe->munDest }} - {{ $nfe->ufDest }}"
                                            disabled="disabled" class="uppercase">
                                    </div>

                                </div>

                                <div class="col s12 l8">
                                    <div class="input-field bordered">
                                        {? $active = $nfe->lgrDest || $nfe-> bairroDest || $nfe->cepDest ? 'active' : ''; ?}
                                        <label class="{{ $active }}"> Endereço/Bairro/CEP: </label>
                                        <input type="text"
                                            value="{{ $nfe->lgrDest }}, {{ $nfe->nroDest }} - {{ $nfe->bairroDest }} - {{ cep($fornecedor->cepDest ?? '00000000') }}"
                                            disabled="disabled" class="uppercase">
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- FIM dados do destinatário -->

                        <hr class="grey-border lighten-4">

                        <div id="dados_produto">

                            <div class="row">
                                <div class="col s12">
                                    <h6>Dados dos Produtos / Serviços</h6>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col s12">

                                    <ul class="collapsible z-depth-0 grey-text text-darken-2">

                                        <li class="padding-1 header">
                                            <div class="row">
                                                <div class="col s2 center-align">
                                                    <b>Código</b>
                                                </div>
                                                <div class="col s4">
                                                    <b>Descrição</b>
                                                </div>
                                                <div class="col s1">
                                                    <b>Un.</b>
                                                </div>
                                                <div class="col s1">
                                                    <b>Qtd.</b>
                                                </div>
                                                <div class="col s2">
                                                    <b>V. Unit.</b>
                                                </div>
                                                <div class="col s2">
                                                    <b>V. Total</b>
                                                </div>
                                            </div>
                                        </li>

                                        @for ($i = 1; $i <= 10; $i++)
                                            <li class="">
                                                <div class="collapsible-header waves-effect">
                                                    <div class="row">
                                                        <div class="col s2 center-align">
                                                            {{-- Código: --}}
                                                            {{ 1234567890 }}
                                                        </div>
                                                        <div class="col s4">
                                                            {{-- Descrição --}}
                                                            {{ 'Produto de demonstração' }}
                                                        </div>
                                                        <div class="col s1">
                                                            {{-- Unidade --}}
                                                            {{ 'Un.' }}
                                                        </div>
                                                        <div class="col s1">
                                                            {{-- Quantidade --}}
                                                            {{ 10 }}
                                                        </div>
                                                        <div class="col s2">
                                                            {{-- Valor unitário --}}
                                                            {{ 123.5 }}
                                                        </div>
                                                        <div class="col s2">
                                                            {{-- Valor total --}}
                                                            {{ 123.5 * 10 }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapsible-body">

                                                    {{-- DADOS DOS PRODUTOS / SERVIÇOS --}}
                                                    <table class="dados_produtos">

                                                        <tbody>

                                                            @php

                                                                $sped_model = new \App\Models\SpedfiscalModel();
                                                                $produtos = $sped_model
                                                                    ->distinct()
                                                                    ->select('nr_item', 'cod_prod', 'descricao_do_produto_ou_servicos', 'ncm_prod', 'cst_prod', 'cfop_prod', 'unid_prod_trib', 'unid_prod_com', 'quant_prod_trib', 'quant_prod_com', 'valor_unit_prod_trib', 'valor_unit_prod_com', 'valor_total_prod', 'valor_desconto_item', 'bc_icms_prod', 'valor_icms_prod', 'valor_ipi_prod', 'aliq_icms_prod', 'aliq_ipi_prod')
                                                                    ->from('tb_lista_nfe')
                                                                    ->where('chave_de_acesso', $nfe->chNFe)
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
                                                                        {{ $nfe->quant_prod_com }} </td>
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
                                            </li>
                                        @endfor

                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                {{-- END #nfe --}}


                {{-- BEGIN #duplicatas --}}
                <div id="duplicatas">

                    {{-- BEGIN row --}}
                    <div class="row">

                        {{-- BEGIN dadosnfe --}}
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
                                        <td>{{ $nfe->chave_de_acesso }} </td>
                                        <td>{{ $nfe->numero }}-{{ $nfe->serie }}</td>
                                        <td>{{ date('d/m/Y H:i:s', strtotime($nfe->dhEmi)) }} </td>
                                        <td>{{ $nfe->tPag }}</td>
                                        <td>R$ {{ number_format($nfe->vPag, 2, ',', '.') }} </td>
                                    </tr>
                                </tbody>

                            </table>

                        </div>

                        {{-- BEGIN --}}
                        <div id="" class="black-text">

                            @php
                                $nfe_model = new App\Models\NFeModel();
                                $duplicatas = $nfe_model->getDuplicatas('NFe' . $nfe->chNFe);
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
                        {{-- END --}}

                    </div>
                    {{-- END row --}}

                </div>
                {{-- END #duplicatas --}}

            </div>
            {{-- END card-content --}}

        </div>
        {{-- END card --}}

    </div>
    {{-- END col s12 --}}

    </div>
    {{-- END row --}}

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
        #nfe h6 {
            font-weight: bold;
        }

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

        .collection li {
            padding: 0 !important;
        }

        .collection a {
            display: block;
            padding: 10px 20px;
            color: inherit;
        }

        .collection .collection-item {
            position: relative;
            cursor: pointer;
            display: block;
        }

        .collapsible li.header {
            border-bottom: 1px solid #ddd;
        }

        .collapsible-header {
            display: block;
            position: relative;
        }

        .collapsible li .collapsible-header::after {
            content: 'keyboard_arrow_down';
            font-family: 'Material Icons';
            position: absolute;
            right: 15px;
            top: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            font-size: 24px;
        }

        .collapsible li.active .collapsible-header::after {
            content: 'keyboard_arrow_up';

        }

    </style>

@endsection
