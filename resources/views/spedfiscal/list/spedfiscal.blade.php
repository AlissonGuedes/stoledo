{? $records = [] ?}

@if (isset($paginate))

    @foreach ($paginate as $row)

        {? $data_inicio = convert_to_date($row->dt_ini, 'dmY'); ?}
        {? $data_fim = convert_to_date($row->dt_fin, 'dmY');?}
		{? $url = route('reports.sped.notas.nao-escrituradas', [0, $row->cnpj_fornecedor, $data_inicio, $data_fim]); ?}

		<tr class="{{ $row->status === '0' ? 'blocked' : null }}" data-link="{{ $url }}"
            id="{{ $row->id }}" data-disabled="false">

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
            <td style="width: 15%"> {{ $data_inicio }} - {{ $data_fim }} </td>

            <td style="width: 15%" data-disabled="true">
                <a
                    href="{{ $url }}">
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
