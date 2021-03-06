#!/usr/bin/env python3

import os
import sys
from mysql.connector import connect, Error
from datetime import datetime, timedelta

'''
'	@autor: Alisson Guedes
'	@Date: Qui 21 Jan 2021 09:54 -03
'	@Updated: Qui 18 Mar 2021 14:12 -03
'
'	SCRIPT PARA EXECUTAR LEITURA DOS ARQUIVOS `sped_fiscal` NO FORMATO TXT
'
'	Como o arquivo de sped_fiscal é muito grande em números de linhas, e no PHP
'	existe um tempo de execução limitado, o programa aborta sem obter a leitura completa do arquivo.
'
'	Portanto, utilizaremos este script para realizar a leitura linha a linha e a sua tratativa
'	de inserção no banco de dados.
'
'	Embora, existam configurações no PHP que possam solucionar o problema de limite de execução,
'	a linguagem Python foi escolhida por fazer isso em um tempo muito menor sem a preocupação de sobrecarga do servidor.
'''

try:
	conn = connect(host='localhost', user='alissong_stoledo',
				password='5r6kLdALaGlU', database='alissong_stoledo', raw=False)
	print('Connection established')
except Error:
	print(Error)
else:
	cursor = conn.cursor()

'''
'	Estaremos executando este arquivo sempre no diretório `public` ou `public_html`,
'	portanto, todos os arquivos serão listados como no por exemplo a seguir:
'
'		`/var/www/html/website.com.br/public/../storage/app/public/files/txt/`
'
'	Assim, obteremos o caminho completo, indepentemente do SO, para o diretório de arquivos de textos. Por exemplo:
'
'		`/var/www/html/website.com.br/storage/app/public/files/txt/`.
'''

# DIR = os.path.join(os.getcwd() + os.sep + '..' + os.sep + 'storage' + os.sep + 'app' + os.sep + 'public' + os.sep + 'files' + os.sep + 'txt' + os.sep)

'''
' Lista todos os arquivos do diretório DIR.
'''
# FILES = os.listdir(DIR)

'''
' Função para retornar o último ID inserido no banco de dados
'''


def getLastId():

	query = 'select last_insert_id();'
	cursor.execute(query)
	v = cursor.fetchall()

	return '%s' % (v[0])

###############################################################################

'''
' Função para cdastrar o contador
'
' @name: insertContador
' @param: linha - o número da linha onde está a informação no arquivo digital
' @author: Alisson Guedes
'''
def insertContador(linha):

	contador = linha.split('|')
	contador.pop()

	if contador[0] == '':
		contador.pop(0)

	# verificar se existe o contador cadastrado pelo cpf ou pelo cnpj
	query = 'SELECT id FROM tb_contabilista WHERE cpf = "{}" OR cnpj = "{}";'.format(contador[2], contador[4])

	print(query)
	cursor.execute(query)
	id_contador = cursor.fetchall()

	if cursor.rowcount == 0:

		query = 'INSERT INTO tb_contabilista (nome, cpf, crc, cnpj, cep, logradouro, numero, complemento, bairro, fone, fax, email, cod_mun) \
					VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);'
		values = (contador[1], contador[2], contador[3], contador[4], contador[5], contador[6],
				contador[7], contador[8], contador[9], contador[10], contador[11], contador[12], contador[13])

		# print(query %(values))
		cursor.execute(query, values)
		conn.commit()

		query = 'select last_insert_id();'
		cursor.execute(query)
		v = cursor.fetchall()

		id_contador = getLastId()

	else:

		id_contador = ('%s' % (id_contador[0]))

	return id_contador

######################################################################

