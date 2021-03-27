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

	# query="SELECT id FROM tb_unidade_medida WHERE unidade = '$UNID' AND descricao = '$DESCR';";

	# result=$(Execute "$query")

	# if [[ $result == '' ]]
	# then

	# 	echo '-- \n'
	# 	echo '-- Inserido dados na tabela `tb_unidade_medida` \n'
	# 	echo '-- \n'

	# 	query="INSERT INTO tb_unidade_medida (unidade, descricao) VALUES ('$UNID', '$DESCR');"

	# 	# result=$(Execute "$query select last_insert_id();")
	# 	echo $query
	# 	echo '\n\n'

	# 	idUnidadeMedida="(select last_insert_id())"
	# else

	# 	idUnidadeMedida=$(echo $result | awk '{print $2}')

	# fi

	# echo '-- ------------------------------------------- \n'
	# echo '-- Obtendo o ID da Unidade de Medida			 \n'
	# echo '-- ------------------------------------------- \n'

	# echo "set @idUnidadeMedida=$idUnidadeMedida;"

	# echo '-- ------------------------------------------- \n'


}
