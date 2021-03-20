#!/bin/bash

###################################################################
# Função para obter informações do Spedfiscal [[ REGISTRO 0000 ]] #
###################################################################

function Unidades() {

	REG=$(echo $1 | cut -d '|' -f 1)
	UNID=$(echo $1 | cut -d '|' -f 2)
	DESCR=$(echo $1 | cut -d '|' -f 3)

	query="SELECT id FROM tb_unidade_medida WHERE unidade = '$UNID' AND descricao = '$DESCR';";

	result=$(Execute "$query")

	if [[ $result == '' ]]
	then

		query="INSERT INTO tb_unidade_medida (unidade, descricao) VALUES ('$UNID', '$DESCR');"

		result=$(Execute "$query select last_insert_id();")

	fi

	echo $result | awk '{print $2}'


}
