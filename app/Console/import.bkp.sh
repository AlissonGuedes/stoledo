#!/bin/bash

#########################################################################
source ../app/Console/DB.sh
source ../app/Console/SpedFiscal/spedfiscal.sh
source ../app/Console/SpedFiscal/empresa.sh
source ../app/Console/SpedFiscal/contabilista.sh
source ../app/Console/SpedFiscal/participante.sh
source ../app/Console/SpedFiscal/unidades_de_medida.sh
source ../app/Console/SpedFiscal/produto.sh
source ../app/Console/SpedFiscal/notafiscal.sh
#########################################################################

#########################################################################
# CREDENCIAIS PARA O BANCO DE DADOS
DATABASE=$1
USERNAME=$2
PASSWORD=$3
#########################################################################

#########################################################################
# Local de onde os registros vão ser processados
FILES=../storage/app/public/files/txt/spedfiscal/*.txt
#########################################################################

#########################################################################
# Arquivos para armazenamento dos logs
LOG=logs/imports.log

# Destino do arquivo de log
DIR_BACKUP=../storage/logs/imports/spedfiscal_$(echo "`date +%Y-%m-%d_%H%M%S`")
mkdir $DIR_BACKUP

#########################################################################

exit_success() {
	exit 0
}

if ls $FILES 2> /dev/null ; then

	for i in `ls $FILES`
	do

		> $LOG

		#########################################################################
		TIMESTART=$(echo "`date +%H%M%S`")							# Hora que o script iniciou
		DATESTART=$(echo "`date +%d/%m/%Y`, às `date +%H:%M:%S`")	# Data/Hora que o script iniciou
		#########################################################################

		#########################################################################
		# Nome do script .sql por arquivo
		SQL_FILE=spedfiscal # _$(echo "`date +%Y-%m-%d_%H%M%S`")

		# Local de destino do script .sql por arquivo
		SCRIPT_SQL=logs/$SQL_FILE.sql
		#########################################################################


		echo "#######################################################################"								>> $LOG
		echo "# Iniciando importação do Sped Fiscal	#" | expand -t 70												>> $LOG
		echo "# Arquivo: $(echo $i | cut -d '/' -f 8)	#" | expand -t 70											>> $LOG
		echo "# Data/Hora início da execução: ${DATESTART}	#" | expand -t 74										>> $LOG
		echo "# Empresa: $(head $i -n 1 | cut -d '|' -f 7 | sed 's/\+/\ /g')	#" | expand -t 70					>> $LOG
		echo "# Período: $(head $i -n 1 | cut -d '|' -f 5) a $(head $i -n 1 | cut -d '|' -f 6)	#" | expand -t 71	>> $LOG
		echo "#######################################################################" >> $LOG

		echo "[ ... ] - Criando arquivo arquivo $SCRIPT_SQL" >> $LOG
		echo "[ OK ] - Arquivo $SQL_FILE criado com sucesso!" >> $LOG

		> $SCRIPT_SQL

		echo "[ ... ] - Salvando procedures..." >> $LOG
		Procedures >> $SCRIPT_SQL
		echo "[ OK ] - Procedures salvas com sucesso!" >> $LOG

		SPEDFISCAL=0
		ID_SPEDFISCAL=0
		ID_EMPRESA=0
		ID_CONTADOR=0
		ID_PARTICIPANTE=0
		ID_UNIDADE=0
		ID_PRODUTO=0
		ID_NFE=0

		while IFS= read -r REGISTRO || [[ -n "$REGISTRO" ]]
		do

			DATETIME="[`date +%Y-%m-%d\ %H:%M:%S`] - "

			LINHA=$(echo $REGISTRO | sed 's/\ /\+/g' | sed 's/|//')
			REGISTRO=$(echo $REGISTRO | cut -d '|' -f 2)

			echo "$DATETIME Lendo registro $(echo $LINHA | tr '|' ' ' | sed 's/\+/\ /g')" >> $LOG

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
				if [[ $REGISTRO == '0100' ]]
				then
					ID_CONTADOR=$(Contabilista $LINHA)
					echo -e $ID_CONTADOR
				fi

				# Empresa
				if [[ $REGISTRO == '0005' ]]
				then
					ID_EMPRESA=$(Empresa $LINHA $SPEDFISCAL)
					echo -e $ID_EMPRESA
				fi

				# Registrar o nome do Sped no cabeçalho do arquivo de log
				if [[ $SPEDFISCAL != 0 ]] && [[ $ID_EMPRESA != 0 ]] && [[ $ID_CONTADOR != 0 ]]
				then

					ID_SPEDFISCAL=$(Spedfiscal $SPEDFISCAL $ID_EMPRESA $ID_CONTADOR)
					echo -e $ID_SPEDFISCAL

				fi

			fi
			# END REGISTRO 0000

			# BEGIN REGISTRO 0150
			if [[ $REGISTRO == '0150' ]]
			then

				# echo $DATETIME "Verificação do participante $(echo $LINHA | cut -d '|' -f 2) - $(echo $LINHA | cut -d '|' -f 3 | sed 's/\+/ /g')"

				ID_PARTICIPANTE=$(Participante $LINHA $ID_SPEDFISCAL)
				echo -e $ID_PARTICIPANTE

			fi
			# END REGISTRO 0150

			# BEGIN REGISTRO 0190
			if [[ $REGISTRO == '0190' ]]
			then

				# echo $DATETIME "Cadastrando unidade de medida $(echo $LINHA | cut -d '|' -f 2) - $(echo $LINHA | cut -d '|' -f 3 | sed 's/\+/ /g')"

				ID_UNIDADE=$(Unidades $LINHA)
				echo -e $ID_UNIDADE

			fi
			# END REGISTRO 0190

			# BEGIN REGISTRO 0200
			if [[ $REGISTRO == '0200' ]] || [[ $REGISTRO == '0220' ]]
			then

				if [[ $REGISTRO == '0200' ]]
				then

					# echo $DATETIME "Cadastrando produto $(echo $LINHA | cut -d '|' -f 2) - $(echo $LINHA | cut -d '|' -f 3 | sed 's/\+/ /g')"

					ID_PRODUTO=$(Produtos $LINHA)
					echo -e $ID_PRODUTO

				fi

				if [[ $REGISTRO == '0220' ]]
				then

					# echo $DATETIME "Cadastrando fator de conversão $(echo $LINHA | cut -d '|' -f 2) - $(echo $LINHA | cut -d '|' -f 3 | sed 's/\+/ /g')"

					ID_UNIDADE=$(ProdutoConversao $LINHA)
					echo -e $ID_UNIDADE

				fi

			fi
			# END REGISTRO 0200

			# BEGIN REGISTRO 0400 NOTAS FISCAIS
			if [[ $REGISTRO == '0400' ]]
			then

				# echo $DATETIME "Cadastrando natureza de operação $(echo $LINHA | cut -d '|' -f 2) - $(echo $LINHA | cut -d '|' -f 3 | sed 's/\+/ /g')"

				NATOP=$(Spedfiscal_NaturezaOperacao $LINHA)
				echo $NATOP

			fi
			# END REGISTRO 0400 NOTAS FISCAIS

			# BEGIN REGISTRO 0450 NOTAS FISCAIS
			if [[ $REGISTRO == '0450' ]]
			then

				# echo $DATETIME "Cadastrando informações complementares $(echo $LINHA | cut -d '|' -f 2) - $(echo $LINHA | cut -d '|' -f 3 | sed 's/\+/ /g')"

				INFOCOMPL=$(Spedfiscal_InformacaoComplementar $LINHA)
				echo $INFOCOMPL

			fi
			# END REGISTRO 0450 NOTAS FISCAIS

			# BEGIN REGISTRO C100 NOTAS FISCAIS
			if [[ $REGISTRO == 'C100' ]]
			then

				# echo $DATETIME "Cadastrando Nota Fiscal $(echo $LINHA | cut -d '|' -f 9)"

				ID_NFE=$(Notafiscal $LINHA)
				echo $ID_NFE

			fi
			# END REGISTRO C100

			# BEGIN REGISTRO C110 INFORMAÇÕES COMPLEMENTARES DA NF
			if [[ $REGISTRO == 'C110' ]]
			then

				# echo $DATETIME "Cadastrando informações complementares da nota fiscal $ID_NFE - $(echo $LINHA | cut -d '|' -f 3 | sed 's/\+/ /g')"

				ID_INF_NFE=$(Notafiscal_InformacaoComplementar $LINHA)
				echo $ID_INF_NFE

			fi
			# END REGISTRO C110

			# BEGIN REGISTRO C170 ITENS DA NF
			if [[ $REGISTRO == 'C170' ]]
			then

				# echo $DATETIME "Cadastrando itens da nota fiscal $ID_NFE - $(echo $LINHA | cut -d '|' -f 3 | sed 's/\+/ /g')"

				ITENS_NFE=$(Notafiscal_Itens $LINHA)
				echo $ITENS_NFE

			fi
			# END REGISTRO C170

		done < $i >> $SCRIPT_SQL

		echo "Executando a persistência dos dados..." >> $LOG

		# Importa no banco de dados o arquivo gerado {$SCRIPT_SQL}
		mysql --database=$DATABASE --user=$USERNAME --password=$PASSWORD < $SCRIPT_SQL

		echo "Informações salvas com sucesso!"

		#########################################################################
		TIMEEND=$(echo "`date +%H%M%S`")				# Hora que o script finalizou
		DATEEND=$(echo "`date +%d/%m/%Y`, às `date +%H:%M:%S`")	# Data/Hora que o script finalizou
		TIMETOTAL=$(echo $((TIMEEND - TIMESTART)))	# Calcula o tempo que o script passou para ser processado
		#######################################################################

		# Marca a data e hora que o script finalizou
		echo "#######################################################################"
		echo "# Script finalizado às $DATEEND	#" >> $LOG | expand -t 72
		echo "# Tempo decorrido: $TIMETOTAL segundos	#" >> $LOG | expand -t 70
		echo "# Data/Hora início da execução: ${DATESTART}	#" | expand -t 74
		echo "# Empresa: $(echo $SPEDFISCAL | cut -d '|' -f 6 | sed 's/\+/\ /g')	#" | expand -t 70
		echo "# Período: $(echo $SPEDFISCAL | cut -d '|' -f 4) a $(echo $SPEDFISCAL | cut -d '|' -f 5)	#" | expand -t 71
		echo "#######################################################################"

		# Depois de finalizado, renomeia o arquivo para não ser sobrescrito em um próximo processamento
		mv $i $DIR_BACKUP/$(echo $i | cut -d '/' -f 8)
		mv logs/$SQL_FILE.sql $DIR_BACKUP/$SQL_FILE.sql

	done

else

	echo 'Não há arquivos para importar' >> $LOG

fi

mv $LOG $DIR_BACKUP/imports.log
exit_success
