@php

use Illuminate\Support\Facades\DB;
$records = [];

if (isset($rows)) {
    $sped = new \App\Models\SpedModel();

    $cnpj_dest = request()->route()->parameters['cnpj'];
    $data_inicio = request()->route()->parameters['data_inicio'];
    $data_fim = request()->route()->parameters['data_fim'];

    foreach ($rows as $row) {
        $totalNaoEscrituradas = $sped
            ->getNFeNaoEscrituradas($row->cEmi, $data_inicio, $data_fim)
            ->get()
            ->count();

        if ($totalNaoEscrituradas > 0):
            $totalNotas = $sped
                ->distinct()
                ->select('chave_de_acesso')
                ->from('tb_lista_nfe')
                ->where('cpf_cnpj_emit', '=', $row->cEmi)
                ->groupBy('chave_de_acesso', 'cod_prod')
                ->get()
                ->count();

            $cnpj_emit = str_replace(['.', '/', '-'], '', $row->cEmi);

            $records[] = [
				'<label><input type="checkbox" name="id[]" value="' . $cnpj_emit . '"><span></span></label>',
				cnpj($row->cEmi),
				strtoupper($row->xNome),
				'R$ ' . number_format($row->totalAquisicoes, 2, ',', '.'),
				$totalNotas,
				$totalNaoEscrituradas,
				'<a href="' . url('reports/sped/' . $cnpj_dest . '/' . $data_inicio . '-' . $data_fim . '/' . $cnpj_emit) . '">Ver</a>'
			];
        endif;
    }
}

echo json_encode([
    'data' => $records,
    'recordsFiltered' => $numRows,
]);

@endphp
