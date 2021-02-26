<?php

$records = [];

if ( isset($rows) ) {

	foreach ( $rows as $row ){

		$dt_ini = convert_to_date($row -> dt_ini);
		$dt_fin = convert_to_date($row -> dt_fin);

		$records[] = array(
			'<label>
				<input type="checkbox" name="id[]" class="light-blue" value="' . $row -> cnpj_fornecedor . '/' . convert_to_date($row -> dt_ini, 'dmY') . '-' . convert_to_date($row -> dt_fin, 'dmY') . '" data-status="' . $row -> status . '">
				<span></span>
			</label>',
			$row->nome,
			cnpj($row->cnpj),
			$dt_ini,
			$dt_fin,
			$row->ind_perfil
		);

	}

}

echo json_encode([
	'data' => $records,
	'recordsFiltered' => $numRows,
]);

?>
