#!/bin/bash

###################################################################
# Função para obter informações do Spedfiscal [[ REGISTRO 0000 ]] #
###################################################################

function Spedfiscal() {

	SPED=$1

	REG=$(echo $SPED | cut -d '|' -f 1)
	COD_VER=$(echo $SPED | cut -d '|' -f 2)
	COD_FIN=$(echo $SPED | cut -d '|' -f 3)
	DT_INI=$(echo $SPED | cut -d '|' -f 4)
	DT_FIN=$(echo $SPED | cut -d '|' -f 5)
	CNPJ=$(echo $SPED | cut -d '|' -f 7)
	IND_PERFIL=$(echo $SPED | cut -d '|' -f 14)

	echo "SET @cod_ver='$COD_VER';"
	echo "SET @cod_fin='$COD_FIN';"
	echo "SET @dt_ini='$DT_INI';"
	echo "SET @dt_fin='$DT_FIN';"
	echo "SET @cnpj_fornecedor='$CNPJ';"
	echo "SET @ind_perfil='$IND_PERFIL';"

	echo "CALL Cadastra_Spedfiscal(@cod_ver, @cod_fin, @dt_ini, @dt_fin, @cnpj_fornecedor, @idContador, @ind_perfil);"

}

###################################################################
# Função para cadastrar Natureza de Operação  [[ REGISTRO 0400 ]] #
###################################################################
function Spedfiscal_NaturezaOperacao() {

	OPERACAO=$1

	REG=$(echo $OPERACAO | cut -d '|' -f 1)
	COD_NAT=$(echo $OPERACAO | cut -d '|' -f 2)
	DESCR_NAT=$(echo $OPERACAO | cut -d '|' -f 3 | sed 's/\+/\ /g')

	echo "set @codNatureza='$COD_NAT';"
	echo "set @descricao='$DESCR_NAT';"
	echo "CALL Cadastra_NaturezaOperacao(@codNatureza, @descricao);"

}


###################################################################
# Cadastro de Informação Complementar da NFe  [[ REGISTRO 0450 ]] #
###################################################################
function Spedfiscal_InformacaoComplementar() {

	OPERACAO=$1

	REG=$(echo $OPERACAO | cut -d '|' -f 1)
	COD_INF=$(echo $OPERACAO | cut -d '|' -f 2)
	TEXTO=$(echo $OPERACAO | cut -d '|' -f 3 | sed 's/\+/\ /g')

	echo "set @codInformacao='$COD_INF';"
	echo "set @descricao='$TEXTO';"
	echo "CALL Cadastra_InformacaoComplementar(@codInformacao, @descricao);"

}