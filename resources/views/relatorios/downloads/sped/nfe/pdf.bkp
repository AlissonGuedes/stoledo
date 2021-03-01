@php

use App\Providers\BarcodeGenrator;

$idNFe = request()->route()->parameters['xml'];
$row = $sped_model->getNFeById($nfe);

@endphp

<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>NFe{{ $row->chave_de_acesso }}.pdf</title>
    <link rel="stylesheet" media="screen" href="{{ asset('assets/styles/admin/exports/nfe/pdf.css') }}">

</head>

<body>

    {{-- INFORMAÇÕES DO DANFE --}}
    <table>

        <tbody>

            {{-- IDENTIFICAÇÃO DO EMITENTE --}}
            <tr>
                <td rowspan="3" class="center-align width-40">
                    <div class="center-align italic absolute top-0 left-0 right-0">
                        <small class="center-align font-8">
                            IDENTIFICAÇÃO DO EMITENTE
                        </small>
                    </div>
                    <div class="uppercase">
                        <b>{{ $row->nome_razao_social_emit }}</b> <br>
                        {{ $row->endereco_emit }} <br>
                        {{ $row->bairro_distrito_emit }} - {{ cep($row->cep_emit) }} <br>
                        {{ $row->municipio_emit }} - {{ $row->uf_emit }} Fone/Fax: {{ $row->fone_fax_emit }}
                    </div>
                </td>
                {{-- FIM IDENTIFICAÇÃO DO CLIENTE --}}

                {{-- DANFE --}}
                <td rowspan="3" class="center-align pl-3 pr-3" colspan="2">
                    <div class="">
                        <b class="font-17">DANFE</b>
                        <div class="font-7 pl-3 pr-3 normalcase">
                            Documento Auxiliar da Nota Fiscal Eletrônica
                        </div>
                        <div class="left-align font-10 left mt-1 ml-2">
                            <br>
                            0 - ENTRADA <br>
                            1 - SAÍDA
                        </div>
                        <div class="right center-align mr-2 bordered">
                            <b>{{ $row->tipo_operacao }}</b>
                        </div>
                        <div class="clearfix mt-1">
                            <b class="">
                                Nº {{ $row->numero }}
                            </b>
                            <br>
                            <b>
                                Série {{ $row->serie }}
                            </b>
                        </div>
                    </div>
                </td>
                {{-- FIM DANFE --}}

                {{-- CHAVE DE ACESSO --}}
                <td class="center-align pt-1 pb-5 width-40" colspan="6">
                    @php
                        new BarcodeGenrator($row->chave_de_acesso, 1, storage_path($row->chave_de_acesso . '.gif'));
                    @endphp
                    <img src="{{ storage_path($row->chave_de_acesso . '.gif') }}" alt="" width="300" height="44">
                </td>
            </tr>
            <tr>
                <td class="center-align pt-1 width-35" colspan="6">
                    <div class="top-0">
                        <small class="font-8">CHAVE DE ACESSO</small>
                    </div>
                    <div class="mt-1 col s6 mt-2 center-align">
                        <b>{{ chave($row->chave_de_acesso) }}</b>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="center-align pt-1 width-35" colspan="6">
                    <div class="font-10 normalcase pl-5 pr-5">
                        Consulta de autenticidade no portal nacional da NF-e www.nfe.fazenda.gov.br/portal ou no site da
                        Sefaz Autorizadora
                    </div>
                </td>
            </tr>
            {{-- FIM CHAVE DE ACESSO --}}

            <tr>

                {{-- NATUREZA DA OPERAÇÃO --}}
                <td colspan="3">
                    <div class="top-0">
                        <small class="font-8">NATUREZA DA OPERAÇÃO</small>
                    </div>
                    <div class="mt-1 center-align">
                        <b>{{ strtoupper($row->natop) }}</b>
                    </div>
                </td>
                {{-- FIM NATUREZA DA OPERAÇÃO --}}

                {{-- PROTOCOLO DE AUTORIZAÇÃO DE USO --}}
                <td colspan="6">
                    <div class="top-0">
                        <small class="font-8">PROTOCOLO DE AUTORIZAÇÃO DE USO</small>
                    </div>
                    <div class="mt-1 center-align" style="">
                        {{-- <b>{{ strtoupper($row->natop) }}</b> --}}
                    </div>
                </td>
                {{-- FIM PROTOCOLO DE AUTORIZAÇÃO DE USO --}}

            </tr>

            <tr>
                {{-- INSCRIÇÃO ESTADUAL --}}
                <td colspan="0">
                    <div class="top-0 font-8">
                        INSCRIÇÃO ESTADUAL
                    </div>
                    <div class="mt-1 center-align" style="">
                        <b>{{ $row->inscricao_estadual_emit }}</b>
                    </div>
                </td>
                {{-- FIM INSCRIÇÃO ESTADUAL --}}

                {{-- INSCRIÇÃO ESTADUAL DO SUBST. TRIBUT. --}}
                <td colspan="4">
                    <div class="top-0 font-8">
                        INSCRIÇÃO ESTADUAL DO SUBST. TRIBUT.
                    </div>
                    <div class="mt-1 center-align" style="">
                        {{-- <b>{{ $row->inscricao_estadual_emit }}</b> --}}
                    </div>
                </td>
                {{-- FIM INSCRIÇÃO ESTADUAL DO SUBST. TRIBUT. --}}

                {{-- INSCRIÇÃO ESTADUAL DO SUBST. TRIBUT. --}}
                <td colspan="4">
                    <div class="top-0 font-8">
                        CNPJ
                    </div>
                    <div class="mt-1 center-align" style="">
                        <b>{{ $row->cpf_cnpj_emit }}</b>
                    </div>
                </td>
                {{-- FIM INSCRIÇÃO ESTADUAL DO SUBST. TRIBUT. --}}

            </tr>

        </tbody>

    </table>
    {{-- FIM DAS INFORMAÇÕES DO DANFE --}}

    {{-- INFORMAÇÕES DO DESTINATÁRIO / REMETENTE --}}
    <table>

        <caption>DESTINATÁRIO / REMETENTE</caption>

        <tbody>

            <tr>

                {{-- NOME / RAZÃO SOCIAL --}}
                <td colspan="4">
                    <div class="top-0 font-8">
                        NOME / RAZÃO SOCIAL
                    </div>
                    <div class="mt-1 left-align" style="">
                        <b>{{ $row->nome_razao_social_dest }}</b>
                    </div>
                </td>
                {{-- FIM NOME / RAZÃO SOCIAL --}}

                {{-- CPF / CNPJ --}}
                <td colspan="1">
                    <div class="top-0 font-8">
                        CPF / CNPJ
                    </div>
                    <div class="mt-1 center-align" style="">
                        <b>{{ $row->cpf_cnpj_dest }}</b>
                    </div>
                </td>
                {{-- FIM CPF / CNPJ --}}

                {{-- DATA DA EMISSÃO --}}
                <td colspan="1">
                    <div class="top-0 font-8">
                        DATA DA EMISSÃO
                    </div>
                    <div class="mt-1 center-align" style="">
                        <b>{{ date('d/m/Y', strtotime($row->data_de_emissao)) }}</b>
                    </div>
                </td>
                {{-- FIM DATA DA EMISSÃO --}}

            </tr>

            <tr>

                {{-- ENDEREÇO --}}
                <td colspan="3">
                    <div class="top-0 font-8">
                        ENDEREÇO
                    </div>
                    <div class="mt-1 left-align" style="">
                        <b>{{ $row->endereco_dest }}</b>
                    </div>
                </td>
                {{-- FIM ENDEREÇO --}}

                {{-- BAIRRO / DISTRITO --}}
                <td colspan="1">
                    <div class="top-0 font-8">
                        BAIRRO / DISTRITO
                    </div>
                    <div class="mt-1 center-align" style="">
                        <b>{{ $row->bairro_distrito_dest }}</b>
                    </div>
                </td>
                {{-- FIM BAIRRO / DISTRITO --}}

                {{-- CEP DESTINATARIO --}}
                <td colspan="1">
                    <div class="top-0 font-8">
                        CEP
                    </div>
                    <div class="mt-1 center-align" style="">
                        <b>{{ cep($row->cep_dest) }}</b>
                    </div>
                </td>
                {{-- FIM CEP DESTINATARIO --}}

                {{-- DATA DA SAÍDA/ENTRADA --}}
                <td colspan="1">
                    <div class="top-0 font-8">
                        DATA DA SAÍDA/ENTRADA
                    </div>
                    <div class="mt-1 center-align" style="">
                        <b>{{ date('d/m/Y', strtotime($row->data_de_emissao)) }}</b>
                    </div>
                </td>
                {{-- FIM DATA DA SAÍDA/ENTRADA --}}

            </tr>

            <tr>

                {{-- MUNICIPIO --}}
                <td colspan="2">
                    <div class="top-0 font-8">
                        MUNICÍPIO
                    </div>
                    <div class="mt-1 left-align" style="">
                        <b>{{ $row->municipio_dest }}</b>
                    </div>
                </td>
                {{-- FIM MUNICIPIO --}}

                {{-- BAIRRO / DISTRITO --}}
                <td colspan="1">
                    <div class="top-0 font-8">
                        UF
                    </div>
                    <div class="mt-1 center-align" style="">
                        <b>{{ $row->uf_dest }}</b>
                    </div>
                </td>
                {{-- FIM BAIRRO / DISTRITO --}}

                {{-- FONE / FAX DESTINATARIO --}}
                <td colspan="1">
                    <div class="top-0 font-8">
                        FONE / FAX
                    </div>
                    <div class="mt-1 center-align" style="">
                        <b>{{ $row->fone_fax_dest }}</b>
                    </div>
                </td>
                {{-- FIM FONE / FAX DESTINATARIO --}}

                {{-- INSCRIÇÃO ESTADUAL --}}
                <td colspan="1">
                    <div class="top-0 font-8">
                        INSCRIÇÃO ESTADUAL
                    </div>
                    <div class="mt-1 center-align" style="">
                        <b>{{ $row->inscricao_estadual_dest }}</b>
                    </div>
                </td>
                {{-- FIM INSCRIÇÃO ESTADUAL DESTINATARIO --}}

                {{-- HORA DA SAÍDA/ENTRADA --}}
                <td colspan="1">
                    <div class="top-0 font-8">
                        HORA DA SAÍDA/ENTRADA
                    </div>
                    <div class="mt-1 center-align" style="">
                        <b>{{ date('H:i:s', strtotime($row->hora_de_emissao)) }}</b>
                    </div>
                </td>
                {{-- FIM HORA DA SAÍDA/ENTRADA --}}

            </tr>

        </tbody>

    </table>
    {{-- FIM DAS INFORMAÇÕES DO DESTINATÁRIO / REMETENTE --}}

    {{-- FATURA / DUPLICATA --}}
    <table>

        <caption>FATURA / DUPLICATA</caption>

        <tbody>

            <tr class="duplicatas" style="border: none !important">

                {{-- NOME / RAZÃO SOCIAL --}}
                <td style="padding: 0; border: none;">

                    {{-- @for ($i = 0; $i <= 10; $i++) --}}

                    <div style="width: 150px; border: 1px solid; padding: 3px; border-radius: 3px">

                        <span class="font-8">
                            Num.
                        </span>
                        <span class="right">
                            <b>{{ $row->numero_fatura }}</b>
                        </span>

                        <div class="clearfix"></div>

                        <span class="font-8">
                            Venc.
                        </span>
                        <span class="right">
                            <b>{{ $row->vencimento_fatura }}</b>
                        </span>

                        <div class="clearfix"></div>

                        <span class="font-8">
                            Valor
                        </span>
                        <span class="right">
                            <b>{{ $row->valor_fatura }}</b>
                        </span>

                    </div>

                    {{-- @endfor --}}
                    <div class="clearfix"></div>

                </td>
                {{-- FIM NOME / RAZÃO SOCIAL --}}

            </tr>

        </tbody>

    </table>
    {{-- FIM DAS FATURA / DUPLICATA --}}

    {{-- CÁLCULO DO IMPOSTO --}}
    <table>

        <caption>CÁLCULO DO IMPOSTO</caption>

        <tbody>

            <tr>
                {{-- BASE DE CÁLC. DO ICMS --}}
                <td>

                    <div class="top-0 font-6">
                        BASE DE CÁLC. DO ICMS
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>{{ $row->base_de_calculo_do_icms }}</b>
                    </div>

                </td>
                {{-- BASE DE CÁLC. DO ICMS --}}

                {{-- VALOR DO ICMS --}}
                <td>

                    <div class="top-0 font-6">
                        VALOR DO ICMS
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>{{ $row->valor_do_icms }}</b>
                    </div>

                </td>
                {{-- VALOR DO ICMS --}}

                {{-- BASE DE CÁLC. ICMS S.T. --}}
                <td>

                    <div class="top-0 font-6">
                        BASE DE CÁLC. ICMS S.T.
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>{{ $row->base_de_calculo_do_icms_substituicao }}</b>
                    </div>

                </td>
                {{-- BASE DE CÁLC. ICMS S.T. --}}

                {{-- VALOR DO ICMS SUBST. --}}
                <td>

                    <div class="top-0 font-6">
                        VALOR DO ICMS
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>{{ $row->valor_do_icms_substituicao }}</b>
                    </div>

                </td>
                {{-- VALOR DO ICMS SUBST. --}}

                {{-- V. IMP. IMPORTAÇÃO --}}
                <td>

                    <div class="top-0 font-6">
                        V. IMP. IMPORTAÇÃO
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>{{ $row->importacao ?? '0,00' }}</b>
                    </div>

                </td>
                {{-- V. IMP. IMPORTAÇÃO --}}

                {{-- V. ICMS UF REMET. --}}
                <td>

                    <div class="top-0 font-6">
                        V. ICMS UF REMET.
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>0,00</b>
                    </div>

                </td>
                {{-- V. ICMS UF REMET. --}}

                {{-- VALOR DO FCP --}}
                <td>

                    <div class="top-0 font-6">
                        VALOR DO FCP
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>{{ $row->valor_icms_fcp_uf_dest ?? '0,00' }}</b>
                    </div>

                </td>
                {{-- VALOR DO FCP --}}

                {{-- VALOR DO PIS --}}
                <td>

                    <div class="top-0 font-6">
                        VALOR DO PIS
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>{{ !isset($row->pis) ? $row->pis : '0,00' }}</b>
                    </div>

                </td>
                {{-- VALOR DO PIS --}}

                {{-- V. TOTAL PRODUTOS --}}
                <td>

                    <div class="top-0 font-6">
                        V. TOTAL PRODUTOS
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>{{ $row->valor_total_dos_produtos }}</b>
                    </div>

                </td>
                {{-- V. TOTAL PRODUTOS --}}

            </tr>

            <tr>
                {{-- VALOR DO FRETE --}}
                <td>

                    <div class="top-0 font-6">
                        VALOR DO FRETE
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>{{ $row->valor_do_frete }}</b>
                    </div>

                </td>
                {{-- VALOR DO FRETE --}}

                {{-- VALOR DO SEGURO --}}
                <td>

                    <div class="top-0 font-6">
                        VALOR DO SEGURO
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>{{ $row->valor_do_seguro }}</b>
                    </div>

                </td>
                {{-- VALOR DO SEGURO --}}

                {{-- DESCONTO --}}
                <td>

                    <div class="top-0 font-6">
                        DESCONTO
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>{{ $row->valor_desconto }}</b>
                    </div>

                </td>
                {{-- DESCONTO --}}

                {{-- OUTRAS DESPESAS --}}
                <td>

                    <div class="top-0 font-6">
                        OUTRAS DESPESAS
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>{{ $row->valor_outras_despesas_acessorias }}</b>
                    </div>

                </td>
                {{-- OUTRAS DESPESAS. --}}

                {{-- VALOR TOTAL IPI --}}
                <td>

                    <div class="top-0 font-6">
                        VALOR TOTAL IPI
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>{{ $row->valor_do_ipi }}</b>
                    </div>

                </td>
                {{-- VALOR TOTAL IPI --}}

                {{-- V. ICMS UF DEST. --}}
                <td>

                    <div class="top-0 font-6">
                        V. ICMS UF DEST.
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>0,00</b>
                    </div>

                </td>
                {{-- V. ICMS UF DEST. --}}

                {{-- V. TOT. TRIB. --}}
                <td>

                    <div class="top-0 font-6">
                        V. TOT. TRIB.
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>0,00</b>
                    </div>

                </td>
                {{-- V. TOT. TRIB. --}}

                {{-- VALOR DA COFINS --}}
                <td>

                    <div class="top-0 font-6">
                        VALOR DA COFINS
                    </div>
                    <div class="right-align mt-1" style="">
                        <b>0,00</b>
                    </div>

                </td>
                {{-- VALOR DA COFINS --}}

                {{-- V. TOTAL DA NOTA --}}
                <td>

                    <div class="top-0 font-6">
                        V. TOTAL DA NOTA
                    </div>
                    <div class="right-align mt-1 mb-0">
                        <b>{{ $row->valor_total_da_nota }}</b>
                    </div>

                </td>
                {{-- V. TOTAL DA NOTA --}}

            </tr>

        </tbody>
    </table>
    {{-- FIM DAS CÁLCULO DO IMPOSTO --}}

    {{-- TRANSPORTADOR / VOLUMES TRANSPORTADOS --}}
    <table>

        <caption>TRANSPORTADOR / VOLUMES TRANSPORTADOS</caption>

        <tbody>

            <tr>

                {{-- NOME / RAZÃO SOCIAL --}}
                <td colspan="4">

                    <div class="top-0 font-6">
                        NOME / RAZÃO SOCIAL
                    </div>
                    <div class="left-align mt-1" style="">
                        <b>{{ $row->nome_da_transportadora }}</b>
                    </div>

                </td>
                {{-- FIM NOME / RAZÃO SOCIAL --}}

                {{-- FRETE POR CONTA --}}
                <td>

                    <div class="top-0 font-6">
                        FRETE POR CONTA
                    </div>
                    <div class="center-align mt-1" style="">
                        <b>{{ $row->modalidade_do_frete }}</b>
                    </div>

                </td>
                {{-- FIM FRETE POR CONTA --}}

                {{-- CÓDIGO ANTT --}}
                <td>

                    <div class="top-0 font-6">
                        CÓDIGO ANTT
                    </div>
                    <div class="center-align mt-1" style="">
                        <b></b>
                    </div>

                </td>
                {{-- FIM CÓDIGO ANTT --}}

                {{-- PLACA DO VEÍCULO --}}
                <td>

                    <div class="top-0 font-6">
                        PLACA DO VEÍCULO
                    </div>
                    <div class="center-align mt-1" style="">
                        <b>{{ $row->placa_do_veiculo_reboque }}</b>
                    </div>

                </td>
                {{-- FIM PLACA DO VEÍCULO --}}

                {{-- UF --}}
                <td>

                    <div class="top-0 font-6">
                        UF
                    </div>
                    <div class="center-align mt-1" style="">
                        <b>{{ $row->uf_placa }}</b>
                    </div>

                </td>
                {{-- FIM UF --}}

                {{-- CNPJ / CPF --}}
                <td>

                    <div class="top-0 font-6">
                        CNPJ / CPF
                    </div>
                    <div class="center-align mt-1" style="">
                        <b>{{ $row->cnpj_da_transportadora }}</b>
                    </div>

                </td>
                {{-- CNPJ / CPF SOCIAL --}}
            </tr>

            <tr>

                {{-- ENDEREÇO --}}
                <td colspan="5">

                    <div class="top-0 font-6">
                        ENDEREÇO
                    </div>
                    <div class="left-align mt-1" style="">
                        <b> </b>
                    </div>

                </td>
                {{-- FIM ENDEREÇO --}}

                {{-- MUNICÍPIO --}}
                <td colspan="2">

                    <div class="top-0 font-6">
                        MUNICÍPIO
                    </div>
                    <div class="center-align mt-1" style="">
                        <b> </b>
                    </div>

                </td>
                {{-- FIM MUNICÍPIO --}}

                {{-- UF --}}
                <td>

                    <div class="top-0 font-6">
                        UF
                    </div>
                    <div class="center-align mt-1" style="">
                        <b> </b>
                    </div>

                </td>
                {{-- FIM UF --}}

                {{-- INSCRIÇÃO ESTADUAL --}}
                <td>

                    <div class="top-0 font-6">
                        INSCRIÇÃO ESTADUAL
                    </div>
                    <div class="center-align mt-1" style="">
                        <b>{{ $row->inscricao_estadual_da_transportadora }}</b>
                    </div>

                </td>
                {{-- INSCRIÇÃO ESTADUAL --}}
            </tr>

            <tr>

                {{-- QUANTIDADE --}}
                <td colspan="2">

                    <div class="top-0 font-6">
                        QUANTIDADE
                    </div>
                    <div class="left-align mt-1" style="">
                        <b> </b>
                    </div>

                </td>
                {{-- FIM QUANTIDADE --}}

                {{-- ESPÉCIE --}}
                <td colspan="2">

                    <div class="top-0 font-6">
                        ESPÉCIE
                    </div>
                    <div class="center-align mt-1" style="">
                        <b> </b>
                    </div>

                </td>
                {{-- FIM ESPÉCIE --}}

                {{-- MARCA --}}
                <td>

                    <div class="top-0 font-6">
                        MARCA
                    </div>
                    <div class="center-align mt-1" style="">
                        <b> </b>
                    </div>

                </td>
                {{-- FIM MARCA --}}

                {{-- NUMERAÇÃO --}}
                <td colspan="1">

                    <div class="top-0 font-6">
                        NUMERAÇÃO
                    </div>
                    <div class="center-align mt-1" style="">
                        <b>{{ $row->inscricao_estadual_da_transportadora }}</b>
                    </div>

                </td>
                {{-- NUMERAÇÃO --}}

                {{-- PESO BRUTO --}}
                <td colspan="2">

                    <div class="top-0 font-6">
                        PESO BRUTO
                    </div>
                    <div class="center-align mt-1" style="">
                        <b>{{ $row->inscricao_estadual_da_transportadora }}</b>
                    </div>

                </td>
                {{-- PESO BRUTO --}}

                {{-- PESO LÍQUIDO --}}
                <td>

                    <div class="top-0 font-6">
                        PESO LÍQUIDO
                    </div>
                    <div class="center-align mt-1" style="">
                        <b>{{ $row->inscricao_estadual_da_transportadora }}</b>
                    </div>

                </td>
                {{-- PESO LÍQUIDO --}}
            </tr>

        </tbody>

    </table>
    {{-- FIM DAS TRANSPORTADOR / VOLUMES TRANSPORTADOS --}}


    {{-- DADOS DOS PRODUTOS / SERVIÇOS --}}
    <table class="dados_produtos">

        <caption>DADOS DOS PRODUTOS / SERVIÇOS</caption>

        <thead>

            <tr>
                <th class="font-10" width="1%">Código</th>
                <th class="font-10" width="">DESCRIÇÃO</th>
                <th class="font-10" width="1%">NCM/SH</th>
                <th class="font-10" width="1%">O/CST</th>
                <th class="font-10" width="1%">CFOP</th>
                <th class="font-10" width="1%">UN</th>
                <th class="font-10" width="1%">QTD</th>
                <th class="font-10" width="1%">VALOR <br> UNIT</th>
                <th class="font-10" width="2%">VALOR <br> TOTAL</th>
                <th class="font-10" width="2%">B. CÁLC <br> ICMS</th>
                <th class="font-10" width="2%">VALOR <br> ICMS</th>
                <th class="font-10" width="2%">VALOR <br> IPI</th>
                <th class="font-10" width="2%">ALÍQ. <br> ICMS</th>
                <th class="font-10" width="2%">ALÍQ. <br> IPI</th>
            </tr>

        </thead>

        <tbody>

            @for ($i = 0; $i < 10; $i++)

                <tr>

                    {{-- CÓDIGO --}}
                    <td class="center-align">
                        123412341243
                    </td>
                    {{-- FIM CÓDIGO --}}

                    {{-- DESCRIÇÃO DO PRODUTO / SERVIÇO --}}
                    <td class="left-align">
                        DESCRIÇÃO DO PRODUTO / SERVIÇO
                    </td>
                    {{-- FIM DESCRIÇÃO DO PRODUTO / SERVIÇO --}}

                    {{-- NCM/SH --}}
                    <td class="center-align">
                        17049020
                    </td>
                    {{-- FIM NCM/SH --}}

                    {{-- O/CST --}}
                    <td class="center-align">
                        000
                    </td>
                    {{-- O/CST --}}

                    {{-- CFOP --}}
                    <td class="center-align">
                        6101
                    </td>
                    {{-- CFOP --}}

                    {{-- UN --}}
                    <td class="center-align">
                        CX
                    </td>
                    {{-- UN --}}

                    {{-- QTD --}}
                    <td class="right-align">
                        3,0000
                    </td>
                    {{-- QTD --}}

                    {{-- VALOR UNITÁRIO --}}
                    <td class="right-align">
                        108,3600
                    </td>
                    {{-- VALOR UNITÁRIO --}}

                    {{-- VALOR TOTAL --}}
                    <td class="right-align">
                        108,36
                    </td>
                    {{-- VALOR TOTAL --}}

                    {{-- B. CÁLC ICMS --}}
                    <td class="right-align">
                        1.108,36
                    </td>
                    {{-- B. CÁLC ICMS --}}

                    {{-- VALOR ICMS --}}
                    <td class="right-align">
                        108,36
                    </td>
                    {{-- VALOR ICMS --}}

                    {{-- VALOR IPI --}}
                    <td class="right-align">
                        108,36
                    </td>
                    {{-- VALOR IPI --}}

                    {{-- ALÍQ. ICMS --}}
                    <td class="right-align">
                        108,36
                    </td>
                    {{-- ALÍQ. ICMS --}}

                    {{-- ALÍQ. IPI --}}
                    <td class="right-align">
                        108,36
                    </td>
                    {{-- ALÍQ. IPI --}}

                </tr>
            @endfor

        </tbody>

    </table>
    {{-- FIM DAS TRANSPORTADOR / VOLUMES TRANSPORTADOS --}}


    {{-- DADOS ADICIONAIS --}}
    <table>

        <caption>DADOS ADICIONAIS</caption>

        <tbody>

            <tr>

                {{-- INFORMAÇÕES COMPLEMENTARES --}}
                <td width="105px" class="left-align normalcase font-7" style="height: 70px; overflow: hidden ;">
                    <div class="top-0 font-8 bold">
                        INFORMAÇÕES COMPLEMENTARES
                    </div>
                    <div class="mt-1">
                        {{ $row->informacoes_complementares }}
                    </div>
                </td>
                {{-- FIM INFORMAÇÕES COMPLEMENTARES --}}

                {{-- RESERVADO AO FISCO --}}
                <td width="40px" class="left-align normalcase font-7">
                    <div class="top-0 font-8 bold">
                        RESERVADO AO FISCO </div>
                </td>
                {{-- FIM RESERVADO AO FISCO --}}

            </tr>

        </tbody>

    </table>
    {{-- FIM DAS DADOS ADICIONAIS --}}

    <?php date_default_timezone_set('America/Recife'); ?>

    <table class="footer">
        <tfoot>
            <tr>
                <td class="left-align">
                    <p>Impresso em {{ date('d/m/Y H:i:s') }}</p>
                </td>
                <td class="right-align">
                    <p>Gerado em SToledo</p>
                </td>
            </tr>
        </tfoot>
    </table>

</body>

</html>
