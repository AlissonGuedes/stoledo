<?php

$records = [];

if ( isset($rows) ) {

	foreach ( $rows as $row ){

		$records[] = array(
			$row->idNFe,
			$row->nNF . '-' . $row -> serie,
			cnpj($row -> cEmi),
			$row -> nome_fornecedor,
			'R$ ' . number_format($row -> vOrig, 2, ',', '.'),
			'R$ ' . number_format($row -> vBC, 2, ',', '.'),
			'R$ ' . number_format($row -> vICMS, 2, ',', '.'),
			'<a href="' . route('reports.sped.detalhamento', [
					'cnpj' => $row->cnpj_fornecedor,
					'data_inicio' => convert_to_date($row->dt_ini, 'dmY'),
					'data_fim' => convert_to_date($row->dt_fin, 'dmY'),
					'emitente' => $row -> cEmi
			]) . '">Ver</a>'
		);

	}

}

echo json_encode([
	'data' => $records,
	'recordsFiltered' => $numRows,
]);

?>
