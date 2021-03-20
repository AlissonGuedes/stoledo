#!/bin/bash

#########################################################################
# Função para obter informações da Entidade do SPED [[ REGISTRO 0005 ]] #
#########################################################################
function Empresa() {

	EMPRESA=$1
	INFO=$2

	REG=$(echo $EMPRESA | cut -d '|' -f 1)
	CNPJ=$(echo $INFO | cut -d '|' -f 7)
	FANTASIA=$(echo $EMPRESA | cut -d '|' -f 2 | sed 's/+/\ /g')
	NOME=$FANTASIA
	COD_PAIS=''
	COD_MUN=$(echo $INFO | cut -d '|' -f 11)
	UF=$(echo $INFO | cut -d '|' -f 9)
	BAIRRO=$(echo $EMPRESA | cut -d '|' -f 7 | sed 's/+/\ /g')
	END=$(echo $EMPRESA | cut -d '|' -f 4 | sed 's/+/\ /g')
	CEP=$(echo $EMPRESA | cut -d '|' -f 3)
	NUM=$(echo $EMPRESA | cut -d '|' -f 5 | sed 's/+/\ /g')
	COMPL=$(echo $EMPRESA | cut -d '|' -f 6 | sed 's/+/\ /g')
	FONE=$(echo $EMPRESA | cut -d '|' -f 8 | sed 's/+/\ /g')
	FAX=$(echo $EMPRESA | cut -d '|' -f 9 | sed 's/+/\ /g')
	EMAIL=$(echo $EMPRESA | cut -d '|' -f 10)
	IE=$(echo $INFO | cut -d '|' -f 10)
	INDIEDEST=0
	CRT=''
	CPF=$(echo $INFO | cut -d '|' -f 8)
	IM=$(echo $INFO | cut -d '|' -f 12)
	SUFRAMA=$(echo $INFO | cut -d '|' -f 13)
	IND_ATIV=$(echo $INFO | cut -d '|' -f 15 | sed 'N ; N ; s/\n//')

	query="SELECT id FROM tb_fornecedor WHERE  cpf = '$CPF' OR cnpj = '$CNPJ' OR ie = '$IE' OR im = '$IM';";

	result=$(Execute "$query")

	if [[ $result == '' ]]
	then

		query="INSERT INTO tb_fornecedor (cnpj, nome, xFant, cPais, cMun, uf, xBairro, xLgr, cep, nro, complemento, fone, fax, email, ie, indIEDest, crt, cpf, im, suframa, ind_ativ) VALUES ('$CNPJ', '$NOME', '$FANTASIA', '$COD_PAIS', '$COD_MUN', '$UF', '$BAIRRO', '$END', '$CEP', '$NUM', '$COMPL', '$FONE', '$FAX', '$EMAIL', '$IE', '$INDIEDEST', '$CRT', '$CPF', '$IM', '$SUFRAMA', '$IND_ATIV');"

		result=$(Execute "$query select last_insert_id();")

	fi

	echo $result | awk '{print $2}'

}
