@php

use App\Providers\BarcodeGenrator;

$idNFe = request()->route()->parameters['xml'];
$row = $sped_model->getNFeById($idNFe);

@endphp

<style>
	th {
		font-weight: bold !important;
	}
</style>
{{-- INFORMAÇÕES DO DANFE --}}
<table>

    <tbody>

        {{-- IDENTIFICAÇÃO DO EMITENTE --}}
        <tr>
            <td colspan="6">
                IDENTIFICAÇÃO DO EMITENTE
            </td>
        </tr>

        <tr>
            <th> NOME </th>
            <th> ENDEREÇO </th>
            <th> BAIRRO </th>
            <th> CEP </th>
            <th> MUNICÍPIO </th>
			<th> UF </th>
            <th> TELEFONE/FAX </th>
        </tr>

        <tr>
            <td> {{ $row->nome_razao_social_emit }} </td>
            <td> {{ $row->endereco_emit }} </td>
            <td> {{ $row->bairro_distrito_emit }} </td>
            <td> {{ cep($row->cep_emit) }} </td>
            <td> {{ $row->municipio_emit }} </td>
            <td> {{ $row->uf_emit }} </td>
            <td> {{ $row->fone_fax_emit }} </td>
        </tr>
        {{-- FIM IDENTIFICAÇÃO DO CLIENTE --}}

        <tr>
            {{-- DANFE --}}
            <td rowspan="3" colspan="2">
                <b>DANFE</b>
                Documento Auxiliar da Nota Fiscal Eletrônica
                <br>
                0 - ENTRADA <br>
                1 - SAÍDA
                <b>{{ $row->tipo_operacao }}</b>
                <b>
                    Nº {{ $row->numero }}
                </b>
                <b>
                    Série {{ $row->serie }}
                </b>
            </td>
            {{-- FIM DANFE --}}

            {{-- CHAVE DE ACESSO --}}
            <td colspan="6">
                @php
                    new BarcodeGenrator($row->chave_de_acesso, 1, storage_path($row->chave_de_acesso . '.gif'));
                @endphp
                <img src="{{ storage_path($row->chave_de_acesso . '.gif') }}" alt="" width="300" height="44">
            </td>
        </tr>
        <tr>
            <td colspan="6">
                CHAVE DE ACESSO
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <b>{{ chave($row->chave_de_acesso) }}</b>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                Consulta de autenticidade no portal nacional da NF-e www.nfe.fazenda.gov.br/portal ou no site da
                Sefaz Autorizadora
            </td>
        </tr>
        {{-- FIM CHAVE DE ACESSO --}}

        <tr>

            {{-- NATUREZA DA OPERAÇÃO --}}
            <td colspan="3">
                NATUREZA DA OPERAÇÃO
            </td>
        </tr>
        <tr>
            <td>
                <b>{{ strtoupper($row->natop) }}</b>
            </td>
            {{-- FIM NATUREZA DA OPERAÇÃO --}}

            {{-- PROTOCOLO DE AUTORIZAÇÃO DE USO --}}
            <td colspan="6">
                PROTOCOLO DE AUTORIZAÇÃO DE USO
            </td>
        </tr>
        <tr>
            <td>
                {{-- <b>{{ strtoupper($row->natop) }}</b> --}}
            </td>
            {{-- FIM PROTOCOLO DE AUTORIZAÇÃO DE USO --}}
        </tr>

        {{-- INSCRIÇÃO ESTADUAL --}}
        <tr>
            <td colspan="0">
                INSCRIÇÃO ESTADUAL
            </td>
            <td>
                <b>{{ $row->inscricao_estadual_emit }}</b>
            </td>
        </tr>
        {{-- FIM INSCRIÇÃO ESTADUAL --}}

        {{-- INSCRIÇÃO ESTADUAL DO SUBST. TRIBUT. --}}
        <tr>
            <td colspan="4">
                INSCRIÇÃO ESTADUAL DO SUBST. TRIBUT.
            </td>
            <td>
                {{-- <b>{{ $row->inscricao_estadual_emit }}</b> --}}
            </td>
        </tr>
        {{-- FIM INSCRIÇÃO ESTADUAL DO SUBST. TRIBUT. --}}

        {{-- INSCRIÇÃO ESTADUAL DO SUBST. TRIBUT. --}}
        <tr>
            <td colspan="4">
                CNPJ
            </td>
            <td>
                <b>{{ $row->cpf_cnpj_emit }}</b>
            </td>
        </tr>
        {{-- FIM INSCRIÇÃO ESTADUAL DO SUBST. TRIBUT. --}}

        {{-- NOME / RAZÃO SOCIAL --}}
        <tr>
            <td colspan="4">
                NOME / RAZÃO SOCIAL
            </td>
            <td>
                <b>{{ $row->nome_razao_social_dest }}</b>
            </td>
        </tr>
        {{-- FIM NOME / RAZÃO SOCIAL --}}

        {{-- CPF / CNPJ --}}
        <tr>
            <td colspan="1">
                CPF / CNPJ
            </td>
            <td>
                <b>{{ $row->cpf_cnpj_dest }}</b>
            </td>
        </tr>
        {{-- FIM CPF / CNPJ --}}

        {{-- DATA DA EMISSÃO --}}
        <tr>
            <td colspan="1">
                DATA DA EMISSÃO
            </td>
            <td>
                <b>{{ date('d/m/Y', strtotime($row->data_de_emissao)) }}</b>
            </td>
        </tr>
        {{-- FIM DATA DA EMISSÃO --}}

        {{-- ENDEREÇO --}}
        <tr>
            <td colspan="3">
                ENDEREÇO
            </td>
            <td>
                <b>{{ $row->endereco_dest }}</b>
            </td>
        </tr>
        {{-- FIM ENDEREÇO --}}

        {{-- BAIRRO / DISTRITO --}}
        <tr>
            <td colspan="1">
                BAIRRO / DISTRITO
            </td>
            <td>
                <b>{{ $row->bairro_distrito_dest }}</b>
            </td>
        </tr>
        {{-- FIM BAIRRO / DISTRITO --}}

        {{-- CEP DESTINATARIO --}}
        <tr>
            <td colspan="1">
                CEP
            </td>
            <td>
                <b>{{ cep($row->cep_dest) }}</b>
            </td>
        </tr>
        {{-- FIM CEP DESTINATARIO --}}

        {{-- DATA DA SAÍDA/ENTRADA --}}
        <tr>
            <td colspan="1">
                DATA DA SAÍDA/ENTRADA
            </td>
            <td>
                <b>{{ date('d/m/Y', strtotime($row->data_de_emissao)) }}</b>
            </td>
        </tr>
        {{-- FIM DATA DA SAÍDA/ENTRADA --}}

        {{-- MUNICIPIO --}}
        <tr>
            <td colspan="2">
                MUNICÍPIO
            </td>
            <td>
                <b>{{ $row->municipio_dest }}</b>
            </td>
        </tr>
        {{-- FIM MUNICIPIO --}}

        {{-- BAIRRO / DISTRITO --}}
        <tr>
            <td colspan="1">
                UF
            </td>
            <td>
                <b>{{ $row->uf_dest }}</b>
            </td>
        </tr>
        {{-- FIM BAIRRO / DISTRITO --}}

        {{-- FONE / FAX DESTINATARIO --}}
        <tr>
            <td colspan="1">
                FONE / FAX
            </td>
            <td>
                <b>{{ $row->fone_fax_dest }}</b>
            </td>
        </tr>
        {{-- FIM FONE / FAX DESTINATARIO --}}

        {{-- INSCRIÇÃO ESTADUAL --}}
        <tr>
            <td colspan="1">
                INSCRIÇÃO ESTADUAL
            </td>
            <td>
                <b>{{ $row->inscricao_estadual_dest }}</b>
            </td>
        </tr>
        {{-- FIM INSCRIÇÃO ESTADUAL DESTINATARIO --}}

        {{-- HORA DA SAÍDA/ENTRADA --}}
        <tr>
            <td colspan="1">
                HORA DA SAÍDA/ENTRADA
            </td>
        </tr>
        <tr>
            <td>
                <b>{{ date('H:i:s', strtotime($row->hora_de_emissao)) }}</b>
            </td>
        </tr>
        {{-- FIM HORA DA SAÍDA/ENTRADA --}}

        {{-- NOME / RAZÃO SOCIAL --}}
        <tr>
            <td style="padding: 0; border: none;">
                {{-- @for ($i = 0; $i <= 10; $i++) --}}
                Num.
            </td>
            <td>
                <b>{{ $row->numero_fatura }}</b>
            </td>
        </tr>
        <tr>
            <td>
                Venc.
                <b>{{ $row->vencimento_fatura }}</b>
            </td>
        </tr>
        <tr>
            <td>
                Valor
                <b>{{ $row->valor_fatura }}</b>
                {{-- @endfor --}}
            </td>
            {{-- FIM NOME / RAZÃO SOCIAL --}}

        </tr>

        <tr>
            {{-- BASE DE CÁLC. DO ICMS --}}
            <td>

                BASE DE CÁLC. DO ICMS
                <b>{{ $row->base_de_calculo_do_icms }}</b>

            </td>
            {{-- BASE DE CÁLC. DO ICMS --}}

            {{-- VALOR DO ICMS --}}
            <td>

                VALOR DO ICMS
                <b>{{ $row->valor_do_icms }}</b>

            </td>
            {{-- VALOR DO ICMS --}}

            {{-- BASE DE CÁLC. ICMS S.T. --}}
            <td>

                BASE DE CÁLC. ICMS S.T.
                <b>{{ $row->base_de_calculo_do_icms_substituicao }}</b>

            </td>
            {{-- BASE DE CÁLC. ICMS S.T. --}}

            {{-- VALOR DO ICMS SUBST. --}}
            <td>

                VALOR DO ICMS
                <b>{{ $row->valor_do_icms_substituicao }}</b>

            </td>
            {{-- VALOR DO ICMS SUBST. --}}

            {{-- V. IMP. IMPORTAÇÃO --}}
            <td>

                V. IMP. IMPORTAÇÃO
                <b>{{ $row->importacao ?? '0,00' }}</b>

            </td>
            {{-- V. IMP. IMPORTAÇÃO --}}

            {{-- V. ICMS UF REMET. --}}
            <td>

                V. ICMS UF REMET.
                <b>0,00</b>

            </td>
            {{-- V. ICMS UF REMET. --}}

            {{-- VALOR DO FCP --}}
            <td>

                VALOR DO FCP
                <b>{{ $row->valor_icms_fcp_uf_dest ?? '0,00' }}</b>

            </td>
            {{-- VALOR DO FCP --}}

            {{-- VALOR DO PIS --}}
            <td>

                VALOR DO PIS
                <b>{{ !isset($row->pis) ? $row->pis : '0,00' }}</b>

            </td>
            {{-- VALOR DO PIS --}}

            {{-- V. TOTAL PRODUTOS --}}
            <td>

                V. TOTAL PRODUTOS
                <b>{{ $row->valor_total_dos_produtos }}</b>

            </td>
            {{-- V. TOTAL PRODUTOS --}}

        </tr>

        <tr>
            {{-- VALOR DO FRETE --}}
            <td>

                VALOR DO FRETE
                <b>{{ $row->valor_do_frete }}</b>

            </td>
            {{-- VALOR DO FRETE --}}

            {{-- VALOR DO SEGURO --}}
            <td>

                VALOR DO SEGURO
                <b>{{ $row->valor_do_seguro }}</b>

            </td>
            {{-- VALOR DO SEGURO --}}

            {{-- DESCONTO --}}
            <td>

                DESCONTO
                <b>{{ $row->valor_desconto }}</b>

            </td>
            {{-- DESCONTO --}}

            {{-- OUTRAS DESPESAS --}}
            <td>

                OUTRAS DESPESAS
                <b>{{ $row->valor_outras_despesas_acessorias }}</b>

            </td>
            {{-- OUTRAS DESPESAS. --}}

            {{-- VALOR TOTAL IPI --}}
            <td>

                VALOR TOTAL IPI
                <b>{{ $row->valor_do_ipi }}</b>

            </td>
            {{-- VALOR TOTAL IPI --}}

            {{-- V. ICMS UF DEST. --}}
            <td>

                V. ICMS UF DEST.
                <b>0,00</b>

            </td>
            {{-- V. ICMS UF DEST. --}}

            {{-- V. TOT. TRIB. --}}
            <td>

                V. TOT. TRIB.
                <b>0,00</b>

            </td>
            {{-- V. TOT. TRIB. --}}

            {{-- VALOR DA COFINS --}}
            <td>

                VALOR DA COFINS
                <b>0,00</b>

            </td>
            {{-- VALOR DA COFINS --}}

            {{-- V. TOTAL DA NOTA --}}
            <td>

                V. TOTAL DA NOTA
                <b>{{ $row->valor_total_da_nota }}</b>

            </td>
            {{-- V. TOTAL DA NOTA --}}

        </tr>

        <tr>

            {{-- NOME / RAZÃO SOCIAL --}}
            <td colspan="4">

                NOME / RAZÃO SOCIAL
                <b>{{ $row->nome_da_transportadora }}</b>

            </td>
            {{-- FIM NOME / RAZÃO SOCIAL --}}

            {{-- FRETE POR CONTA --}}
            <td>

                FRETE POR CONTA
                <b>{{ $row->modalidade_do_frete }}</b>

            </td>
            {{-- FIM FRETE POR CONTA --}}

            {{-- CÓDIGO ANTT --}}
            <td>

                CÓDIGO ANTT

            </td>
            {{-- FIM CÓDIGO ANTT --}}

            {{-- PLACA DO VEÍCULO --}}
            <td>

                PLACA DO VEÍCULO
                <b>{{ $row->placa_do_veiculo_reboque }}</b>

            </td>
            {{-- FIM PLACA DO VEÍCULO --}}

            {{-- UF --}}
            <td>

                UF
                <b>{{ $row->uf_placa }}</b>

            </td>
            {{-- FIM UF --}}

            {{-- CNPJ / CPF --}}
            <td>

                CNPJ / CPF
                <b>{{ $row->cnpj_da_transportadora }}</b>

            </td>
            {{-- CNPJ / CPF SOCIAL --}}
        </tr>

        <tr>

            {{-- ENDEREÇO --}}
            <td colspan="5">

                ENDEREÇO

            </td>
            {{-- FIM ENDEREÇO --}}

            {{-- MUNICÍPIO --}}
            <td colspan="2">

                MUNICÍPIO

            </td>
            {{-- FIM MUNICÍPIO --}}

            {{-- UF --}}
            <td>

                UF

            </td>
            {{-- FIM UF --}}

            {{-- INSCRIÇÃO ESTADUAL --}}
            <td>

                INSCRIÇÃO ESTADUAL
                <b>{{ $row->inscricao_estadual_da_transportadora }}</b>

            </td>
            {{-- INSCRIÇÃO ESTADUAL --}}
        </tr>

        <tr>

            {{-- QUANTIDADE --}}
            <td colspan="2">

                QUANTIDADE

            </td>
            {{-- FIM QUANTIDADE --}}

            {{-- ESPÉCIE --}}
            <td colspan="2">

                ESPÉCIE

            </td>
            {{-- FIM ESPÉCIE --}}

            {{-- MARCA --}}
            <td>

                MARCA

            </td>
            {{-- FIM MARCA --}}

            {{-- NUMERAÇÃO --}}
            <td colspan="1">

                NUMERAÇÃO
                <b>{{ $row->inscricao_estadual_da_transportadora }}</b>

            </td>
            {{-- NUMERAÇÃO --}}

            {{-- PESO BRUTO --}}
            <td colspan="2">

                PESO BRUTO
                <b>{{ $row->inscricao_estadual_da_transportadora }}</b>

            </td>
            {{-- PESO BRUTO --}}

            {{-- PESO LÍQUIDO --}}
            <td>

                PESO LÍQUIDO
                <b>{{ $row->inscricao_estadual_da_transportadora }}</b>

            </td>
            {{-- PESO LÍQUIDO --}}
        </tr>

        <tr>
            <th width="5%">Cód</th>
            <th width="240px">DESCRIÇÃO</th>
            <th width="45px">NCM/SH</th>
            <th width="40px">O/CST</th>
            <th width="30px">CFOP</th>
            <th width="20px">UN</th>
            <th width="45px">QTD</th>
            <th width="45px">VALOR UNIT</th>
            <th width="45px">VALOR TOTAL</th>
            <th width="45px">B. CÁLC ICMS</th>
            <th width="45px">VALOR ICMS</th>
            <th width="45px">VALOR IPI</th>
            <th width="30px">ALÍQ. ICMS</th>
            <th width="30px">ALÍQ. IPI</th>
        </tr>

        @php

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
                <td>
                    {{ $produto->cod_prod }}
                </td>
                {{-- FIM CÓDIGO --}}

                {{-- DESCRIÇÃO DO PRODUTO / SERVIÇO --}}
                <td>
                    {{ $produto->descricao_do_produto_ou_servicos }}
                </td>
                {{-- FIM DESCRIÇÃO DO PRODUTO / SERVIÇO --}}

                {{-- NCM/SH --}}
                <td>
                    {{ $produto->ncm_prod }}
                </td>
                {{-- FIM NCM/SH --}}

                {{-- O/CST --}}
                <td>
                    {{ $produto->cst_prod }}
                </td>
                {{-- O/CST --}}

                {{-- CFOP --}}
                <td>
                    {{ $produto->cfop_prod }}
                </td>
                {{-- CFOP --}}

                {{-- UN --}}
                <td>
                    {{ $produto->unid_prod_com }}
                </td>
                {{-- UN --}}

                {{-- QTD --}}
                <td>
                    {{ $row->quant_prod_com }} </td>
                {{-- QTD --}}

                {{-- VALOR UNITÁRIO --}}
                <td>
                    {{ $produto->valor_unit_prod_com }} </td>
                {{-- VALOR UNITÁRIO --}}

                {{-- VALOR TOTAL --}}
                <td>
                    {{ $produto->valor_total_prod }} </td>
                {{-- VALOR TOTAL --}}

                {{-- B. CÁLC ICMS --}}
                <td>
                    {{ $produto->bc_icms_prod }} </td>
                {{-- B. CÁLC ICMS --}}

                {{-- VALOR ICMS --}}
                <td>
                    {{ $produto->valor_icms_prod }} </td>
                {{-- VALOR ICMS --}}

                {{-- VALOR IPI --}}
                <td>
                    {{ $produto->valor_ipi_prod }} </td>
                {{-- VALOR IPI --}}

                {{-- ALÍQ. ICMS --}}
                <td>
                    {{ $produto->aliq_icms_prod }} </td>
                {{-- ALÍQ. ICMS --}}

                {{-- ALÍQ. IPI --}}
                <td>
                    {{ $produto->aliq_ipi_prod }} </td>
                {{-- ALÍQ. IPI --}}

            </tr>
        @endforeach

        <tr>

            {{-- INFORMAÇÕES COMPLEMENTARES --}}
            <td width="105px" style="height: 70px; ;">
                INFORMAÇÕES COMPLEMENTARES
                {{ $row->informacoes_complementares }}
            </td>
            {{-- FIM INFORMAÇÕES COMPLEMENTARES --}}

            {{-- RESERVADO AO FISCO --}}
            <td width="40px">
                RESERVADO AO FISCO
            </td>
            {{-- FIM RESERVADO AO FISCO --}}

        </tr>

    </tbody>

</table>
{{-- FIM DAS DADOS ADICIONAIS --}}

<?php date_default_timezone_set('America/Recife'); ?>

<table>
    <tfoot>
        <tr>
            <td>
                <p>Impresso em {{ date('d/m/Y H:i:s') }}</p>
            </td>
            <td>
                <p>Gerado em SToledo</p>
            </td>
        </tr>
    </tfoot>
</table>
