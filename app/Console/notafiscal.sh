#!/bin/bash

#########################################################################
# Função para obter informações da Nota fiscal		[[ REGISTRO C100 ]] #
#########################################################################
function Notafiscal() {

	NF=$1

	REG=$(echo $NF | cut -d '|' -f 1)
	IND_OPER=$(echo $NF | cut -d '|' -f 2)
	IND_EMIT=$(echo $NF | cut -d '|' -f 3)
	COD_PART=$(echo $NF | cut -d '|' -f 4)
	COD_MOD=$(echo $NF | cut -d '|' -f 5)
	COD_SIT=$(echo $NF | cut -d '|' -f 6)
	SER=$(echo $NF | cut -d '|' -f 7)
	NUM_DOC=$(echo $NF | cut -d '|' -f 8)
	CHV_NFE=$(echo $NF | cut -d '|' -f 9)
	DT_DOC=$([[ $(echo $NF | cut -d '|' -f 10) != '' ]] && echo $NF | cut -d '|' -f 10 || echo 0 )
	DT_E_S=$([[ $(echo $NF | cut -d '|' -f 11) != '' ]] && echo $NF | cut -d '|' -f 11 || echo 0 )
	VL_DOC=$([[ $(echo $NF | cut -d '|' -f 12) != '' ]] && echo $NF | cut -d '|' -f 12 | sed 's/\,/\./g' || echo 0.00 )
	IND_PGTO=$(echo $NF | cut -d '|' -f 13)
	VL_DESC=$([[ $(echo $NF | cut -d '|' -f 14) != '' ]] && echo $NF | cut -d '|' -f 14 | sed 's/\,/\./g' || echo 0.00 )
	VL_ABAT_NT=$([[ $(echo $NF | cut -d '|' -f 15) != '' ]] && echo $NF | cut -d '|' -f 15 | sed 's/\,/\./g' || echo 0.00 )
	IND_FRT=$(echo $NF | cut -d '|' -f 17)
	VL_FRT=$([[ $(echo $NF | cut -d '|' -f 18 | sed 's/\,/\./g') != '' ]] && echo $NF | cut -d '|' -f 18 | sed 's/\,/\./g' || echo 0.00 )
	VL_SEG=$([[ $(echo $NF | cut -d '|' -f 19) != '' ]] && echo $NF | cut -d '|' -f 19 | sed 's/\,/\./g' || echo 0.00 )
	VL_OUT_DA=$([[ $(echo $NF | cut -d '|' -f 20) != '' ]] && echo $NF | cut -d '|' -f 20 | sed 's/\,/\./g' || echo 0.00 )
	VL_BC_ICMS=$([[ $(echo $NF | cut -d '|' -f 21) != '' ]] && echo $NF | cut -d '|' -f 21 | sed 's/\,/\./g' || echo 0.00 )
	VL_ICMS=$([[ $(echo $NF | cut -d '|' -f 22) != '' ]] && echo $NF | cut -d '|' -f 22 | sed 's/\,/\./g' || echo 0.00 )
	VL_BC_ICMS_ST=$([[ $(echo $NF | cut -d '|' -f 23) != '' ]] && echo $NF | cut -d '|' -f 23 | sed 's/\,/\./g' || echo 0.00 )
	VL_ICMS_ST=$([[ $(echo $NF | cut -d '|' -f 24) != '' ]] && echo $NF | cut -d '|' -f 24 | sed 's/\,/\./g' || echo 0.00 )
	VL_IPI=$([[ $(echo $NF | cut -d '|' -f 25) != '' ]] && echo $NF | cut -d '|' -f 25 | sed 's/\,/\./g' || echo 0.00 )
	VL_PIS=$([[ $(echo $NF | cut -d '|' -f 26) != '' ]] && echo echo $NF | cut -d '|' -f 26 | sed 's/\,/\./g' || echo 0.00 )
	VL_COFINS=$([[ $(echo $NF | cut -d '|' -f 27) != '' ]] && echo $NF | cut -d '|' -f 27 | sed 's/\,/\./g' || echo 0.00 )
	VL_PIS_ST=$([[ $(echo  $NF | cut -d '|' -f 28) != '' ]] && echo $NF | cut -d '|' -f 28 | sed 's/\,/\./g' || echo 0.00 )
	VL_COFINS_ST=$([[ $(echo $NF | cut -d '|' -f 29) != '' ]] && echo $NF | cut -d '|' -f 29 | sed 's/\,/\./g' || echo 0.00 )

	echo "SET @indOper='$IND_OPER';"
	echo "SET @indEmit='$IND_EMIT';"
	echo "SET @codPart='$COD_PART';"
	echo "SET @codMod='$COD_MOD';"
	echo "SET @codSit='$COD_SIT';"
	echo "SET @serie='$SER';"
	echo "SET @numDoc='$NUM_DOC';"
	echo "SET @chvNFe='$CHV_NFE';"
	echo "SET @dtDoc='$DT_DOC';"
	echo "SET @dtES='$DT_E_S';"
	echo "SET @vlDoc='$VL_DOC';"
	echo "SET @indPag='$IND_PGTO';"
	echo "SET @vlDesc='$VL_DESC';"
	echo "SET @vlAbatNt='$VL_ABAT_NT';"
	echo "SET @indFrt='$IND_FRT';"
	echo "SET @vlFrt='$VL_FRT';"
	echo "SET @vlSeg='$VL_SEG';"
	echo "SET @vlOutDa='$VL_OUT_DA';"
	echo "SET @vlBcICMS='$VL_BC_ICMS';"
	echo "SET @vlICMS='$VL_ICMS';"
	echo "SET @vlBcIcmsSt='$VL_BC_ICMS_ST';"
	echo "SET @vlIcmsSt='$VL_ICMS_ST';"
	echo "SET @vlIpi='$VL_IPI';"
	echo "SET @vlPis='$VL_PIS';"
	echo "SET @vlCofins='$VL_COFINS';"
	echo "SET @vlPisSt='$VL_PIS_ST';"
	echo "SET @vlCofinsSt='$VL_COFINS_ST';"
	echo "CALL Cadastra_NFe(@indOper, @indEmit, @codPart, @codMod, @codSit, @serie, @numDoc, @chvNFe, @dtDoc, @dtES, @vlDoc, @indPag, @vlDesc, @vlAbatNt, @indFrt, @vlFrt, @vlSeg, @vlOutDa, @vlBcICMS, @vlICMS, @vlBcIcmsSt, @vlIcmsSt, @vlIpi, @vlPis, @vlCofins, @vlPisSt, @vlCofinsSt );"
	# query="SELECT id FROM tb_spedfiscal_nfe WHERE num_doc = '$NUM_DOC' AND chv_nfe = '$CHV_NFE';";

	# result=$(Execute "$query")

	# if [[ $result == '' ]]
	# then

	# 	query="INSERT INTO tb_spedfiscal_nfe (id_sped, ind_oper, ind_emit, cod_part, cod_mod, cod_sit, ser, num_doc, chv_nfe, dt_doc, dt_e_s, vl_doc, ind_pgto, vl_desc, vl_abat_nt, ind_frt, vl_frt, vl_seg, vl_out_dia, vl_bc_icms, vl_icms, vl_bc_icms_st, vl_icms_cst, vl_ipi, vl_pis, vl_cofins, vl_pis_st, vl_cofins_st) VALUES ('$SPEDFISCAL', '$IND_OPER', '$IND_EMIT', '$COD_PART', '$COD_MOD', '$COD_SIT', '$SER', '$NUM_DOC', '$CHV_NFE', '$DT_DOC', '$DT_E_S', '$VL_DOC', '$IND_PGTO', '$VL_DESC', '$VL_ABAT_NT', '$IND_FRT', '$VL_FRT', '$VL_SEG', '$VL_OUT_DA', '$VL_BC_ICMS', '$VL_ICMS', '$VL_BC_ICMS_ST','$VL_ICMS_ST', '$VL_IPI', '$VL_PIS', '$VL_COFINS', '$VL_PIS_ST','$VL_COFINS_ST');"

	# 	result=$(Execute "$query select last_insert_id();")

	# fi

	# echo $result | awk '{print $2}'

}

