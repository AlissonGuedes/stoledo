#!/bin/bash

#########################################################################
# Função para obter informações da Entidade do SPED [[ REGISTRO 0005 ]] #
#########################################################################
function Participante() {

	PARTICIPANTE=$1
	SPEDFISCAL=$2

	REG=$(echo $PARTICIPANTE | cut -d '|' -f 1)
	COD_PART=$(echo $PARTICIPANTE | cut -d '|' -f 2)
	NOME=$(echo $PARTICIPANTE | cut -d '|' -f 3 | sed 's/+/\ /g')
	COD_PAIS=$(echo $PARTICIPANTE | cut -d '|' -f 4)
	CNPJ=$(echo $PARTICIPANTE | cut -d '|' -f 5)
	CPF=$(echo $PARTICIPANTE | cut -d '|' -f 6)
	IE=$(echo $PARTICIPANTE | cut -d '|' -f 7)
	COD_MUN=$(echo $PARTICIPANTE | cut -d '|' -f 8)
	SUFRAMA=$(echo $PARTICIPANTE | cut -d '|' -f 9)
	END=$(echo $PARTICIPANTE | cut -d '|' -f 10 | sed 's/+/\ /g')
	NUM=$(echo $PARTICIPANTE | cut -d '|' -f 11 | sed 's/+/\ /g')
	COMPL=$(echo $PARTICIPANTE | cut -d '|' -f 12 | sed 's/+/\ /g')
	BAIRRO=$(echo $PARTICIPANTE | cut -d '|' -f 13 | sed 's/+/\ /g')
	FANTASIA=''
	UF=''
	CEP=''
	FONE=''
	FAX=''
	EMAIL=''
	INDIEDEST=0
	CRT=''
	IM=''
	IND_ATIV=0

	if [[ $CNPJ != '' ]]
	then
		WHERE="cnpj = '$CNPJ'"
	elif [[ $CPF != '' ]]
	then
		WHERE="cpf = '$CPF'"
	elif [[ $IE != '' ]]
	then
		WHERE="ie = '$IE'"
	fi

	query="SELECT id FROM tb_fornecedor WHERE $WHERE;";

	result=$(Execute "$query")

	if [[ $result == '' ]]
	then

		query="INSERT INTO tb_fornecedor (cnpj, nome, xFant, cPais, cMun, uf, xBairro, xLgr, cep, nro, complemento, fone, fax, email, ie, indIEDest, crt, cpf, im, suframa, ind_ativ) VALUES ('$CNPJ', '$NOME', '$FANTASIA', '$COD_PAIS', '$COD_MUN', '$UF', '$BAIRRO', '$END', '$CEP', '$NUM', '$COMPL', '$FONE', '$FAX', '$EMAIL', '$IE', '$INDIEDEST', '$CRT', '$CPF', '$IM', '$SUFRAMA', '$IND_ATIV');"

		result=$(Execute "$query select last_insert_id();")

	fi

	ID=`echo $result | awk '{print $2}'`

	# Cadastrar o fornecedor na tabela de participantes do sped
	query="SELECT id FROM tb_spedfiscal_participante WHERE id_sped = '$SPEDFISCAL' AND id_fornecedor = '$ID';"

	result=$(Execute "$query")
	if [[ $result == '' ]]
	then

		query="INSERT INTO tb_spedfiscal_participante (id_sped, id_fornecedor, cod_part) VALUES ('$SPEDFISCAL', '$ID', '$COD_PART');"
		Execute "$query"

	fi

	echo $ID

}
