#!/bin/bash

USERNAME=$1
PASSWORD=$2
DATABASE=$3
LOG=$4
LOG_BACKUP=$5

FILE=../storage/app/public/files/*/*.txt

function Execute () {

	QUERY=$1
	mysql -e "$QUERY" --user=$USERNAME --password=$PASSWORD --database=$DATABASE

}

function Contabilista() {

	CONTADOR=$1

	NUM_REGISTRO=$(echo $1 | cut -f 1 -d "|")
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

	ID_CONTADOR=`echo $result | awk '{print $2}'`

	if [[ $ID_CONTADOR != '' ]]
	then

		echo $ID_CONTADOR

	else

		query="INSERT INTO tb_contabilista (nome, cpf, crc, cnpj, cep, logradouro, numero, complemento, bairro, fone, fax, email, cod_mun) VALUES ('$NOME', '$CPF', '$CRC', '$CNPJ', '$CEP', '$END', '$NUM', '$COMPL', '$BAIRRO', '$FONE', '$FAX', '$EMAIL', '$COD_MUN');"

		ID_CONTADOR=$(Execute "$query select last_insert_id();")

		echo $ID_CONTADOR

	fi

}

function Spedfiscal() {

	SPED=$1
	CONTADOR=$2

	echo "$SPED $CONTADOR ======== "

}

for i in `ls $FILE`
do

	ID_SPED_FISCAL=0
	ID_CONTADOR=0

	# while IFS= read -r REGISTRO || [[ -n "$REGISTRO" ]]
	# do

	# 	LINHA=$(echo -e $REGISTRO | sed 's/|//' | rev | sed 's/|//' | rev | sed 's/ /\+/g' | sed 's/\///g')
	# 	REGISTRO=$(echo -e $REGISTRO | sed 's/|// ; s/|.*//' )

	# 	if [[ $REGISTRO == 0100 ]] || [[ $REGISTRO == 0000 ]]
	# 	then

	# 		if [[ $REGISTRO == 0000 ]]
	# 		then
	# 			ID_SPED_FISCAL=$(echo $LINHA | cut -f2 -d "|")
	# 		fi

	# 		if [[ $REGISTRO == 0100 ]]
	# 		then
	# 			ID_CONTADOR=$(echo `Contabilista $LINHA`)
	# 		fi
	# 	fi

	# 	if [[ $ID_SPED_FISCAL != 0 ]] && [[ $ID_CONTADOR != 0 ]]
	# 	then

	# 		echo Spedfiscal $LINHA $ID_CONTADOR $ID_SPED_FISCAL

	# 	fi

	# done < "$i"

	echo 'Importando arquivo ' $i

done > $LOG

mv $LOG $LOG_BACKUP

 # "`date +%Y-%m-%d_%H%M%S`".log
echo "A importação do arquivo foi finalizada!"
