#!/bin/bash

###################################################################
# Função para obter informações do Spedfiscal [[ REGISTRO 0000 ]] #
###################################################################

function Unidades() {

	REG=$(echo $1 | cut -d '|' -f 1)
	UNID=$(echo $1 | cut -d '|' -f 2)
	DESCR=$(echo $1 | cut -d '|' -f 3)

	echo "SET @unidade='$UNID';"
	echo "SET @descricao='$DESCR';"

	echo "CALL Cadastra_UnidadesMedidas(@unidade, @descricao);"

}
