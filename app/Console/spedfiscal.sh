#!/bin/bash

###################################################################
# Função para obter informações do Spedfiscal [[ REGISTRO 0000 ]] #
###################################################################

function Spedfiscal() {

	SPED=$1
	EMPRESA=$2
	CONTADOR=$3

	REG=$(echo $SPED | cut -d '|' -f 1)
	COD_VER=$(echo $SPED | cut -d '|' -f 2)
	COD_FIN=$(echo $SPED | cut -d '|' -f 3)
	DT_INI=$(echo $SPED | cut -d '|' -f 4)
	DT_FIN=$(echo $SPED | cut -d '|' -f 5)
	CNPJ=$(echo $SPED | cut -d '|' -f 7)
	IND_PERFIL=$(echo $SPED | cut -d '|' -f 14)

	query="SELECT id FROM tb_spedfiscal WHERE dt_ini = '$DT_INI' AND dt_fin = '$DT_FIN' AND cnpj_fornecedor = '$CNPJ';";

	result=$(Execute "$query")

	if [[ $result == '' ]]
	then

		query="INSERT INTO tb_spedfiscal (cnpj_fornecedor, id_contabilista, cod_ver, cod_fin, dt_ini, dt_fin, ind_perfil) VALUES ('$CNPJ', '$CONTADOR', '$COD_VER', '$COD_FIN', '$DT_INI', '$DT_FIN', '$IND_PERFIL');"

		result=$(Execute "$query select last_insert_id();")

	fi

	echo $result | awk '{print $2}'


}