'''
' Função para verificar se o fornecedor já está cadastrado na tabela `tb_fornecedor`
'
' @name: getFornecedor
' @param: linha - o número da linha onde está a informação no arquivo digital
' @author: Alisson Guedes
' @return: id do Fornecedor
'''
def getFornecedor(fornecedor):

	cnpj = ''
	cpf = ''
	ie = ''

	condicao = ''

	if fornecedor[4] != '':
		cnpj = 'cnpj = "{}"'.format(fornecedor[4])
		condicao = cnpj

	if fornecedor[5] != '':
		cpf = 'cpf = "{}"'.format(fornecedor[5])
		condicao = cpf

	if fornecedor[6] != '':
		ie = 'ie = "{}"'.format(fornecedor[6])
		condicao = ie

	if cnpj != '' and cnpj != '' and ie != '':
		condicao = cnpj + ' OR ' + cpf
	if cnpj != '' and ie != '':
		condicao = cnpj + ' OR ' + ie
	elif cnpj != '' and cpf != '':
		condicao = cnpj + ' OR ' + cpf + ' OR ' + ie

	query = 'SELECT id FROM tb_fornecedor WHERE {};'

	# print(query.format(condicao))

	cursor.execute(query.format(condicao))
	rows = cursor.fetchone()

	if cursor.rowcount == 0:
		return False
	else:
		return '%s' % (rows[0])

######################################################################

'''
' Função para cadastrar o fornecedor encontrado que não existir na tabela `tb_fornecedor`
'
' @name: insertSped
' @param: linha - o número da linha onde está a informação no arquivo digital
' @return: id do Fornecedor
'''
def cadastraFornecedor(dados):

	print('Verificando se o Fornecedor "{}" - "{}" já está cadastrado...'.format(dados[4], dados[2]))

	id_fornecedor = getFornecedor(dados)

	if not id_fornecedor:
		print(dados)

		print('Cadastrando Fornecedor "{}" - "{}"...'.format(dados[4], dados[2]))

		query = 'INSERT INTO tb_fornecedor \
					(nome, cPais, cnpj, cpf, ie, cMun, suframa, xLgr, nro, complemento, xBairro) \
					VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);'

		values = (dados[2], dados[3], dados[4], dados[5], dados[6],
				dados[7], dados[8], dados[9], dados[10], dados[11], dados[12])

		cursor.execute(query, values)
		conn.commit()

		print('Fornecedor "{}" - "{}" cadastrado com sucesso.'.format(dados[4], dados[2]))

		return getLastId()

	else:

		return id_fornecedor

######################################################################

'''
' Função para cadastrar o Sped Fiscal
'
' @name: insertSped
' @param: linha - o número da linha onde está a informação no arquivo digital
' @author: Alisson Guedes
' @return: retorna o ID do registro na tabela tb_spedfiscal
'''
def insertSped(linha, contador):

	sped = linha.split('|')
	sped.pop()

	if sped[0] == '':
		sped.pop(0)

	'''
	Inserir o fornecedor do sped fiscal
	'''
	query = 'SELECT cnpj FROM tb_fornecedor WHERE cnpj = "{}";'.format(sped[6])
	print(query)
	cursor.execute(query)
	fornecedor = cursor.fetchone()

	if cursor.rowcount == 0 :

		query = 'INSERT INTO tb_fornecedor \
					(nome, cnpj, cpf, uf, ie, cMun, im, suframa) \
					VALUES (%s, %s, %s, %s, %s, %s, %s, %s);'

		values = (sped[5], sped[6], sped[7], sped[8], sped[9], sped[10], sped[11], sped[12])

		print(query %(values))
		cursor.execute(query, values)
		conn.commit()

	else :
		fornecedor = '%s' % (fornecedor[0])

	query = 'SELECT id FROM tb_spedfiscal WHERE dt_ini = "{}" AND dt_fin = "{}" AND cnpj_fornecedor = "{}";'.format(
		sped[3], sped[4], fornecedor)
	# print(query)

	cursor.execute(query)
	id_sped = cursor.fetchall()

	if cursor.rowcount == 0:

		query = 'INSERT INTO tb_spedfiscal \
					(cnpj_fornecedor, id_contabilista, cod_ver, cod_fin, dt_ini, dt_fin, ind_perfil) \
				VALUES \
					(%s, %s, %s, %s, %s, %s, %s);'
		values = (sped[6], contador, sped[1],
				sped[2], sped[3], sped[4], sped[13])

		# print(query %(values))

		cursor.execute(query, values)
		conn.commit()

		return getLastId()

	else:

		return '%s' % (id_sped[0])

######################################################################

