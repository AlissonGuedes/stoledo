#!/bin/bash

####################################################################
# Função para obter as informações do Contador [[ REGISTRO 0100 ]] #
####################################################################
function Contabilista() {

	CONTADOR=$1

	REG=$(echo $1 | cut -f 1 -d "|")
	NOME=$(echo $1 | cut -f 2 -d "|" | sed 's/+/\ /g')
	CPF=$(echo $1 | cut -f 3 -d "|")
	CRC=$(echo $1 | cut -f 4 -d "|")
	CNPJ=$(echo $1 | cut -f 5 -d "|")
	CEP=$(echo $1 | cut -f 6 -d "|")
	END=$(echo $1 | cut -f 7 -d "|" | sed 's/+/\ /g')
	NUM=$(echo $1 | cut -f 8 -d "|" | sed 's/+/\ /g')
	COMPL=$(echo $1 | cut -f 9 -d "|" | sed 's/+/\ /g')
	BAIRRO=$(echo $1 | cut -f 10 -d "|" | sed 's/+/\ /g')
	FONE=$(echo $1 | cut -f 11 -d "|")
	FAX=$(echo $1 | cut -f 12 -d "|")
	EMAIL=$(echo $1 | cut -f 13 -d "|")
	COD_MUN=$(echo $1 | cut -f 14 -d "|")

	query="SELECT id FROM tb_contabilista WHERE cpf = '$CPF' OR cnpj = '$CNPJ';";

	result=$(Execute "$query")

	if [[ $result == '' ]]
	then

		query="INSERT INTO tb_contabilista (nome, cpf, crc, cnpj, cep, logradouro, numero, complemento, bairro, fone, fax, email, cod_mun) VALUES ('$NOME', '$CPF', '$CRC', '$CNPJ', '$CEP', '$END', '$NUM', '$COMPL', '$BAIRRO', '$FONE', '$FAX', '$EMAIL', '$COD_MUN');"

		result=$(Execute "$query select last_insert_id();")

	fi

	echo $result | awk '{print $2}'

}
