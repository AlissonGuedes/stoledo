#!/bin/bash

source ../app/Console/DB.sh

DATABASE=$1
USERNAME=$2
PASSWORD=$3
TIPO=$4
CNPJ=$5
DATA_INICIAL=$6
DATA_FINAL=$7
ARQUIVO=$8

DATETIME=$(echo "`date +%Y%m%d%H%M%S`")

# if [ ! ls ../storage/app/public/files/exports/spedfiscal/ 2> /dev/null ]
# then

# 	mkdir -p ../storage/app/public/files/exports/spedfiscal/

# fi

if [ $TIPO == 1 ]
then

	TIPO=escrituradas

	QUERY="select

				chNFe AS Chave_de_acesso,
				cUF AS Codigo_UF,
				(SELECT descr_nat FROM tb_natureza_operacao WHERE cod_nat = natOp) AS Natureza_Operacao,
				nNF AS Numero_NF,
				serie AS Serie,
				dhEmi AS Data_Hora_Emissao,
				dhSaiEnt AS Data_Hora_Saida_Entrada,

				(SELECT IF(nome <> '', nome, xFant) FROM tb_fornecedor WHERE cnpj = cEmi) AS Nome_Emitente,
				(SELECT IF(cnpj <> '', cnpj, cpf) FROM tb_fornecedor WHERE cnpj = cEmi OR cpf = cEmi) AS CNPJ_Emitente,
				(SELECT ie FROM tb_fornecedor WHERE cnpj = cEmi) AS Inscricao_Estadual_Emitente,
				(SELECT fone FROM tb_fornecedor WHERE cnpj = cEmi) AS Telefone_Emitente,
				(SELECT xLgr FROM tb_fornecedor WHERE cnpj = cEmi) AS Logradouro_Emitente,
				(SELECT nro FROM tb_fornecedor WHERE cnpj = cEmi) AS Numero_Emitente,
				(SELECT xBairro FROM tb_fornecedor WHERE cnpj = cEmi) AS Bairro_Emitente,
				(SELECT xMun FROM tb_municipio WHERE cMun = (SELECT cMun from tb_fornecedor WHERE cnpj = cEmi) ) AS Municipio_Emitente,
				(SELECT uf FROM tb_municipio WHERE cMun = (SELECT cMun from tb_fornecedor WHERE cnpj = cEmi) ) AS UF_Emitente,

				(SELECT IF(nome <> '', nome, xFant) FROM tb_fornecedor WHERE cnpj = cDest) AS Nome_Destinatario,
				(SELECT IF(cnpj <> '', cnpj, cpf) FROM tb_fornecedor WHERE cnpj = cEmi OR cpf = cDest) AS CNPJ_Destinatario,
				(SELECT ie FROM tb_fornecedor WHERE cnpj = cDest) AS Inscricao_Estadual_Destinatario,
				(SELECT fone FROM tb_fornecedor WHERE cnpj = cDest) AS Telefone_Destinatario,
				(SELECT xLgr FROM tb_fornecedor WHERE cnpj = cDest) AS Logradouro_Destinatario,
				(SELECT nro FROM tb_fornecedor WHERE cnpj = cDest) AS Numero_Destinatario,
				(SELECT xBairro FROM tb_fornecedor WHERE cnpj = cEmi) AS Bairro_Destinatario,
				(SELECT xMun FROM tb_municipio WHERE cMun = (SELECT cMun from tb_fornecedor WHERE cnpj = cDest) ) AS Municipio_Destinatario,
				(SELECT uf FROM tb_municipio WHERE cMun = (SELECT cMun from tb_fornecedor WHERE cnpj = cDest) ) AS UF_Destinatario,

				vBC AS Valor_Base_Calculo,
				vICMS AS Valor_ICMS,
				vICMSDeson AS Valor_ICMS_Deson,
				vFCP AS Valor_FCP,
				vBCST AS Valor_Base_Calculo_ST,
				vST AS Valor_Substituicao_Tributaria,
				vFCPST AS Valor_FCPST,
				vFCPSTRet AS Valor_FCPSTRet,
				vProd AS Valor_Produtos,
				vFrete AS Valor_Frete,
				vSeg AS Valor_Seguro,
				vDesc AS Valor_Desconto,
				vIPI AS Valor_IPI,
				vIPIDevol Valor_IPI_Devolucao,
				vPIS AS Valor_PIS,
				vCOFINS AS Valor_COFINS,
				vOutro AS Valor_Outros,
				vNF AS Valor_Total_NFe,
				vTotTrib AS Valor_Total_Tributacoes,
				modFrete AS Modelo_Freto,
				cTransportadora AS Transportadora,
				veicTranspPlaca AS Placa_Veiculo_Transportadora,
				veicTranspUF AS UF_Veiculo_Transportadora,
				qVol AS Q_Volume,
				nVol AS N_Volume,
				pesoL AS Peso_Liquido,
				pesoB AS Peso_Bruto,
				nFat AS Numero_Fatura,
				vOrig AS Valor_Origem,
				vDescFat AS Valor_Desconto_Fatura,
				vLiq AS Valor_Liquido,
				indPag AS Indicativo_Pagamento,
				tPag AS Total_Pago,
				vPag AS Vencimento_Pagamento

	 from tb_nfe as N where chNFe in (select chv_nfe from tb_spedfiscal_nfe as S inner join tb_nfe on chNFe = S.chv_nfe) and N.cDest = '$CNPJ' and N.dhEmi between '$DATA_INICIAL' and '$DATA_FINAL';"

