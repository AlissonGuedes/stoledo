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

}