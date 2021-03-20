#!/bin/bash

#########################################################################
source ../app/Console/DB.sh
source ../app/Console/spedfiscal.sh
source ../app/Console/empresa.sh
source ../app/Console/contabilista.sh
source ../app/Console/participante.sh
source ../app/Console/unidades_de_medida.sh
source ../app/Console/produto.sh
#########################################################################

#########################################################################
TIMESTART=$(echo "`date +%H%M%S`")					# Hora que o script iniciou
DATESTART=$(echo "`date +%d/%m/%Y`, às `date +%H:%M:%S`")	# Data/Hora que o script iniciou
USERNAME=$1
PASSWORD=$2
DATABASE=$3
LOG=$4
LOG_BACKUP=$5
FILE=../storage/app/public/files/*/*.txt
#########################################################################

> $LOG

for i in `ls $FILE`
do

	SPEDFISCAL=0
	ID_SPEDFISCAL=0
	ID_EMPRESA=0
	ID_CONTADOR=0
	ID_PRODUTO=0

	while IFS= read -r REGISTRO || [[ -n "$REGISTRO" ]]
	do

		DATETIME="[`date +%Y-%m-%d\ %H:%M:%S`] - "

		LINHA=$(echo -e $REGISTRO | sed 's/ /\+/g' | sed 's/\///g ; s/|//')
		REGISTRO=$(echo -e $REGISTRO | sed 's/|// ; s/|.*//' )

		# Precisamos guardar as informações do arquivo para não perdê-las:
		# >>> Registro 0000: Spedfiscal
		# >>> Registro 0005: Empresa
		# >>> Registro 0100: Contador

		# BEGIN REGISTRO 0000
		# Gravar informações do arquivo: Spedfiscal, Contador e Empresa
		if  [[ $REGISTRO == '0000' ]] || [[ $REGISTRO == '0005' ]] || [[ $REGISTRO == '0100' ]]
		then

			# Spedfiscal
			# Primeiro, pegamos apenas o registro da linha 0000 para manipular mais à frente
			if [[ $REGISTRO == '0000' ]]
			then
				SPEDFISCAL=$LINHA
			fi

			# Contador
			# Antes de tudo, vamos primeiro gravar no banco de dados as informações
			# da empresa e do contador para vinculá-las na tabela do spedfiscal (tb_spedfiscal)
			if [[ $REGISTRO == 0100 ]]
			then
				ID_CONTADOR=$(Contabilista $LINHA)
			fi

			# Empresa
			if [[ $REGISTRO == '0005' ]]
			then
				ID_EMPRESA=$(Empresa $LINHA $SPEDFISCAL)
			fi

			# Registrar o nome do Sped no cabeçalho do arquivo de log
			if [[ $SPEDFISCAL != 0 ]] && [[ $ID_EMPRESA != 0 ]] && [[ $ID_CONTADOR != 0 ]]
			then

				echo "#######################################################################"
				echo "# Importação SpedFiscal	#" | expand -t 72
				echo "# Arquivo: $i	#" | expand -t 70
				echo "# Data/Hora início da execução: ${DATESTART}	#" | expand -t 74
				echo "# Empresa: $(echo $SPEDFISCAL | cut -d '|' -f 6 | sed 's/\+/\ /g')	#" | expand -t 70
				echo "# Período: $(echo $SPEDFISCAL | cut -d '|' -f 4) a $(echo $SPEDFISCAL | cut -d '|' -f 5)	#" | expand -t 71
				echo "#######################################################################"

				ID_SPEDFISCAL=$(Spedfiscal $SPEDFISCAL $ID_EMPRESA $ID_CONTADOR)

			fi

		fi
		# END REGISTRO 0000

		# BEGIN REGISTRO 0150
		if [[ $REGISTRO == '0150' ]]
		then

			echo $DATETIME "Verificação do participante $(echo $LINHA | cut -d '|' -f 2) - $(echo $LINHA | cut -d '|' -f 3 | sed 's/\+/ /g')"

			ID_PARTICIPANTE=$(Participante $LINHA $ID_SPEDFISCAL)

		fi
		# END REGISTRO 0150

		# BEGIN REGISTRO 0190
		if [[ $REGISTRO == '0190' ]]
		then

			echo $DATETIME "Cadastrando unidade de medida $(echo $LINHA | cut -d '|' -f 2) - $(echo $LINHA | cut -d '|' -f 3 | sed 's/\+/ /g')"

			ID_UNIDADE=$(Unidades $LINHA) >> $LOG

		fi
		# END REGISTRO 0190

		# BEGIN REGISTRO 0200
		if [[ $REGISTRO == '0200' ]] || [[ $REGISTRO == '0220' ]]
		then

			if [[ $REGISTRO == '0200' ]]
			then

				echo $DATETIME "Cadastrando produto $(echo $LINHA | cut -d '|' -f 2) - $(echo $LINHA | cut -d '|' -f 3 | sed 's/\+/ /g')"

				ID_PRODUTO=$(Produtos $LINHA)

			fi

			if [[ $REGISTRO == '0220' ]]
			then

				echo $DATETIME "Cadastrando fator de conversão $(echo $LINHA | cut -d '|' -f 2) - $(echo $LINHA | cut -d '|' -f 3 | sed 's/\+/ /g')"

				ProdutoConversao $ID_PRODUTO $LINHA

			fi

		fi
		# END REGISTRO 0200

	done < "$i"

	echo ''
	echo "#######################################################################"
	echo '# Importação do arquivo '$i' finalizada com sucesso!	#'  | expand -t 70
	echo '#######################################################################'
	echo ''

done >> $LOG

echo '#######################################################################'	>> $LOG
echo '# Todas as importações foram realizadas com sucesso!'						>> $LOG
echo '#######################################################################'	>> $LOG
echo ''	>> $LOG

TIMEEND=$(echo "`date +%H%M%S`")				# Hora que o script finalizou
DATEEND=$(echo "`date +%d/%m/%Y`, às `date +%H:%M:%S`")	# Data/Hora que o script finalizou

TIMETOTAL=$(echo $((TIMEEND - TIMESTART)))	# Calcula o tempo que o script passou para ser processado

echo 'Script finalizado às '	$DATEEND	>> $LOG
echo 'Tempo decorrido: '		$TIMETOTAL	>> $LOG ' segundos'

# Depois de finalizado, renomeia o arquivo para não ser sobrescript em um próximo processamento
mv $LOG $LOG_BACKUP