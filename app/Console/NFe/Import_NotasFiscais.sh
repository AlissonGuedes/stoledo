#!/bin/bash

function Import_NotasFiscais() {

	NOTA_FISCAL=$ARQUIVO

	CHV_NFE=$(echo $NOTA_FISCAL | cut -d '|' -f 1)

	if [[ ${#CHV_NFE} == 44 ]] && [[ $CHAVE_REGISTRO != $CHV_NFE ]]
	then

		CNPJ_EMIT=''
		RAZAO_SOCIAL_EMIT=''
		NOME_EMIT=''
		PAIS_EMIT=''
		COD_MUNICIPIO_EMIT=''
		UF_EMIT=''
		BAIRRO_EMIT=''
		RUA_EMIT=''
		CEP_EMIT=''
		NUM_EMIT=''
		COMPL_EMIT=''
		FONE_FAX_EMIT=''
		FAX_EMIT=''
		EMAIL_EMIT=''
		IE_DEST_EMIT=''
		INDIEDEST_EMIT=''
		CRT_EMIT=''
		CPF_EMIT=''
		IM_EMIT=''
		SUFRAMA_EMIT=''
		IND_ATIV_EMIT=''


		CNPJ_DEST=''
		RAZAO_SOCIAL_DEST=''
		NOME=''
		PAIS_DEST=''
		COD_MUNICIPIO_DEST=''
		UF_DEST=''
		BAIRRO_DEST=''
		RUA_DEST=''
		CEP_DEST=''
		NUM=''
		COMPL=''
		FONE_FAX_DEST=''
		FAX=''
		EMAIL=''
		IE_DEST=''
		INDIEDEST=''
		CRT=''
		CPF=''
		IM=''
		SUFRAMA=''
		IND_ATIV=''

		data=$(echo $NOTA_FISCAL | cut -d '|' -f 4)		# D
		hora=$(echo $NOTA_FISCAL | cut -d '|' -f 5)		# E

		CHAVE_REGISTRO=$CHV_NFE

		IND_OPER=$(echo $NOTA_FISCAL | cut -d '|' -f 7)

		# Dados do emitente
		RAZAO_SOCIAL_EMIT=$(echo $NOTA_FISCAL | cut -d '|' -f 10 | sed 's/\+/\ /g')
		CNPJ_EMIT=$(echo $NOTA_FISCAL | cut -d '|' -f 11 | sed 's/[\.\/\-]//g')
		IE_EMIT=$(echo $NOTA_FISCAL | cut -d '|' -f 12)
		RUA_EMIT=$(echo $NOTA_FISCAL | cut -d '|' -f 13 | sed 's/\+/\ /g')
		BAIRRO_EMIT=$(echo $NOTA_FISCAL | cut -d '|' -f 14 | sed 's/\+/\ /g')
		CEP_EMIT=$(echo $NOTA_FISCAL | cut -d '|' -f 15)
		MUNICIPIO_EMIT=$(echo $NOTA_FISCAL | cut -d '|' -f 16 | sed 's/\+/\ /g')
		COD_MUNICIPIO_EMIT=$(echo $NOTA_FISCAL | cut -d '|' -f 17)
		FONE_FAX_EMIT=$(echo $NOTA_FISCAL | cut -d '|' -f 18)
		UF_EMIT=$(echo $NOTA_FISCAL | cut -d '|' -f 19)
		PAIS_EMIT=$(echo $NOTA_FISCAL | cut -d '|' -f 20)

		# Dados do destinatário
		RAZAO_SOCIAL_DEST=$(echo $NOTA_FISCAL | cut -d '|' -f 21 | sed 's/\+/\ /g')
		CNPJ_DEST=$(echo $NOTA_FISCAL | cut -d '|' -f 22 | sed 's/[\.\/\-]//g')
		IE_DEST=$(echo $NOTA_FISCAL | cut -d '|' -f 23)
		RUA_DEST=$(echo $NOTA_FISCAL | cut -d '|' -f 24 | sed 's/\+/\ /g')
		BAIRRO_DEST=$(echo $NOTA_FISCAL | cut -d '|' -f 25 | sed 's/\+/\ /g')
		CEP_DEST=$(echo $NOTA_FISCAL | cut -d '|' -f 26)
		MUNICIPIO_DEST=$(echo $NOTA_FISCAL | cut -d '|' -f 27 | sed 's/\+/\ /g')
		COD_MUNICIPIO_DEST=$(echo $NOTA_FISCAL | cut -d '|' -f 28)
		FONE_FAX_DEST=$(echo $NOTA_FISCAL | cut -d '|' -f 29)
		UF_DEST=$(echo $NOTA_FISCAL | cut -d '|' -f 30)
		PAIS_DEST=$(echo $NOTA_FISCAL | cut -d '|' -f 31)






MUNICIPIO_DEST
COD_MUNICIPIO_DEST
FONE_FAX_DEST
UF_DEST
PAIS_DEST

		echo "SET @cnpj='$CNPJ_DEST';" ''
		echo "SET @nome='$RAZAO_SOCIAL_DEST';" ''
		echo "SET @xFant='$NOME';" ''
		echo "SET @cPais='$PAIS_DEST';" ''
		echo "SET @cMun='$COD_MUNICIPIO_DEST';" ''
		echo "SET @uf='$UF_DEST';" ''
		echo "SET @xBairro='$BAIRRO_DEST';"
		echo "SET @xLgr='$RUA_DEST';"
		echo "SET @cep='$CEP_DEST';"
		echo "SET @nro='$NUM';"
		echo "SET @complemento='$COMPL';"
		echo "SET @fone='$FONE_FAX_DEST';"
		echo "SET @fax='$FAX';"
		echo "SET @email='$EMAIL';"
		echo "SET @ie='$IE_DEST';"
		echo "SET @indIEDest='$INDIEDEST';"
		echo "SET @crt='$CRT';"
		echo "SET @cpf='$CPF';"
		echo "SET @im='$IM';"
		echo "SET @suframa='$SUFRAMA';"
		echo "SET @ind_ati='$IND_ATIV';"

		echo "CALL Cadastra_Fornecedor(@cnpj, @nome, @xFant, @cPais, @cMun, @uf, @xBairro, @xLgr, @cep, @nro, @complemento, @fone, @fax, @email, @ie, @indIEDest, @crt, @cpf, @im, @suframa, @ind_ati);"

		IND_EMIT=$(echo $NOTA_FISCAL | cut -d '|' -f 3)
		# COD_PART=$(echo $NOTA_FISCAL | cut -d '|' -f 4)
		COD_MOD=$(echo $NOTA_FISCAL | cut -d '|' -f 5)
		COD_SIT=$(echo $NOTA_FISCAL | cut -d '|' -f 6)
		SER=$([[ $(echo $NOTA_FISCAL | cut -d '|' -f 3) != '' ]] && echo $NOTA_FISCAL | cut -d '|' -f 3 || echo 0 )
		NUM_DOC=$([[ $(echo $NOTA_FISCAL | cut -d '|' -f 2) != '' ]] && echo $NOTA_FISCAL | cut -d '|' -f 2 || echo 0 )
		DT_DOC="$(echo $data | cut -d '/' -f 3)-$(echo $data | cut -d '/' -f 2)-$(echo $data | cut -d '/' -f 1) $(echo $hora)"
		DT_E_S="$(echo $data | cut -d '/' -f 3)-$(echo $data | cut -d '/' -f 2)-$(echo $data | cut -d '/' -f 1) $(echo $hora)"
		VL_DOC=$([[ $(echo $NOTA_FISCAL | cut -d '|' -f 8) != '' ]] && echo $NOTA_FISCAL | cut -d '|' -f 8 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
		VL_DESC=$([[ $(echo $NOTA_FISCAL | cut -d '|' -f 49) != '' ]] && echo $NOTA_FISCAL | cut -d '|' -f 49 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
		IND_FRT=$([[ $(echo $NOTA_FISCAL | cut -d '|' -f 41) != '' ]] && echo $NOTA_FISCAL | cut -d '|' -f 41 || echo 0 )
		VL_FRT=$([[ $(echo $NOTA_FISCAL | cut -d '|' -f 47) != '' ]] && echo $NOTA_FISCAL | cut -d '|' -f 47 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
		VL_SEG=$([[ $(echo $NOTA_FISCAL | cut -d '|' -f 48) != '' ]] && echo $NOTA_FISCAL | cut -d '|' -f 48 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
		VL_OUT_DA=$([[ $(echo $NOTA_FISCAL | cut -d '|' -f 20) != '' ]] && echo $NOTA_FISCAL | cut -d '|' -f 20 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
		VL_BC_ICMS=$([[ $(echo $NOTA_FISCAL | cut -d '|' -f 41) != '' ]] && echo $NOTA_FISCAL | cut -d '|' -f 41 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
		VL_ICMS=$([[ $(echo $NOTA_FISCAL | cut -d '|' -f 42) != '' ]] && echo $NOTA_FISCAL | cut -d '|' -f 42 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
		VL_BC_ICMS_ST=$([[ $(echo $NOTA_FISCAL | cut -d '|' -f 43) != '' ]] && echo $NOTA_FISCAL | cut -d '|' -f 43 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
		VL_ICMS_ST=$([[ $(echo $NOTA_FISCAL | cut -d '|' -f 44) != '' ]] && echo $NOTA_FISCAL | cut -d '|' -f 44 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )
		VL_IPI=$([[ $(echo $NOTA_FISCAL | cut -d '|' -f 50) != '' ]] && echo $NOTA_FISCAL | cut -d '|' -f 50 | sed 's/\.//g' | sed 's/\,/\./g' || echo 0.00 )

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

	# done < $1 >> $SCRIPT_SQL

}