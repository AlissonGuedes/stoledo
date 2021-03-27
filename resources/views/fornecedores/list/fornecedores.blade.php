{? $records = [] ?}

@if (isset($paginate))

    @foreach ($paginate as $row)

        <tr class="{{ $row->status === '0' ? 'blocked' : null }}" id="{{ $row->cnpj }}" data-disabled="false">

            <td width="1%" data-disabled="true">
                <label>
                    <input type="checkbox" name="id[]" class="light-blue" value="{{ $row->cnpj }}"
                        data-status="{{ $row->status }}">
                    <span></span>
                </label>
            </td>
            <td style="width: 40%"> {{ strtoupper($row->xFant) }} </td>
            <td style="width: 15%"> {{ cnpj($row->cnpj) }} </td>
            <td style="width: 15%"> {{ $row->qtd_nf }} </td>
            <td style="width: 15%" class="right-align"> <span class="left">R$</span>
                {{ number_format($row->totais, 2, ',', '.') }} </td>
            <td style="width: 15%"> <a href="{{ route('reports.fornecedores.notas_fiscais', $row->cnpj) }}">Listar
                    NF-e</a> </td>

        </tr>

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