###################################################################
# Cadastro de Informações Complementares      [[ REGISTRO 0450 ]] #
###################################################################
function Notafiscal_InformacaoComplementar() {

	INFO=$1

	REG=$(echo $INFO | cut -d '|' -f 1)
	COD_INF=$(echo $INFO | cut -d '|' -f 2)
	TEXTO=$(echo $INFO | cut -d '|' -f 3 | sed 's/\+/\ /g')

	echo "SET @codInf='$COD_INF';"
	echo "SET @textInfo='$TEXTO';"
	echo "CALL Cadastra_NFe_InformacaoComplementar(@codInf, @textInfo);"

}


###################################################################
# Cadastro de Itens da Nota Fiscal            [[ REGISTRO 0450 ]] #
###################################################################
function Notafiscal_Itens() {

	ITEM=$1

	REG=$(echo $ITEM | cut -d '|' -f 1)
	COD_ITEM=$(echo $ITEM | cut -d '|' -f 3)
	DESCR_ITEM=$(echo $ITEM | cut -d '|' -f 4 | sed 's/\+/\ /g')

	num_item=$([[ $(echo $ITEM | cut -d '|' -f 2) != '' ]] && echo $ITEM | cut -d '|' -f 2 || echo 0 )
	qtd=$([[ $(echo $ITEM | cut -d '|' -f 5) != '' ]] && echo $ITEM | cut -d '|' -f 5 | sed 's/\,/\./g' || echo 0.00 )
	unid=$(echo $ITEM | cut -d '|' -f 6)
	vl_item=$([[ $(echo $ITEM | cut -d '|' -f 7) != '' ]] && echo $ITEM | cut -d '|' -f 7 | sed 's/\,/\./g' || echo 0.00 )
	vl_desc=$([[ $(echo $ITEM | cut -d '|' -f 8) != '' ]] && echo $ITEM | cut -d '|' -f 8 | sed 's/\,/\./g' || echo 0.00 )
	ind_mov=$(echo $ITEM | cut -d '|' -f 9)
	cst_icms=$([[ $(echo $ITEM | cut -d '|' -f 10) != '' ]] && echo $ITEM | cut -d '|' -f 10 || echo 0 )
	cfop=$([[ $(echo $ITEM | cut -d '|' -f 11) != '' ]] && echo $ITEM | cut -d '|' -f 11 || echo 0 )
	cod_nat=$(echo $ITEM | cut -d '|' -f 12)
	vl_bc_icms=$([[ $(echo $ITEM | cut -d '|' -f 13) != '' ]] && echo $ITEM | cut -d '|' -f 13 | sed 's/\,/\./g' || echo 0.00 )
	aliq_icms=$([[ $(echo $ITEM | cut -d '|' -f 14) != '' ]] && echo $ITEM | cut -d '|' -f 14 | sed 's/\,/\./g' || echo 0.00 )
	vl_icms=$([[ $(echo $ITEM | cut -d '|' -f 15) != '' ]] && echo $ITEM | cut -d '|' -f 15 | sed 's/\,/\./g' || echo 0.00 )
	vl_bc_icms_st=$([[ $(echo $ITEM | cut -d '|' -f 16) != '' ]] && echo $ITEM | cut -d '|' -f 16 | sed 's/\,/\./g' || echo 0.00 )
	aliq_st=$([[ $(echo $ITEM | cut -d '|' -f 17) != '' ]] && echo $ITEM | cut -d '|' -f 17 | sed 's/\,/\./g' || echo 0.00 )
	vl_icms_st=$([[ $(echo $ITEM | cut -d '|' -f 18) != '' ]] && echo $ITEM | cut -d '|' -f 18 | sed 's/\,/\./g' || echo 0.00 )
	ind_apur=$(echo $ITEM | cut -d '|' -f 19)
	cst_ipi=$(echo $ITEM | cut -d '|' -f 20)
	cod_enq=$(echo $ITEM | cut -d '|' -f 21)
	vl_bc_ipi=$([[ $(echo $ITEM | cut -d '|' -f 22) != '' ]] && echo $ITEM | cut -d '|' -f 22 | sed 's/\,/\./g' || echo 0.00 )
	aliq_ipi=$([[ $(echo $ITEM | cut -d '|' -f 23) != '' ]] && echo $ITEM | cut -d '|' -f 23 | sed 's/\,/\./g' || echo 0.00 )
	vl_ipi=$([[ $(echo $ITEM | cut -d '|' -f 24) != '' ]] && echo $ITEM | cut -d '|' -f 24 | sed 's/\,/\./g' || echo 0.00 )
	cst_pis=$([[ $(echo $ITEM | cut -d '|' -f 25) != '' ]] && echo $ITEM | cut -d '|' -f 25 || echo 0 )
	vl_bc_pis=$([[ $(echo $ITEM | cut -d '|' -f 26) != '' ]] && echo $ITEM | cut -d '|' -f 26 | sed 's/\,/\./g' || echo 0.00 )
	aliq_pis_percent=$([[ $(echo $ITEM | cut -d '|' -f 27) != '' ]] && echo $ITEM | cut -d '|' -f 27 | sed 's/\,/\./g' || echo 0.00 )
	quant_bc_pis=$([[ $(echo $ITEM | cut -d '|' -f 28) != '' ]] && echo $ITEM | cut -d '|' -f 28 | sed 's/\,/\./g' || echo 0.00 )
	aliq_pis_real=$([[ $(echo $ITEM | cut -d '|' -f 29) != '' ]] && echo $ITEM | cut -d '|' -f 29 | sed 's/\,/\./g' || echo 0.00 )
	vl_pis=$([[ $(echo $ITEM | cut -d '|' -f 30) != '' ]] && echo $ITEM | cut -d '|' -f 30 | sed 's/\,/\./g' || echo 0.00 )
	cst_cofins=$([[ $(echo $ITEM | cut -d '|' -f 31) != '' ]] && echo $ITEM | cut -d '|' -f 31 | sed 's/\,/\./g' || echo 0.00 )
	vl_bc_cofins=$([[ $(echo $ITEM | cut -d '|' -f 32) != '' ]] && echo $ITEM | cut -d '|' -f 32 | sed 's/\,/\./g' || echo 0.00 )
	aliq_cofins_percent=$([[ $(echo $ITEM | cut -d '|' -f 33) != '' ]] && echo $ITEM | cut -d '|' -f 33 | sed 's/\,/\./g' || echo 0.00 )
	quant_bc_cofins=$([[ $(echo $ITEM | cut -d '|' -f 34) != '' ]] && echo $ITEM | cut -d '|' -f 34 | sed 's/\,/\./g' || echo 0.00 )
	aliq_cofins_real=$([[ $(echo $ITEM | cut -d '|' -f 35) != '' ]] && echo $ITEM | cut -d '|' -f 35 | sed 's/\,/\./g' || echo 0.00 )
	vl_cofins=$([[ $(echo $ITEM | cut -d '|' -f 36) != '' ]] && echo $ITEM | cut -d '|' -f 36 | sed 's/\,/\./g' || echo 0.00 )
	cod_cta=$(echo $ITEM | cut -d '|' -f 37)
	vl_abat_nt=$([[ $(echo $ITEM | cut -d '|' -f 38) != '' ]] && echo $ITEM | cut -d '|' -f 38 | sed 's/\,/\./g' || echo 0.00 )

	echo "SET @cod_item=(SELECT id FROM tb_produto WHERE cod_item = '$COD_ITEM');"
	echo "SET @num_item='$num_item';"
	echo "SET @qtd='$qtd';"
	echo "SET @unid='$unid';"
	echo "SET @vl_item='$vl_item';"
	echo "SET @vl_desc='$vl_desc';"
	echo "SET @ind_mov='$ind_mov';"
	echo "SET @cst_icms='$cst_icms';"
	echo "SET @cfop='$cfop';"
	echo "SET @cod_nat='$cod_nat';"
	echo "SET @vl_bc_icms='$vl_bc_icms';"
	echo "SET @aliq_icms='$aliq_icms';"
	echo "SET @vl_icms='$vl_icms';"
	echo "SET @vl_bc_icms_st='$vl_bc_icms_st';"
	echo "SET @aliq_st='$aliq_st';"
	echo "SET @vl_icms_st='$vl_icms_st';"
	echo "SET @ind_apur='$ind_apur';"
	echo "SET @cst_ipi='$cst_ipi';"
	echo "SET @cod_enq='$cod_enq';"
	echo "SET @vl_bc_ipi='$vl_bc_ipi';"
	echo "SET @aliq_ipi='$aliq_ipi';"
	echo "SET @vl_ipi='$vl_ipi';"
	echo "SET @cst_pis='$cst_pis';"
	echo "SET @vl_bc_pis='$vl_bc_pis';"
	echo "SET @aliq_pis_percent='$aliq_pis_percent';"
	echo "SET @quant_bc_pis='$quant_bc_pis';"
	echo "SET @aliq_pis_real='$aliq_pis_real';"
	echo "SET @vl_pis='$vl_pis';"
	echo "SET @cst_cofins='$cst_cofins';"
	echo "SET @vl_bc_cofins='$vl_bc_cofins';"
	echo "SET @aliq_cofins_percent='$aliq_cofins_percent';"
	echo "SET @quant_bc_cofins='$quant_bc_cofins';"
	echo "SET @aliq_cofins_real='$aliq_cofins_real';"
	echo "SET @vl_cofins='$vl_cofins';"
	echo "SET @cod_cta='$cod_cta';"
	echo "SET @vl_abat_nt='$vl_abat_nt';"
	echo "CALL Cadastra_NFe_Itens(
		@cod_item, @num_item, @qtd, @unid, @vl_item, @vl_desc, @ind_mov, @cst_icms, @cfop, @cod_nat, @vl_bc_icms, @aliq_icms, @vl_icms, @vl_bc_icms_st, @aliq_st, @vl_icms_st, @ind_apur, @cst_ipi, @cod_enq, @vl_bc_ipi, @aliq_ipi, @vl_ipi, @cst_pis, @vl_bc_pis, @aliq_pis_percent, @quant_bc_pis, @aliq_pis_real, @vl_pis, @cst_cofins, @vl_bc_cofins, @aliq_cofins_percent, @quant_bc_cofins, @aliq_cofins_real, @vl_cofins, @cod_cta, @vl_abat_nt
	);"

}