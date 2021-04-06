#!/bin/bash

#########################################################################
source ../app/Console/DB.sh
#########################################################################

#########################################################################
# CREDENCIAIS PARA O BANCO DE DADOS
DATABASE=$1
USERNAME=$2
PASSWORD=$3
#########################################################################

#########################################################################
# Local de onde os registros vão ser processados
FILES=../storage/app/public/files/txt/notasfiscais/*.txt
#########################################################################

#########################################################################
# Arquivos para armazenamento dos logs
LOG=logs/imports.log
#########################################################################

exit_success() {
	exit 0
}

for i in `ls $FILES`
do

	> $LOG

	#########################################################################
	TIMESTART=$(echo "`date +%H%M%S`")							# Hora que o script iniciou
	DATESTART=$(echo "`date +%d/%m/%Y`, às `date +%H:%M:%S`")	# Data/Hora que o script iniciou
	#########################################################################

	#########################################################################
	# Nome do script .sql por arquivo
	SQL_FILE=notasfiscais # _$(echo "`date +%Y-%m-%d_%H%M%S`")

	# Local de destino do script .sql por arquivo
	SCRIPT_SQL=logs/$SQL_FILE.sql
	#########################################################################

	echo "Criando arquivo de script" >> $LOG
	> $SCRIPT_SQL
	echo "Arquivo $SCRIPT_SQL criado com sucesso!" >> $LOG

	echo "[ ... ] - Criando arquivo arquivo $SCRIPT_SQL" >> $LOG
	echo "[ OK ] - Arquivo $SQL_FILE criado com sucesso!" >> $LOG

	> $SCRIPT_SQL

	echo "[ ... ] - Salvando procedures..." >> $LOG
	Procedures >> $SCRIPT_SQL
	echo "[ OK ] - Procedures salvas com sucesso!" >> $LOG

	echo "#######################################################################"								>> $LOG
	echo "# Iniciando importação de Notas Fiscais	#" | expand -t 70											>> $LOG
	echo "# Arquivo: $(echo $i | cut -d '/' -f 8)	#" | expand -t 70											>> $LOG
	echo "# Data/Hora início da execução: ${DATESTART}	#" | expand -t 74										>> $LOG
	echo "# Empresa: $(head $i -n 1 | cut -d '|' -f 7 | sed 's/\+/\ /g')	#" | expand -t 70					>> $LOG
	echo "# Período: $(head $i -n 1 | cut -d '|' -f 5) a $(head $i -n 1 | cut -d '|' -f 6)	#" | expand -t 71	>> $LOG
	echo "#######################################################################" >> $LOG

	echo "[ ... ] - Criando arquivo arquivo $SCRIPT_SQL" >> $LOG
	echo "[ OK ] - Arquivo $SQL_FILE criado com sucesso!" >> $LOG

	CHAVE_REGISTRO=''

	while IFS= read -r REGISTRO || [[ -n "$REGISTRO" ]]
	do

		if [[ $(echo $REGISTRO | cut -d '|' -f 1) != 'Chave_de_acesso' ]]
		then

			# A
			CHV_NFE=$(echo $REGISTRO | cut -d '|' -f 1)

			if [[ $CHAVE_REGISTRO != $CHV_NFE ]]
			then

				echo "$REGISTRO" >> $LOG

				CHAVE_REGISTRO=$CHV_NFE

				# G
				IND_OPER=$(echo $REGISTRO | cut -d '|' -f 7)

				CNPJ_EMIT=$(echo $REGISTRO | cut -d '|' -f 11 | sed 's/[\.\/\-]//g')
				CNPJ_DEST=$(echo $REGISTRO | cut -d '|' -f 22 | sed 's/[\.\/\-]//g')

				IND_EMIT=$(echo $REGISTRO | cut -d '|' -f 3)
				# COD_PART=$(echo $REGISTRO | cut -d '|' -f 4)
				COD_MOD=$(echo $REGISTRO | cut -d '|' -f 5)

				# F
				COD_SIT=$(echo $REGISTRO | cut -d '|' -f 6)

				# C
				SER=$([[ $(echo $REGISTRO | cut -d '|' -f 3) != '' ]] && echo $REGISTRO | cut -d '|' -f 3 || echo 0 )

				# B
				NUM_DOC=$([[ $(echo $REGISTRO | cut -d '|' -f 2) != '' ]] && echo $REGISTRO | cut -d '|' -f 2 || echo 0 )

				data=$(echo $REGISTRO | cut -d '|' -f 4)		# D
				hora=$(echo $REGISTRO | cut -d '|' -f 5)		# E

				# D
				DT_DOC="$(echo $data | cut -d '/' -f 3)-$(echo $data | cut -d '/' -f 2)-$(echo $data | cut -d '/' -f 1) $(echo $hora)"

				data=$(echo $REGISTRO | cut -d '|' -f 4)
				DT_E_S="$(echo $data | cut -d '/' -f 3)-$(echo $data | cut -d '/' -f 2)-$(echo $data | cut -d '/' -f 1) $(echo $hora)"

				# H
				VL_DOC=$([[ $(echo $REGISTRO | cut -d '|' -f 8) != '' ]] && echo $REGISTRO | cut -d '|' -f 8 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
				VL_DESC=$([[ $(echo $REGISTRO | cut -d '|' -f 49) != '' ]] && echo $REGISTRO | cut -d '|' -f 49 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
				IND_FRT=$(echo $REGISTRO | cut -d '|' -f 41)
				VL_FRT=$([[ $(echo $REGISTRO | cut -d '|' -f 47) != '' ]] && echo $REGISTRO | cut -d '|' -f 47 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
				VL_SEG=$([[ $(echo $REGISTRO | cut -d '|' -f 48) != '' ]] && echo $REGISTRO | cut -d '|' -f 48 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
				VL_OUT_DA=$([[ $(echo $REGISTRO | cut -d '|' -f 20) != '' ]] && echo $REGISTRO | cut -d '|' -f 20 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
				VL_BC_ICMS=$([[ $(echo $REGISTRO | cut -d '|' -f 41) != '' ]] && echo $REGISTRO | cut -d '|' -f 41 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
				VL_ICMS=$([[ $(echo $REGISTRO | cut -d '|' -f 42) != '' ]] && echo $REGISTRO | cut -d '|' -f 42 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
				VL_BC_ICMS_ST=$([[ $(echo $REGISTRO | cut -d '|' -f 43) != '' ]] && echo $REGISTRO | cut -d '|' -f 43 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
				VL_ICMS_ST=$([[ $(echo $REGISTRO | cut -d '|' -f 44) != '' ]] && echo $REGISTRO | cut -d '|' -f 44 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
				VL_IPI=$([[ $(echo $REGISTRO | cut -d '|' -f 50) != '' ]] && echo $REGISTRO | cut -d '|' -f 50 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )

				echo "SET @id='$CHV_NFE';"
				echo "SET @versao='0';"
				echo "SET @versao2='0';"
				echo "SET @cUF='0';"
				echo "SET @cNF='$NUM_DOC';"
				echo "SET @natOp='$IND_OPER';"
				echo "SET @mod='0';"
				echo "SET @serie='$SER';"
				echo "SET @nNF='$NUM_DOC';"
				echo "SET @dhEmi='$DT_DOC';"
				echo "SET @dhSaiEnt='$DT_E_S';"
				echo "SET @tpNf='0';"
				echo "SET @idDest='0';"
				echo "SET @cMunFG='0';"
				echo "SET @tpImp='0';"
				echo "SET @tpEmis='0';"
				echo "SET @cDV='0';"
				echo "SET @cEmi='$CNPJ_EMIT';"
				echo "SET @cDest='$CNPJ_DEST';"
				echo "SET @tpAmb='0';"
				echo "SET @chNFe='$CHV_NFE';"
				echo "SET @dhRecbto='0';"
				echo "SET @nProt='0';"
				echo "SET @digVal='0';"
				echo "SET @cStat='0';"
				echo "SET @xMotivo='0';"
				echo "SET @vBC='$VL_BC_ICMS';"
				echo "SET @vICMS='$VL_ICMS';"
				echo "SET @vICMSDeson='0';"
				echo "SET @vFCP='0';"
				echo "SET @vBCST='$VL_BC_ICMS_ST';"
				echo "SET @vST='$VL_ICMS_ST';"
				echo "SET @vFCPST='0';"
				echo "SET @vFCPSTRet='0';"
				echo "SET @vProd='0';"
				echo "SET @vFrete='$VL_FRT';"
				echo "SET @vSeg='$VL_SEG';"
				echo "SET @vDesc='0';"
				echo "SET @vII='0';"
				echo "SET @vIPI='0';"
				echo "SET @vIPIDevol='0';"
				echo "SET @vPIS='0';"
				echo "SET @vCOFINS='0';"
				echo "SET @vOutro='0';"
				echo "SET @vNF='$VL_DOC';"
				echo "SET @vTotTrib='0';"
				echo "SET @modFrete='$IND_FRT';"
				echo "SET @cTransportadora='0';"
				echo "SET @veicTranspPlaca='0';"
				echo "SET @veicTranspUF='0';"
				echo "SET @qVol='0';"
				echo "SET @nVol='0';"
				echo "SET @pesoL='0';"
				echo "SET @pesoB='0';"
				echo "SET @nFat='0';"
				echo "SET @vOrig='0';"
				echo "SET @vDescFat='$VL_DESC';"
				echo "SET @vLiq='0';"
				echo "SET @indPag='0';"
				echo "SET @tPag='0';"
				echo "SET @vPag='0';"
				echo "SET @xml_file='0';"

				echo "CALL Cadastra_NotaFiscal(@id, @versao, @versao2, @cUF, @cNF, @natOp, @mod, @serie, @nNF, @dhEmi, @dhSaiEnt, @tpNf, @idDest, @cMunFG, @tpImp, @tpEmis, @cDV, @cEmi, @cDest, @tpAmb, @chNFe, @dhRecbto, @nProt, @digVal, @cStat, @xMotivo, @vBC, @vICMS, @vICMSDeson, @vFCP, @vBCST, @vST, @vFCPST, @vFCPSTRet, @vProd, @vFrete, @vSeg, @vDesc, @vII, @vIPI, @vIPIDevol, @vPIS, @vCOFINS, @vOutro, @vNF, @vTotTrib, @modFrete, @cTransportadora, @veicTranspPlaca, @veicTranspUF, @qVol, @nVol, @pesoL, @pesoB, @nFat, @vOrig, @vDescFat, @vLiq, @indPag, @tPag, @vPag, @xml_file);"

			fi

		fi

	done < $i >> $SCRIPT_SQL

	echo "Executando a persistência dos dados..." >> $LOG

	# Importa no banco de dados o arquivo gerado {$SCRIPT_SQL}
	mysql --database=$DATABASE --user=$USERNAME --password=$PASSWORD < $SCRIPT_SQL

	echo "Informações salvas com sucesso!"

	#########################################################################
	TIMEEND=$(echo "`date +%H%M%S`")				# Hora que o script finalizou
	DATEEND=$(echo "`date +%d/%m/%Y`, às `date +%H:%M:%S`")	# Data/Hora que o script finalizou
	# TIMETOTAL=$(echo $((TIMEEND - TIMESTART)))	# Calcula o tempo que o script passou para ser processado
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
	# mv $LOG $SQL_FILE # $LOG_BACKUP

	# Destino do arquivo de log
	DIR_BACKUP=../storage/logs/imports/_$(echo "`date +%Y-%m-%d_%H%M%S`")
	mkdir $DIR_BACKUP

	mv $i $DIR_BACKUP/$(echo $i | cut -d '/' -f 8)
	mv $LOG $DIR_BACKUP/imports.log
	mv logs/$SQL_FILE.sql $DIR_BACKUP/$SQL_FILE.sql

done

exit_success