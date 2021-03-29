#!/bin/bash

#########################################################################
# Função para obter informações de produtos do SPED [[ REGISTRO 0200 ]] #
#########################################################################
function Produtos() {

	PRODUTO=$1

	REG=$(echo $PRODUTO | cut -d '|' -f 1)
	COD_ITEM=$(echo $PRODUTO | cut -d '|' -f 2)
	DESCR_ITEM=$(echo $PRODUTO | cut -d '|' -f 3 | sed 's/\+/\ /g')
	COD_BARRA=$(echo $PRODUTO | cut -d '|' -f 4)
	COD_ANT_ITEM=$(echo $PRODUTO | cut -d '|' -f 5)
	UNID_INV=$(echo $PRODUTO | cut -d '|' -f 6)
	TIPO_ITEM=$([[ $(echo $PRODUTO | cut -d '|' -f 7) != '' ]] && echo $PRODUTO | cut -d '|' -f 7 || echo 0 )
	COD_NCM=$(echo $PRODUTO | cut -d '|' -f 8)
	EX_IPI=$(echo $PRODUTO | cut -d '|' -f 9)
	COD_GEN=$([[ $(echo $PRODUTO | cut -d '|' -f 10) != '' ]] && echo $PRODUTO | cut -d '|' -f 10 || echo 0 )
	COD_LST=$(echo $PRODUTO | cut -d '|' -f 11 | sed 's/\+/\ /g')
	ALIQ_ICMS=$([[ $(echo $PRODUTO | cut -d '|' -f 12) != '' ]] && echo $PRODUTO | cut -d '|' -f 12 | sed 's/\,/\./g' || echo 0.00 )
	CEST=$([[ $(echo $PRODUTO | cut -d '|' -f 13) != '' ]] && echo $PRODUTO | cut -d '|' -f 13 | sed 's/\,/\./g' || echo 0.00 )

	echo "set @codItem='$COD_ITEM';"
	echo "set @descricao='$DESCR_ITEM';"
	echo "set @codBarra='$COD_BARRA';"
	echo "set @codAntItem='$COD_ANT_ITEM';"
	echo "set @unidInv='$UNID_INV';"
	echo "set @tipoItem='$TIPO_ITEM';"
	echo "set @codNcm='$COD_NCM';"
	echo "set @exIpi='$EX_IPI';"
	echo "set @codGen='$COD_GEN';"
	echo "set @codLst='$COD_LST';"
	echo "set @aliqICMS='$ALIQ_ICMS';"
	echo "set @cest='$CEST';"

	echo "CALL Cadastra_Produto(@codItem, @descricao, @codBarra, @codAntItem, @unidInv, @tipoItem, @codNcm, @exIpi, @codGen, @codLst, @aliqICMS, @cest);"

	# if [[ $CEST == '' ]]
	# then
	# 	CEST=0
	# fi

	# if [[ $COD_ITEM != '' ]]
	# then

	# 	WHERE="cod_item = '$COD_ITEM'"

	# elif [[ $DESCR_ITEM != '' ]]
	# then

	# 	WHERE="descricao = '$DESCR_ITEM'"

	# fi

	# query="SELECT id FROM tb_produto WHERE $WHERE;";

	# result=$(Execute "$query")

	# if [[ $result == '' ]]
	# then

	# 	echo '-- '
	# 	echo '-- Inserido dados na tabela `tb_produto` '
	# 	echo '-- '

	# 	query="INSERT INTO tb_produto (cod_item, descricao, cod_barra, cod_ant_item, unidade_inv, tipo_item, cod_ncm, ex_ipi, cod_gen, cod_lst, aliquota_icms, cest) VALUES ('$COD_ITEM', '$DESCR_ITEM', '$COD_BARRA', '$COD_ANT_ITEM', '$UNID_INV', '$TIPO_ITEM', '$COD_NCM', '$EX_IPI', '$COD_GEN', '$COD_LST', '$ALIQ_ICMS', '$CEST');"

	# 	echo $query ''
	# 	idProduto="(select last_insert_id())"

	# else

	# 	idProduto=$(echo $result | awk '{print $2}')

	# fi

	# echo "set @idProduto=$idProduto;" ''

}

#########################################################################
# Função para Fator de conversao do Produto [[ REGISTRO 0220 ]]			#
#########################################################################
function ProdutoConversao() {

	ID_PRODUTO=$1
	REG=$(echo $1 | cut -d '|' -f 1)
	UNIDADE=$(echo $1 | cut -d '|' -f 2)
	FATOR=$(echo $1 | cut -d '|' -f 3 | sed 's/\,/\./g')

	echo "set @unidade='$UNIDADE';"
	echo "set @fatorConversao='$FATOR';"
	echo "CALL Cadastra_ProdutoConversao(@idProduto, @unidade, @fatorConversao);"
	# # Cadastrar fator de conversão na tabela tb_produto_conversao
	# query="SELECT id FROM tb_produto_conversao WHERE id_produto = '$ID_PRODUTO' AND unidade = '$UNIDADE';"

	# result=$(Execute "$query")

	# if [[ $result == '' ]]
	# then

	# 	query="INSERT INTO tb_produto_conversao (id_produto, unidade, fator_conversao) VALUES ('$ID_PRODUTO', '$UNIDADE', '$FATOR');"
	# 	Execute "$query"

	# fi

}