else

	TIPO=nao_escrituradas
	QUERY="select

				chNFe AS Chave_de_acesso,
				cUF AS Codigo_UF,
				natOp AS Natureza_Operacao,
				serie AS Serie,
				nNF AS Numero_NF,
				dhEmi AS Data_Hora_Emissao,
				dhSaiEnt AS Data_Hora_Saida_Entrada,
				tpNF AS Tipo_NF,

				(SELECT IF(nome <> '', nome, xFant) FROM tb_fornecedor WHERE cnpj = cEmi) AS Nome_Emitente,
				(SELECT cnpj FROM tb_fornecedor WHERE cnpj = cEmi) AS CNPJ_Emitente,
				(SELECT ie FROM tb_fornecedor WHERE cnpj = cEmi) AS Inscricao_Estadual_Emitente,
				(SELECT fone FROM tb_fornecedor WHERE cnpj = cEmi) AS Telefone_Emitente,
				(SELECT xLgr FROM tb_fornecedor WHERE cnpj = cEmi) AS Logradouro_Emitente,
				(SELECT nro FROM tb_fornecedor WHERE cnpj = cEmi) AS Numero_Emitente,
				(SELECT xBairro FROM tb_fornecedor WHERE cnpj = cEmi) AS Bairro_Emitente,
				(SELECT xMun FROM tb_municipio WHERE cMun = (SELECT cMun from tb_fornecedor WHERE cnpj = cEmi) ) AS Municipio_Emitente,
				(SELECT uf FROM tb_municipio WHERE cMun = (SELECT cMun from tb_fornecedor WHERE cnpj = cEmi) ) AS UF_Emitente,

				(SELECT IF(nome <> '', nome, xFant) FROM tb_fornecedor WHERE cnpj = cDest) AS Nome_Destinatario,
				(SELECT cnpj FROM tb_fornecedor WHERE cnpj = cDest) AS CNPJ_Destinatario,
				(SELECT ie FROM tb_fornecedor WHERE cnpj = cDest) AS Inscricao_Estadual_Destinatario,
				(SELECT fone FROM tb_fornecedor WHERE cnpj = cDest) AS Telefone_Destinatario,
				(SELECT xLgr FROM tb_fornecedor WHERE cnpj = cDest) AS Logradouro_Destinatario,
				(SELECT nro FROM tb_fornecedor WHERE cnpj = cDest) AS Numero_Destinatario,
				(SELECT xBairro FROM tb_fornecedor WHERE cnpj = cEmi) AS Bairro_Destinatario,
				(SELECT xMun FROM tb_municipio WHERE cMun = (SELECT cMun from tb_fornecedor WHERE cnpj = cDest) ) AS Municipio_Destinatario,
				(SELECT uf FROM tb_municipio WHERE cMun = (SELECT cMun from tb_fornecedor WHERE cnpj = cDest) ) AS UF_Destinatario,

				vBC AS Valor_Base_Calculo,
				vICMS AS Valor_ICMS,
				vICMSDeson AS Valor_ICMS_Deson,
				vFCP AS Valor_FCP,
				vBCST AS Valor_Base_Calculo_ST,
				vST AS Valor_Substituicao_Tributaria,
				vFCPST AS Valor_FCPST,
				vFCPSTRet AS Valor_FCPSTRet,
				vProd AS Valor_Produtos,
				vFrete AS Valor_Frete,
				vSeg AS Valor_Seguro,
				vDesc AS Valor_Desconto,
				vIPI AS Valor_IPI,
				vIPIDevol Valor_IPI_Devolucao,
				vPIS AS Valor_PIS,
				vCOFINS AS Valor_COFINS,
				vOutro AS Valor_Outros,
				vNF AS Valor_Total_NFe,
				vTotTrib AS Valor_Total_Tributacoes,
				modFrete AS Modelo_Freto,
				cTransportadora AS Transportadora,
				veicTranspPlaca AS Placa_Veiculo_Transportadora,
				veicTranspUF AS UF_Veiculo_Transportadora,
				qVol AS Q_Volume,
				nVol AS N_Volume,
				pesoL AS Peso_Liquido,
				pesoB AS Peso_Bruto,
				nFat AS Numero_Fatura,
				vOrig AS Valor_Origem,
				vDescFat AS Valor_Desconto_Fatura,
				vLiq AS Valor_Liquido,
				indPag AS Indicativo_Pagamento,
				tPag AS Total_Pago,
				vPag AS Vencimento_Pagamento

	from tb_nfe as N where chNFe not in (select chv_nfe from tb_spedfiscal_nfe as S inner join tb_nfe on tb_nfe.chNFe = S.chv_nfe) and N.cDest = '$CNPJ' and N.dhEmi between '$DATA_INICIAL' and '$DATA_FINAL';"

fi

RESULT=$(Execute "$QUERY" $USERNAME $PASSWORD $DATABASE)

echo "$RESULT" > "$ARQUIVO"