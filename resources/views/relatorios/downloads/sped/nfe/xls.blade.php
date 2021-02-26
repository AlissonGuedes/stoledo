@php

$idNFe = request()->route()->parameters['nfe'];
$row = $sped_model->getNFeById($idNFe);

@endphp

<table>
    <thead>
        <tr>
            <th colspan="5" style="text-align: center"><b>Informações da Nota Fiscal -
                    {{ $row->numero }}-{{ $row->serie }}</b></th>
        </tr>
        <tr></tr>
        <tr>
            <th style="text-align: center"><b> {{ cnpj($row->cpf_cnpj_emit) }}</b></th>
            <th colspan="3" style="text-align: center"><b>{{ $row->nome }}</b></th>
        </tr>
    </thead>
</table>

<table>

    <thead>
        <tr>
            <th style="text-align: center"><b>Chave NFe</b></th>
            <th style="text-align: center"><b>Número da NF</b></th>
            <th style="text-align: center"><b>Data de Emissão</b></th>
            <th style="text-align: center"><b>Tipo de Pagamento</b></th>
            <th style="text-align: center"><b>Valor</b></th>
        </tr>
    </thead>

    <tbody>

        <tr>
            <td>{{ $row->chNFe }} </td>
            <td>{{ $row->nNF }}-{{ $row->serie }}</td>
            <td>{{ date('d/m/Y H:i:s', strtotime($row->dhEmi)) }} </td>
            <td>{{ $row->tPag }}</td>
            <td>R$ {{ number_format($row->vPag, 2, ',', '.') }} </td>
        </tr>

    </tbody>
</table>


@php
$nfe_model = new App\Models\NFeModel();
$duplicatas = $nfe_model->getDuplicatasByNFe('NFe' . $row->chNFe);
@endphp
@if ($duplicatas->count() > 0)
    <table>
        <thead>
            <tr>
                <th colspan="5" style="text-align: center"><b>Duplicatas</b></th>
            </tr>
        </thead>
    </table>

    <table>

        <thead>
            <tr>
                <th style="text-align: center"><b>Número da duplicata</b></th>
                <th style="text-align: center"><b>Vencimento</b></th>
                <th style="text-align: center"><b>Valor</b></th>
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

@endif
