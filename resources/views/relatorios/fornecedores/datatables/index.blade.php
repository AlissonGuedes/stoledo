<?php

$records = [];

if ( isset($rows) ) {

	foreach ( $rows -> get() as $row ){

		$records[] = array(
			'<label><input type="checkbox" name="id[]" class="light-blue" value="' . $row -> cnpj . '" data-status="' . $row -> status . '"><span></span></label>',
			strtoupper($row->nome),
			cnpj($row->cnpj),
			$row -> qtd_nf,// $fornecedor_model -> getTotalNFe($row -> cnpj) -> total,
			'R$' . number_format($row->totais, 2, ',', '.'),
			'<a href="' . route('reports.fornecedores.cnpj', $row->cnpj) . '">Listar NF-e</a>'
		);

	}

}
echo json_encode([
	'data' => $records,
	'recordsFiltered' => $numRows,
	'totalRecords' => $totalRecords
]);
