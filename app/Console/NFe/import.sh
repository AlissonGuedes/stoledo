#!/bin/bash

#########################################################################
# CREDENCIAIS PARA O BANCO DE DADOS
DATABASE=$1
USERNAME=$2
PASSWORD=$3
#########################################################################

#########################################################################
TIMESTART=$(echo "`date +%H%M%S`")							# Hora que o script iniciou
DATESTART=$(echo "`date +%d/%m/%Y`, às `date +%H:%M:%S`")	# Data/Hora que o script iniciou
LOG=$4
LOG_BACKUP=$5
FILE=../storage/app/public/files/txt/notasfiscais/*.txt
#########################################################################

echo 'DELIMITER $$;' > $LOG

# Cadastra notas na tabela `tb_nfe`
function Cadastra_NotaFiscal() {

	echo 'CREATE OR REPLACE PROCEDURE Cadastra_NotaFiscal(
		IN N_id VARCHAR(50) CHARSET utf8,
		IN N_versao INT(11),
		IN N_versao2 INT(11),
		IN N_cUF INT(11),
		IN N_cNF INT(11),
		IN N_natOp VARCHAR(11) CHARSET utf8,
		IN N_mod INT(11),
		IN N_serie INT(11),
		IN N_nNF INT(11),
		IN N_dhEmi TIMESTAMP,
		IN N_dhSaiEnt TIMESTAMP,
		IN N_tpNf INT(11),
		IN N_idDest INT(11),
		IN N_cMunFG INT(11),
		IN N_tpImp INT(11),
		IN N_tpEmis INT(11),
		IN N_cDV INT(11),
		IN N_cEmi VARCHAR(17) CHARSET utf8,
		IN N_cDest VARCHAR(17) CHARSET utf8,
		IN N_tpAmb INT(11),
		IN N_chNFe CHAR(44) CHARSET utf8,
		IN N_dhRecbto DECIMAL(11, 2),
		IN N_nProt VARCHAR(11) CHARSET utf8,
		IN N_digVal VARCHAR(11) CHARSET utf8,
		IN N_cStat SMALLINT(4),
		IN N_xMotivo VARCHAR(11) CHARSET utf8,
		IN N_vBC DECIMAL(10, 4),
		IN N_vICMS DECIMAL(10, 4),
		IN N_vICMSDeson DECIMAL(10, 4),
		IN N_vFCP DECIMAL(10, 4),
		IN N_vBCST DECIMAL(10, 4),
		IN N_vST DECIMAL(10, 4),
		IN N_vFCPST DECIMAL(10, 4),
		IN N_vFCPSTRet DECIMAL(10, 4),
		IN N_vProd DECIMAL(10, 4),
		IN N_vFrete DECIMAL(10, 4),
		IN N_vSeg DECIMAL(10, 4),
		IN N_vDesc DECIMAL(10, 4),
		IN N_vII DECIMAL(10, 4),
		IN N_vIPI DECIMAL(10, 4),
		IN N_vIPIDevol DECIMAL(10, 4),
		IN N_vPIS DECIMAL(10, 4),
		IN N_vCOFINS DECIMAL(10, 4),
		IN N_vOutro DECIMAL(10, 4),
		IN N_vNF DECIMAL(10, 4),
		IN N_vTotTrib DECIMAL(10, 4),
		IN N_modFrete INT(11),
		IN N_cTransportadora VARCHAR(11) CHARSET utf8,
		IN N_veicTranspPlaca VARCHAR(11) CHARSET utf8,
		IN N_veicTranspUF VARCHAR(11) CHARSET utf8,
		IN N_qVol DECIMAL(10, 3),
		IN N_nVol VARCHAR(11) CHARSET utf8,
		IN N_pesoL DECIMAL(10, 3),
		IN N_pesoB DECIMAL(10, 3),
		IN N_nFat VARCHAR(11) CHARSET utf8,
		IN N_vOrig DECIMAL(10, 2),
		IN N_vDescFat DECIMAL(10, 2),
		IN N_vLiq DECIMAL(10, 2),
		IN N_indPag INT(11),
		IN N_tPag INT(2),
		IN N_vPag DECIMAL(10, 2),
		IN N_xml_file VARCHAR(11) CHARSET utf8
	)
	BEGIN

		SET @nf=(SELECT COUNT(id) FROM tb_nfe WHERE chNFe = N_chNFe);

		IF @nf = 0
		THEN

			INSERT INTO tb_nfe (`id`, `versao`, `versao2`, `cUF`, `cNF`, `natOp`, `mod`, `serie`, `nNF`, `dhEmi`, `dhSaiEnt`, `tpNf`, `idDest`, `cMunFG`, `tpImp`, `tpEmis`, `cDV`, `cEmi`, `cDest`, `tpAmb`, `chNFe`, `dhRecbto`, `nProt`, `digVal`, `cStat`, `xMotivo`, `vBC`, `vICMS`, `vICMSDeson`, `vFCP`, `vBCST`, `vST`, `vFCPST`, `vFCPSTRet`, `vProd`, `vFrete`, `vSeg`, `vDesc`, `vII`, `vIPI`, `vIPIDevol`, `vPIS`, `vCOFINS`, `vOutro`, `vNF`, `vTotTrib`, `modFrete`, `cTransportadora`, `veicTranspPlaca`, `veicTranspUF`, `qVol`, `nVol`, `pesoL`, `pesoB`, `nFat`, `vOrig`, `vDescFat`, `vLiq`, `indPag`, `tPag`, `vPag`, `xml_file`) VALUES (N_id, N_versao, N_versao2, N_cUF, N_cNF, N_natOp, N_mod, N_serie, N_nNF, N_dhEmi, N_dhSaiEnt, N_tpNf, N_idDest, N_cMunFG, N_tpImp, N_tpEmis, N_cDV, N_cEmi, N_cDest, N_tpAmb, N_chNFe, N_dhRecbto, N_nProt, N_digVal, N_cStat, N_xMotivo, N_vBC, N_vICMS, N_vICMSDeson, N_vFCP, N_vBCST, N_vST, N_vFCPST, N_vFCPSTRet, N_vProd, N_vFrete, N_vSeg, N_vDesc, N_vII, N_vIPI, N_vIPIDevol, N_vPIS, N_vCOFINS, N_vOutro, N_vNF, N_vTotTrib, N_modFrete, N_cTransportadora, N_veicTranspPlaca, N_veicTranspUF, N_qVol, N_nVol, N_pesoL, N_pesoB, N_nFat, N_vOrig, N_vDescFat, N_vLiq, N_indPag, N_tPag, N_vPag, N_xml_file);

		END IF;

	END $$;
	'

}

echo -e $(Cadastra_NotaFiscal) >> $LOG
echo 'DELIMITER ;' >> $LOG

for i in `ls $FILE`
do

	echo -e "-- #######################################################################"
	echo -e "-- # Importação Notas Fiscais	#" | expand -t 72
	echo -e "-- # Arquivo: $i	#" | expand -t 70
	echo -e "-- # Data/Hora início da execução: ${DATESTART}	#" | expand -t 74
	echo -e "-- #######################################################################"

	CHAVE_REGISTRO=''

	while IFS= read REGISTRO || [[ -n "$REGISTRO" ]]
	do

		if [[ $(echo $REGISTRO | cut -d '|' -f 1) != 'Chave_de_acesso' ]]
		then

			# A
			CHV_NFE=$(echo $REGISTRO | cut -d '|' -f 1)

			if [[ $CHAVE_REGISTRO != $CHV_NFE ]]
			then

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
				SER=$(echo $REGISTRO | cut -d '|' -f 3)

				# B
				NUM_DOC=$(echo $REGISTRO | cut -d '|' -f 2)

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

	done < $i

done >> $LOG

# Importa no banco de dados o arquivo gerado {$LOG}
mysql --database=$DATABASE --user=$USERNAME --password=$PASSWORD < $LOG

# Depois de finalizado, renomeia o arquivo para não ser sobrescrito em um próximo processamento
mv $LOG $LOG_BACKUP