#!/bin/bash

####################################################################
# Função para obter as informações do Contador [[ REGISTRO 0100 ]] #
####################################################################
function Contabilista() {

	CONTADOR=$1

	REG=$(echo $CONTADOR | cut -f 1 -d "|")
	NOME=$(echo $CONTADOR | cut -f 2 -d "|" | sed 's/\+/\ /g')
	CPF=$(echo $CONTADOR | cut -f 3 -d "|")
	CRC=$(echo $CONTADOR | cut -f 4 -d "|")
	CNPJ=$(echo $CONTADOR | cut -f 5 -d "|")
	CEP=$(echo $CONTADOR | cut -f 6 -d "|")
	END=$(echo $CONTADOR | cut -f 7 -d "|" | sed 's/\+/\ /g')
	NUM=$(echo $CONTADOR | cut -f 8 -d "|" | sed 's/\+/\ /g')
	COMPL=$(echo $CONTADOR | cut -f 9 -d "|" | sed 's/\+/\ /g')
	BAIRRO=$(echo $CONTADOR | cut -f 10 -d "|" | sed 's/\+/\ /g')
	FONE=$(echo $CONTADOR | cut -f 11 -d "|")
	FAX=$(echo $CONTADOR | cut -f 12 -d "|")
	EMAIL=$(echo $CONTADOR | cut -f 13 -d "|")
	COD_MUN=$(echo $CONTADOR | cut -f 14 -d "|")

	echo "SET @nome='$NOME';"
	echo "SET @cpf='$CPF';"
	echo "SET @crc='$CRC';"
	echo "SET @cnpj='$CNPJ';"
	echo "SET @cep='$CEP';"
	echo "SET @logradouro='$END';"
	echo "SET @numero='$NUM';"
	echo "SET @complemento='$COMPL';"
	echo "SET @bairro='$BAIRRO';"
	echo "SET @fone='$FONE';"
	echo "SET @fax='$FAX';"
	echo "SET @email='$EMAIL';"
	echo "SET @cod_mun='$COD_MUN';"

	echo "CALL Cadastra_Contador(@nome, @cpf, @crc, @cnpj, @cep, @logradouro, @numero, @complemento, @bairro, @fone, @fax, @email, @cod_mun);"

}
