#!/bin/bash

#########################################################################
# Função para obter informações de produtos do SPED [[ REGISTRO 0200 ]] #
#########################################################################
function Produtos() {

	PRODUTO=$1

	REG=$(echo $PRODUTO | cut -d '|' -f 1)
	COD_ITEM=$(echo $PRODUTO | cut -d '|' -f 2)
	DESCR_ITEM=$(echo $PRODUTO | cut -d '|' -f 3 | sed 's/+/\ /g')
	COD_BARRA=$(echo $PRODUTO | cut -d '|' -f 4)
	COD_ANT_ITEM=$(echo $PRODUTO | cut -d '|' -f 5)
	UNID_INV=$(echo $PRODUTO | cut -d '|' -f 6)
	TIPO_ITEM=$(echo $PRODUTO | cut -d '|' -f 7)
	COD_NCM=$(echo $PRODUTO | cut -d '|' -f 8)
	EX_IPI=$(echo $PRODUTO | cut -d '|' -f 9)
	COD_GEN=$(echo $PRODUTO | cut -d '|' -f 10 | sed 's/+/\ /g')
	COD_LST=$(echo $PRODUTO | cut -d '|' -f 11 | sed 's/+/\ /g')
	ALIQ_ICMS=$(echo $PRODUTO | cut -d '|' -f 12 | sed 's/\,/\./g')
	CEST=$(echo $PRODUTO | cut -d '|' -f 13)

	if [[ $CEST == '' ]]
	then
		CEST=0
	fi

	if [[ $COD_ITEM != '' ]]
	then

		WHERE="cod_item = '$COD_ITEM'"

	elif [[ $DESCR_ITEM != '' ]]
	then

		WHERE="descricao = '$DESCR_ITEM'"

	fi

	query="SELECT id FROM tb_produto WHERE $WHERE;";

	result=$(Execute "$query")

	if [[ $result == '' ]]
	then

		query="INSERT INTO tb_produto (cod_item, descricao, cod_barra, cod_ant_item, unidade_inv, tipo_item, cod_ncm, ex_ipi, cod_gen, cod_lst, aliquota_icms, cest) VALUES ('$COD_ITEM', '$DESCR_ITEM', '$COD_BARRA', '$COD_ANT_ITEM', '$UNID_INV', '$TIPO_ITEM', '$COD_NCM', '$EX_IPI', '$COD_GEN', '$COD_LST', '$ALIQ_ICMS', '$CEST');"

		result=$(Execute "$query select last_insert_id();")

	fi

	ID=`echo $result | awk '{print $2}'`

	echo $ID

}

#########################################################################
# Função para Fator de conversao do Produto [[ REGISTRO 0220 ]]			#
#########################################################################
function ProdutoConversao() {

	ID_PRODUTO=$1
	REG=$(echo $2 | cut -d '|' -f 1)
	UNIDADE=$(echo $2 | cut -d '|' -f 2)
	FATOR=$(echo $2 | cut -d '|' -f 3)

	# Cadastrar fator de conversão na tabela tb_produto_conversao
	query="SELECT id FROM tb_produto_conversao WHERE id_produto = '$ID_PRODUTO' AND unidade = '$UNIDADE';"

	result=$(Execute "$query")

	if [[ $result == '' ]]
	then

		query="INSERT INTO tb_produto_conversao (id_produto, unidade, fator_conversao) VALUES ('$ID_PRODUTO', '$UNIDADE', '$FATOR');"
		Execute "$query"

	fi

}