'''
' Função para cadastrar o bloco 0150 na tabela `tb_spedfiscal_participante` de acordo com a NT NFD ICMS PIS
' O bloco 150 se refere ao bloco de cadastro de participantes no Sped Fiscal.
'
' @name: insertSped
' @param: linha - o número da linha onde está a informação no arquivo digital
' @author: Alisson Guedes
' @return: sem retorno
'''
def insertBloco150(dados, id_sped):

	id_fornecedor = cadastraFornecedor(dados)

	print('Verificando se o Fornecedor "{}" já está cadastrado na tabela de participantes do sped fiscal ({})...'.format(id_fornecedor, dados[1]))

	query = 'SELECT id_sped, id_fornecedor, cod_part FROM tb_spedfiscal_participante WHERE id_sped = "{}" AND cod_part = "{}" AND id_fornecedor = "{}"'.format(id_sped, dados[1], id_fornecedor)

	cursor.execute(query)
	rows = cursor.fetchone()

	if cursor.rowcount == 0:

		print('Cadastrando Fornecedor "{}" na tabela de participantes do sped fiscal ({}).'.format(id_fornecedor, dados[1]))

		query = 'INSERT INTO tb_spedfiscal_participante (id_sped, id_fornecedor, cod_part) VALUES (%s, %s, %s);'
		values = (id_sped, id_fornecedor, dados[1])

		cursor.execute(query, values)
		conn.commit()

		print('Participante "{}" vinculado com sucesso ao sped fiscal ({}) na tabela de participantes.'.format(id_fornecedor, dados[1]))

######################################################################

'''
' Função para cadastrar o bloco 0190 na tabela `tb_unidade_medida` de acordo com a NT NFD ICMS PIS
' O bloco 190 se refere ao bloco de cadastro das unidades de medidas no Sped Fiscal.
'
' @name: insertSped
' @param: linha - o número da linha onde está a informação no arquivo digital
' @author: Alisson Guedes
' @return: sem retorno
'''
def insertBloco190(dados):

	print('Verificando se a unidade de medida "{}" - "{}" já está cadastrada...'.format(dados[1], dados[2]))

	query = 'SELECT id FROM tb_unidade_medida WHERE unidade = "{}";'.format(
		dados[1])

	cursor.execute(query)
	rows = cursor.fetchone()

	if cursor.rowcount == 0:

		print('Cadastrando a unidade de medida "{}" - "{}".'.format(dados[1], dados[2]))

		query = 'INSERT INTO tb_unidade_medida (unidade, descricao) VALUES (%s, %s);'
		values = (dados[1], dados[2])

		cursor.execute(query, values)
		conn.commit()

		print('Unidade de medida "{}" - "{}" cadastrada com sucesso.'.format(dados[1], dados[2]))

######################################################################

'''
' Função para cadastrar o bloco 0200 na tabela `tb_spedfiscal_participante` de acordo com a NT NFD ICMS PIS
' O bloco 200 se refere ao bloco de cadastro de identificação de itens no Sped Fiscal.
'
' @name: insertSped
' @param: linha - o número da linha onde está a informação no arquivo digital
' @author: Alisson Guedes
' @return: sem retorno
'''
def insertBloco200(dados):

	print('Verificando se o produto "{}" - "{}" já está cadastrado...'.format(dados[1], dados[2]))

	id_produto = 0

	query = 'SELECT id FROM tb_produto WHERE cod_item = "{}";'.format(dados[1])

	cursor.execute(query)
	row = cursor.fetchone()

	if cursor.rowcount == 0:

		print('Cadastrando produto "{}" - "{}".'.format(dados[1], dados[2]))

		query = 'INSERT INTO tb_produto (cod_item, descricao, cod_barra, cod_ant_item, unidade_inv, tipo_item, cod_ncm, ex_ipi, cod_gen, cod_lst, aliquota_icms, cest) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)'
		values = (dados[1], dados[2], dados[3], dados[4], dados[5], dados[6], dados[7], dados[8], (dados[9], 0)[dados != ''], dados[10], dados[11].replace(',', '.'), (dados[12], 0)[dados != ''] )

		# print(query %(values))
		cursor.execute(query, values)
		conn.commit()

		id_produto = getLastId()

		print('Produto "{}" - "{}" cadastrado com sucesso.'.format(dados[1], dados[2]))

	else :

		print('Produto "{}" - "{}" já cadastrado.'.format(dados[1], dados[2]))

		id_produto = '%s' %(row[0])

	return id_produto

