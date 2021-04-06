#!/bin/bash

#########################################################################
source ../app/Console/DB.sh
source ../app/Console/SpedFiscal/Import_SpedFiscal.sh
source ../app/Console/NFe/Import_NotasFiscais.sh
#########################################################################

#########################################################################
# CREDENCIAIS PARA O BANCO DE DADOS
DATABASE=$1
USERNAME=$2
PASSWORD=$3
#########################################################################

#########################################################################
# Local de onde os registros vão ser processados
FILES=../storage/app/public/files/txt/*.txt
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

	> $LOG

	for i in `ls $FILES`
	do

		#########################################################################
		TIMESTART=$(echo "`date +%H%M%S`")							# Hora que o script iniciou
		DATESTART=$(echo "`date +%d/%m/%Y`, às `date +%H:%M:%S`")	# Data/Hora que o script iniciou
		#########################################################################

		#########################################################################
		# Nome do script .sql por arquivo
		SQL_FILE=imports_$(echo "`date +%Y-%m-%d_%H%M%S`")

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

		CHAVE_REGISTRO=''

		# Processamento dos arquivos
		while IFS= read -r ARQUIVO || [[ -n "$ARQUIVO" ]]
		do

			DATETIME="[`date +%Y-%m-%d\ %H:%M:%S`]"
			echo "$DATETIME - Lendo registro: $(echo $ARQUIVO | tr '|' ' ' | sed 's/\+/\ /g')" >> $LOG

			# Para arquivos de SpedFiscal
			Import_SpedFiscal

			# Para arquivos de Notas Fiscais
			Import_NotasFiscais

		done < $i >> $SCRIPT_SQL

		echo "$DATETIME - Executando a persistência dos dados. Por favor, aguarde..." >> $LOG

		# Importa no banco de dados o arquivo gerado {$SCRIPT_SQL}
		mysql --database=$DATABASE --user=$USERNAME --password=$PASSWORD < $SCRIPT_SQL

		# Depois de finalizado, renomeia o arquivo para não ser sobrescrito em um próximo processamento

		echo "$DATETIME - Informações salvas com sucesso!" >> $LOG
		echo "$DATETIME - Finalizando..."
		echo "$DATETIME - Movendo arquivo $i"

		mv $i $DIR_BACKUP/$(echo $i | cut -d '/' -f 8)

		echo "$DATETIME - Movendo Script [.SQL] para $DIR_BACKUP/$SQL_FILE.sql"

		mv logs/$SQL_FILE.sql $DIR_BACKUP/$SQL_FILE.sql

	done

else

	echo 'Não há arquivos para importar' >> $LOG

fi

#########################################################################
TIMEEND=$(echo "`date +%H%M%S`")				# Hora que o script finalizou
DATEEND=$(echo "`date +%d/%m/%Y`, às `date +%H:%M:%S`")	# Data/Hora que o script finalizou
# TIMETOTAL=$(echo $((TIMEEND - TIMESTART)))	# Calcula o tempo que o script passou para ser processado
#######################################################################

# Marca a data e hora que o script finalizou
echo "#######################################################################" >> $LOG
echo "# Data/Hora de início da execução: ${DATESTART}" >> $LOG
echo "# Data/Hora de término da execução: ${DATEEND}" >> $LOG
echo "# Empresa: $(echo $SPEDFISCAL | cut -d '|' -f 6 | sed 's/\+/\ /g')" >> $LOG
echo "# Período: $(echo $SPEDFISCAL | cut -d '|' -f 4) a $(echo $SPEDFISCAL | cut -d '|' -f 5)" >> $LOG
echo "#######################################################################" >> $LOG

echo "$DATETIME - Movendo arquivo de log para $DIR_BACKUP/imports.log"
mv $LOG $DIR_BACKUP/imports.log

echo "$DATETIME - Finalizado!!!"
exit_success
