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

            <td> {{ $row->chNFe }} </td>
            <td> {{ $row->nNF }}-{{ $row->serie }} </td>
            <td class="right-align">
                <span class="left">R$</span>
                {{ number_format($row->vPag, 2, ',', '.') }}
            </td>
            <td class="right-align">
                <span class="left">R$</span>
                {{ number_format($row->vBC, 2, ',', '.') }}
            </td>
            <td class="right-align">
                <span class="left">R$</span>
                {{ number_format($row->vICMS, 2, ',', '.') }}
            </td>

            <td>
                <a href=" {{ $url }}">
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