'''
' Função para cadastrar o bloco 0200 na tabela `tb_spedfiscal_participante` de acordo com a NT NFD ICMS PIS
' O bloco 200 se refere ao bloco de cadastro de identificação de itens no Sped Fiscal.
'
' @name: insertSped
' @param: linha - o número da linha onde está a informação no arquivo digital
' @author: Alisson Guedes
' @return: sem retorno
'''
def insertBloco220(dados, id_produto) :

		print('Verificando se o fator de conversão "{}" - "{}" para o produto "{}" já está cadastrado...'.format(dados[1], dados[2], id_produto))
		query = 'SELECT id FROM tb_produto_conversao WHERE id_produto = "{}" AND unidade = "{}";'.format(id_produto, dados[1])

		cursor.execute(query)
		row = cursor.fetchone()

		if cursor.rowcount == 0:

			print('Cadastrando fator de conversão "{}" - "{}" para o produto "{}"...'.format(dados[1], dados[2], id_produto))
			query = 'INSERT INTO tb_produto_conversao (id_produto, unidade, fator_conversao) VALUES (%s, %s, %s);'
			values = (id_produto, dados[1], dados[2].replace(',', '.'))

			cursor.execute(query, values)
			conn.commit()
			print('Fator de conversão "{}" - "{}" para o produto "{}" cadastrado com sucesso.'.format(dados[1], dados[2], id_produto))

######################################################################

'''
' Função para cadastrar o bloco 0200 na tabela `tb_spedfiscal_participante` de acordo com a NT NFD ICMS PIS
' O bloco 200 se refere ao bloco de cadastro de identificação de itens no Sped Fiscal.
'
' @name: insertSped
' @param: linha - o número da linha onde está a informação no arquivo digital
' @author: Alisson Guedes
' @return: sem retorno
'''
def insertBlocoC100(campo, id_sped):

	print('Verificando se a Nota fiscal DOC: "{}" "{}" já está cadastrada...'.format(campo[7], campo[8]))

	query = 'SELECT id FROM tb_spedfiscal_nfe WHERE num_doc = "{}" AND chv_nfe = "{}";'

	cursor.execute(query.format(campo[7], campo[8]))
	row = cursor.fetchone()

	if cursor.rowcount == 0:

		print('Cadastrando a Nota fiscal DOC: "{}" "{}"...'.format(campo[7], campo[8]))

		id_sped = id_sped
		ind_oper = campo[1]
		ind_emit = campo[2]
		cod_part = campo[3]
		cod_mod = campo[4]
		cod_sit = campo[5]
		ser = campo[6]
		num_doc = campo[7]
		chv_nfe = campo[8]
		dt_doc = campo[9] if campo[9] != '' else 0
		dt_e_s = campo[10] if campo[10] != '' else 0
		vl_doc = campo[11].replace(',', '.') if campo[11] != '' else 0
		ind_pgto = campo[12].replace(',', '.') if campo[12] != '' else 0
		vl_desc = campo[13].replace(',', '.') if campo[13] != '' else 0
		vl_abat_nt = campo[14].replace(',', '.') if campo[14] != '' else 0
		ind_frt = campo[16]
		vl_frt = campo[17].replace(',', '.') if campo[17] != '' else 0
		vl_seg = campo[18].replace(',', '.') if campo[18] != '' else 0
		vl_out_dia = campo[19].replace(',', '.') if campo[19] != '' else 0
		vl_bc_icms = campo[20].replace(',', '.') if campo[20] != '' else 0
		vl_icms = campo[21].replace(',', '.') if campo[21] != '' else 0
		vl_bc_icms_st = campo[22].replace(',', '.') if campo[22] != '' else 0
		vl_icms_cst = campo[23].replace(',', '.') if campo[23] != '' else 0
		vl_ipi = campo[24].replace(',', '.') if campo[24] != '' else 0
		vl_pis = campo[25].replace(',', '.') if campo[25] != '' else 0
		vl_cofins = campo[26].replace(',', '.') if campo[26] != '' else 0
		vl_pis_st = campo[27].replace(',', '.') if campo[27] != '' else 0
		vl_cofins_st = campo[28].replace(',', '.') if campo[28] != '' else 0

		query = 'INSERT INTO tb_spedfiscal_nfe (id_sped, ind_oper, ind_emit, cod_part, cod_mod, cod_sit, ser, num_doc, chv_nfe, dt_doc, dt_e_s, vl_doc, ind_pgto, vl_desc, vl_abat_nt, ind_frt, vl_frt, vl_seg, vl_out_dia, vl_bc_icms, vl_icms, vl_bc_icms_st, vl_icms_cst, vl_ipi, vl_pis, vl_cofins, vl_pis_st, vl_cofins_st) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);'

		values = (id_sped, ind_oper, ind_emit, cod_part, cod_mod, cod_sit, ser, num_doc, chv_nfe,  dt_doc, dt_e_s, vl_doc, ind_pgto, vl_desc, vl_abat_nt, ind_frt, vl_frt, vl_seg, vl_out_dia, vl_bc_icms, vl_icms, vl_bc_icms_st, vl_icms_cst, vl_ipi, vl_pis, vl_cofins, vl_pis_st, vl_cofins_st)

		# print(query %(values))

		cursor.execute(query, values)
		conn.commit()

		if cursor.rowcount > 0:
			print('Cadastrando a Nota fiscal DOC: "{}" "{}" cadastrada com sucesso.'.format(campo[7], campo[8]))

	else:
		print('Nota fiscal  DOC: "{}" "{}" já cadastrada.'.format(campo[7], campo[8]))

