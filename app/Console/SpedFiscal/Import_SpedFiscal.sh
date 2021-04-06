#!/bin/bash

source ../app/Console/SpedFiscal/spedfiscal.sh
source ../app/Console/SpedFiscal/empresa.sh
source ../app/Console/SpedFiscal/contabilista.sh
source ../app/Console/SpedFiscal/participante.sh
source ../app/Console/SpedFiscal/unidades_de_medida.sh
source ../app/Console/SpedFiscal/produto.sh
source ../app/Console/SpedFiscal/notafiscal.sh

function Import_SpedFiscal() {

	LINHA=$(echo $ARQUIVO | sed 's/\ /\+/g' | sed 's/|//')
	REGISTRO=$(echo $ARQUIVO | cut -d '|' -f 2)

	SPEDFISCAL=0
	ID_SPEDFISCAL=0
	ID_EMPRESA=0
	ID_CONTADOR=0
	ID_PARTICIPANTE=0
	ID_UNIDADE=0
	ID_PRODUTO=0
	ID_NFE=0

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

}