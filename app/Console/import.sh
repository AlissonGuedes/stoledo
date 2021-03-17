#!/bin/bash

FILE=../storage/app/public/files/*/*.txt
LOG=$1

function insertFornecedor {

	fornecedor=$1

	var="inserirFornecedor('$fornecedor')"

	php -r 'include("../app/Console/index.php");'$var';'

}

function cadastraProduto {

	echo '==='

}


for i in `ls $FILE`
do

	while IFS= read -r linha || [[ -n "$linha" ]]
	do

		registro=$(echo -e $linha | sed 's/|//' | rev | sed 's/|//' | rev | sed 's/ /\+/g' | sed 's/\///g')
		linha=$(echo -e $linha | sed 's/|// ; s/|.*//' )

		if [[ $linha == '0150' ]]
		then

			insertFornecedor $registro

		else

			echo $registro

		fi

	done < "$i"

done >> $LOG
