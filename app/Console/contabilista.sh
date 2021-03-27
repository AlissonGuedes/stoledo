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


	# query="SELECT id FROM tb_contabilista WHERE cpf = '$CPF' OR cnpj = '$CNPJ';";

	# result=$(Execute "$query")

	# if [[ $result == '' ]]
	# then

	# 	echo '-- --------------------------------------------\n'
	# 	echo '-- Inserido dados na tabela `tb_contabilista`  \n'
	# 	echo '-- --------------------------------------------\n'

	# 	query="INSERT INTO tb_contabilista (nome, cpf, crc, cnpj, cep, logradouro, numero, complemento, bairro, fone, fax, email, cod_mun) VALUES ('$NOME', '$CPF', '$CRC', '$CNPJ', '$CEP', '$END', '$NUM', '$COMPL', '$BAIRRO', '$FONE', '$FAX', '$EMAIL', '$COD_MUN');"

	# 	echo $query
	# 	echo '\n\n'

	# 	idContador="(select last_insert_id())"

	# else

	# 	idContador=$(echo $result | awk '{print $2}')

	# fi

	# echo '-- ------------------------------------------- \n'
	# echo '-- Obtendo o ID do Contador					 \n'
	# echo '-- ------------------------------------------- \n'

	# echo "set @idContador=$idContador;"

	# echo '-- ------------------------------------------- \n'

}