######################################################################

'''
' Função para cadastrar o bloco 0200 na tabela `tb_spedfiscal_participante` de acordo com a NT NFD ICMS PIS
' O bloco 200 se refere ao bloco de cadastro de identificação de itens no Sped Fiscal.
'
' @name: insertSped
' @param: linha - o número da linha onde está a informação no arquivo digital
' @author: Alisson Guedes
' @return: sem retorno
'''
def insertBlocoC170(campo, id_sped) :

	query = 'SELECT id FROM tb_spedfiscal_item WHERE cod_item = "{}";'.format(campo[2])

	cursor.execute(query.format(campo[2]))
	row = cursor.fetchone()

	num_item = campo[1]
	cod_item = campo[2]
	qtd = campo[4].replace(',', '.')
	unid = campo[5]
	vl_item = campo[6].replace(',', '.')
	vl_desc = campo[7].replace(',', '.')
	ind_mov = campo[8]
	cst_icms= campo[9]
	cfop = campo[10]
	cod_nat = campo[11]
	vl_bc_icms = campo[12].replace(',', '.')
	aliq_icms = campo[13].replace(',', '.')
	vl_icms = campo[14].replace(',', '.')
	vl_bc_icms_st = campo[15].replace(',', '.')
	aliq_st = campo[16].replace(',', '.')
	vl_icms_st = campo[17].replace(',', '.')
	ind_apur = campo[18]
	cst_ipi = campo[19]
	cod_enq = campo[20]
	vl_bc_ipi = campo[21].replace(',', '.')
	aliq_ipi = campo[22].replace(',', '.')
	vl_ipi = campo[23].replace(',', '.')
	cst_pis = campo[24]
	vl_bc_pis = campo[25].replace(',', '.')
	aliq_pis_percent = campo[26].replace(',', '.')
	quant_bc_pis = campo[27].replace(',', '.')
	aliq_pis_real = campo[28].replace(',', '.')
	vl_pis = campo[29].replace(',', '.')
	cst_cofins = campo[30]
	vl_bc_cofins= campo[31].replace(',', '.')
	aliq_cofins_percent = campo[32].replace(',', '.')
	quant_bc_cofins = campo[33].replace(',', '.')
	aliq_cofins_real = campo[34].replace(',', '.')
	vl_cofins = campo[35].replace(',', '.')
	cod_cta = campo[36]
	vl_abat_nt = campo[37].replace(',', '.')

	if cursor.rowcount == 0 :

		print('Cadastrando item "{}".'.format(cod_item))

		query = 'INSERT INTO tb_spedfiscal_item (id_sped,num_item,cod_item,qtd,unid,vl_item,vl_desc,ind_mov,cst_icms,cfop,cod_nat,vl_bc_icms,aliq_icms,vl_icms,vl_bc_icms_st,aliq_st,vl_icms_st,ind_apur,cst_ipi,cod_enq,vl_bc_ipi,aliq_ipi,vl_ipi,cst_pis,vl_bc_pis,aliq_pis_percent,quant_bc_pis,aliq_pis_real,vl_pis,cst_cofins,vl_bc_cofins,aliq_cofins_percent,quant_bc_cofins,aliq_cofins_real,vl_cofins,cod_cta,vl_abat_nt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);'

		values = (id_sped,num_item,cod_item,qtd,unid,vl_item,vl_desc,ind_mov,cst_icms,cfop,cod_nat,vl_bc_icms,aliq_icms,vl_icms,vl_bc_icms_st,aliq_st,vl_icms_st,ind_apur,cst_ipi,cod_enq,vl_bc_ipi,aliq_ipi,vl_ipi,cst_pis,vl_bc_pis,aliq_pis_percent,quant_bc_pis,aliq_pis_real,vl_pis,cst_cofins,vl_bc_cofins,aliq_cofins_percent,quant_bc_cofins,aliq_cofins_real,vl_cofins,cod_cta,vl_abat_nt)

		# print(query %(values))
		cursor.execute(query, values)
		conn.commit()

		if cursor.rowcount > 0 :
			print('Item "{}" cadastrado com sucesso.'.format(cod_item))

	else:
		print('Item "{}" já cadastrado.'.format(cod_item))

