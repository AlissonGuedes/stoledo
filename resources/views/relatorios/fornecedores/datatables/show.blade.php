<?php

$records = [];

foreach ($rows -> get() as $row) {
	$records[] = [
		'<label><input type="checkbox" name="id[]" disabled class="light-blue" value="' . $row->cDest . '/' . $row->chNFe . '" data-status="' . $row -> status . '"><span></span></label>',
		cnpj($row->cDest),
		strtoupper($row->nome),
		$row->nNF . '-' . $row->serie,
		number_format($row->vPag, 2, ',', '.'),
		$row->tPag,
		$row->totalDup,
		'<a href="' . route('reports.fornecedores.nfe', ['cnpj' => $row->cDest, 'nfe' => $row->chNFe]) . '">
			Detalhes da nota
		</a>'
	];
}

echo json_encode([
	'data' => $records,
	'recordsFiltered' => $numRows,
	'totalRecords' => $totalRecords,
]);
