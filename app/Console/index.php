#!/usr/bin/php
<?php

function processa($registro) {
	return str_replace('+', ' ', explode('|', $registro));
}

function inserirContador($registro) {

	$contador =  processa($registro);

	$values = [
		$contador[1],
		$contador[2],
		$contador[3],
		$contador[4],
		$contador[5],
		$contador[6],
		$contador[7],
		$contador[8],
		$contador[9],
		$contador[10],
		$contador[11],
		$contador[12],
		$contador[13]
	];

	$query = 'INSERT INTO tb_contabilista (`nome`, `cpf`, `crc`, `cnpj`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `fone`, `fax`, `email`, `cod_mun`) VALUES ("' . implode('","', $values) . '");';

	$id = 'SELECT LAST_INSERT_ID();';

	echo $query ."\n" . $id;

}

function inserirSpedFiscal($registro) {

	$sped =  processa($registro);

	if ( $sped[0] == '0100')
		$id = inserirContador($registro);

	echo $id;
	// $values = [
	// 	$sped[6],
	// 	1,
	// 	$sped[1],
	// 	$sped[2],
	// 	$sped[3],
	// 	$sped[4],
	// 	$sped[13]
	// ];

	// echo 'INSERT INTO tb_spedfiscal (`cnpj_fornecedor`, `id_contabilista`, `cod_ver`, `cod_fin`, `dt_ini`, `dt_fin`, `ind_perfil`) VALUES ("' . implode('","', $values) . '");' . "\n";

}

function inserirFornecedor($registro) {

	// print_r(processa($registro));

	// echo 'INSERT INTO tb_fornecedor '

}