######################################################################

'''
' Função para cadastrar o bloco 0200 na tabela `tb_spedfiscal_participante` de acordo com a NT NFD ICMS PIS
' O bloco 200 se refere ao bloco de cadastro de identificação de itens no Sped Fiscal.
'
' @name: insertSped
' @param: linha - o número da linha onde está a informação no arquivo digital
' @author: Alisson Guedes
' @return: sem retorno
'''

for file in FILES:

	files = open(DIR + file, encoding='iso-8859-1')
	ln = files.readlines()

	''' Abertura do arquivo digital '''
	abertura_arquivo = ln[0] 	# Linha 0000 - Abertura do arquivo segundo NT EFD ICMS PIS
	abertura_bloco = ln[1]  # Linha 0001 - Abertura do bloco
	# Linha 0005 - Informações complementares da entidade
	classifica_estab = ln[2]
	dados_contador = ln[3]  # Linha 0100 - Informação do contador

	''' Inserção dos dados do contador '''
	contador = insertContador(dados_contador)

	''' Inserção de dados para cadastro do arquivo digital '''
	id_sped_fiscal = insertSped(abertura_arquivo, contador)

	campos = []

	id_produto = 0

	for linha_atual, valor in enumerate(ln):

		campo = valor.split('|')

		'''
		'	Cada linha do arquivo inicia com um PIPE "|". Assim, nós obtemos uma saída de cada linha da seguinte forma:
		'
		'		`['', '0000', '013', '0', '01092019', '30092019', 'Master Supermercados Ltda', '00915011000100', '',
		'			'PB', '161102506', '2512507', '', '', 'B', '1', '\n']`
		'
		'	Sabe-se que o arquivo Sped marca o ínicio e o fim de cada linha com o PIPE, a função split considera o
		'	primeiro e último PIPEs como '	sendo um índice desse array, no entanto, isso pode causar informações incorretas e,
		'	portanto, precisamos remover o primeiro ('' - campo vazio) e último ('\n' - salto de linha) índices de cada linha.
		'	Assim, teremos as informações completas de cada linha corretamente
		'''

		###############################################################################
		#                                                                             #
		# Remover o primeiro índice e último índices do array que são vazios          #
		campo.pop()                                                                   #
		if campo[0] == '':                                                            #
			campo.pop(0)                                                              #
		###############################################################################

		###############################################################################

		if campo[0] == '0150':
			cadastraFornecedor(campo)
			insertBloco150(campo, id_sped_fiscal)

		###############################################################################

		if campo[0] == '0190':
			insertBloco190(campo)

		###############################################################################

		if campo[0] == '0200' :
			id_produto = insertBloco200(campo)

		###############################################################################

		if campo[0] == '0220' :
			insertBloco220(campo, id_produto)

		###############################################################################

		if campo[0] == 'C100':
			insertBlocoC100(campo, id_sped_fiscal)

		###############################################################################
		if campo[0] == 'C170':
			insertBlocoC170(campo, id_sped_fiscal)

###############################################################################
# files.close()
cursor.close()
###############################################################################