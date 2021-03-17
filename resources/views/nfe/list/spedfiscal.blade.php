{? $records = [] ?}

@if (isset($paginate))

    @foreach ($paginate as $row)

        <tr class="{{ $row->status === '0' ? 'blocked' : null }}"
            id="{{ $row->cnpj_fornecedor }}/{{ $row->dt_ini }}/{{ $row->dt_fin }}" data-disabled="false">

            <td width="1%" data-disabled="true">
                <label>
                    <input type="checkbox" name="id[]" class="light-blue" value="{{ $row->cnpj }}"
                        data-status="{{ $row->status }}">
                    <span></span>
                </label>
            </td>
            <td style="width: 20%"> {{ strtoupper($row->empresa) }} </td>
            <td style="width: 15%"> {{ cnpj($row->cnpj_fornecedor) }} </td>
            <td style="width: 20%"> {{ $row->contador }} </td>
            <td style="width: 15%">
                {{ convert_to_date($row->dt_ini) }} -
                {{ convert_to_date($row->dt_fin) }}
            </td>
            <td style="width: 15%" data-disabled="true">
                <a
                    href="{{ route('reports.sped.notas.nao-escrituradas', [0, $row->cnpj_fornecedor, convert_to_date($row->dt_ini, 'dmY'), convert_to_date($row->dt_fin, 'dmY')]) }}">
                    Listar NF-e
                </a>
            </td>

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
