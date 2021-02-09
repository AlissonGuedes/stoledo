<?php

$records = [];

if ( isset($xml) ) {

	foreach ( $xml as $row ){

		$records[] = array(
			'<label><input type="checkbox" name="id[]" class="light-blue" value="' . $row -> chNFe . '" data-status="' . $row -> status . '"><span></span></label>',
			$row->chNFe,
			$row->nNF . '-' . $row->serie ,
			cnpj($row->cEmi),
			$row->nome,
			'R$' . number_format($row->vOrig, 2, ',', '.'),
			'R$' . number_format($row->vBC, 2, ',', '.'),
			'R$' . number_format($row->vICMS, 2, ',', '.')
		);

	}

}

echo json_encode([
	'data' => $records,
	'recordsFiltered' => $numRows,
]);

?>
