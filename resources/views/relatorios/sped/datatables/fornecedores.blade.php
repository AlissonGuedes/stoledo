<?php

$records = [];

if ( isset($rows) ) {

	$sped = new \App\Models\SpedModel();

	foreach ( $rows as $row ){

		$totalNotas = $sped -> distinct() -> select('chave_de_acesso') -> from('tb_lista_nfe') -> where('cpf_cnpj_emit', '=', $row -> cEmi) ->
		groupBy('chave_de_acesso', 'cod_prod') -> get() -> count();

		$records[] = array(
			'<label><input type="checkbox" name="id[]" value="' . str_replace(['.','/', '-'], '', $row -> cEmi) . '"><span></span></label>',
			cnpj($row -> cEmi),
			strtoupper($row->xNome),
			'R$ ' . number_format($row -> totalAquisicoes, 2, ',', '.'),
			$totalNotas
			// '<a href="' . route('reports.sped.detalhamento', [
			// 	'cnpj' => $row->cnpj_fornecedor,
			// 	'data_inicio' => convert_to_date($row->dt_ini, 'dmY'),
			// 	'data_fim' => convert_to_date($row->dt_fin, 'dmY'),
			// 	'emitente' => $row -> cEmi
			// ]) . '">Ver</a>'
		);

	}

}

echo json_encode([
	'data' => $records,
	'recordsFiltered' => $numRows,
]);

?>
