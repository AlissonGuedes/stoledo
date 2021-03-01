<?php

$records = [];

if ( isset($rows) ) {
    
    $nfe_model = new \App\Models\SpedModel();

	foreach ( $rows -> get() as $row ){
	    
		$records[] = array(
			'<label>
				<input type="checkbox" name="id[]" class="light-blue" value="' . $row -> chv_nfe . '" data-status="' . $row -> status . '">
				<span></span>
			</label>',
			$row -> chv_nfe,
			$row -> numero,
			cnpj($row->cEmit),
			strtoupper($row -> xNome),
			$row -> dt_emi,
			'R$ ' . $row->valor_total_da_nota,
			'R$ ' . $row->valor_do_icms,
			''
		);

	}

}

echo json_encode([
	'data' => $records,
	'recordsFiltered' => $recordsFiltered
]);
