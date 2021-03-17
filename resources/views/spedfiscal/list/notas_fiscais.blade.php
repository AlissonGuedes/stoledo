{? $records = [] ?}

@if (isset($paginate))

    @foreach ($paginate as $row)

        {? $url = route('reports.fornecedores.nfe', ['emitente' => $row->cEmi, 'chave_nfe' => $row->chNFe]) ?}

        <tr class="{{ $row->status === '0' ? 'blocked' : null }}" id="{{ $row->chNFe }}"
            data-link="{{ $url }}" data-disabled="false">

            <td width="1%" data-disabled="true">
                <label>
                    <input type="checkbox" name="id[]" class="light-blue" value="{{ $row->cnpj }}"
                        data-status="{{ $row->status }}">
                    <span></span>
                </label>
            </td>
            <td style="width: 15%"> {{ cnpj($row->cDest) }} </td>
            <td style="width: 20%"> {{ strtoupper($row->nome) }} </td>
            <td style="width: 10%" class="right-align"> {{ $row->nNF . '-' . $row->serie }} </td>
            <td style="width: 15%" class="right-align"> {{ number_format($row->vPag, 2, ',', '.') }} </td>
            <td style="width: 15%" class="right-align"> {{ $row->tPag }} </td>
            <td style="width: 10%" class="right-align"> {{ $row->totalDup }} </td>

            <td style="width: 15%">
                <a href="{{ $url }}">
                    Detalhes da nota
                </a>
            </td>

    @endforeach

@else

    <tr>
        <td>
            <div class="white-text pt-2 center-align">
                Nenhum registro encontrado.
            </div>
        </td>
    </tr>

@endif

{{ paginate($paginate) }}
