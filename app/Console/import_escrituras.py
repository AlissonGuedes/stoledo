#!/usr/bin/env python3

import os
from mysql.connector import connect, Error
from datetime import datetime, timedelta
import unicodedata
import re

try :

	conn = connect(host='localhost', user='alissong_stoledo', password='5r6kLdALaGlU', database='alissong_stoledo', raw=False)
	print('Connection established')

except Error:

	print(Error)

else :

	cursor = conn.cursor()

def limpa_string(s, sep = '_') :

	nfkd = unicodedata.normalize('NFKD', s.strip())
	palavra = u''.join([c for c in nfkd if not unicodedata.combining(c)]).lower()

	regx = (" ",".","+","@","#","!","$","%","¨","&","*","(",")","_","-","+","=",";",":",",","\\","|","£","¢","¬","/","?","°","´","`","{","}","[","]","ª","º","~","^","\'","\"")

	str = re.sub('\W', '|', palavra)
	explode = str.split('|')

	output = []

	for i in explode :
		if ( i != '' ) :
			output.append(i)

	return sep.join(output)

'''
' Importação dos arquivos de escrituras de NFe
'''

DIR = os.path.join(os.getcwd() + os.sep + '..' + os.sep + 'storage' + os.sep + 'app' + os.sep + 'public' + os.sep + 'files' + os.sep + 'txt' + os.sep + 'escrituradas' + os.sep)

FILES = os.listdir(DIR)

def getLastId() :

	return ''

def issetNFe(linha) :

	campo = linha.split('|')

	sql = 'SELECT id FROM tb_lista_nfe WHERE chave_de_acesso = %s AND cod_prod = %s'

	cursor.execute(sql, (campo[0], campo[62]))
	v = cursor.fetchall()

	if cursor.rowcount == 0 :
		return False

	return True

def cadastarNFe(campos, linha) :

	if not issetNFe(linha) :

		campo = linha.split('|')

		print('cadastrando {} - {}'.format(campo[0], campo[62]))

		sql = 'INSERT INTO `tb_lista_nfe` ('
		sql += u','.join([c for c in campos])
		sql += ') VALUES ('

		values = []

		for n, i in enumerate(campo) :

			# Converter campo[3] (data_de_emissao) para o formato de data
			if n == 3 :
				date = i.split('/')
				i = date[2] + '-' + date[1] + '-' + date[0]

			values.append(i)
			sql += '%s'

			if ( n < len(campo) - 1 ) :
				sql += ','

		sql += ');'

		cursor.execute(sql, values)

		if cursor.rowcount > 0 :
			print('Campo {} - {} cadastrado com sucesso!'.format(campo[0], campo[62]))
			return True

	return False

for file in FILES :

	files = open(DIR + file, encoding='iso-8859-1')

	ln = files.readlines()

	campos = []

	reg = 0

	for linha_atual, linha in enumerate(ln) :

		if linha_atual == 0 :

			campo = linha.split('|')
			for n, i in enumerate(campo) :

				campos.append(limpa_string(i))

		if linha_atual != 0 :
			if cadastarNFe(campos, linha) :
				reg += 1

	if reg > 0 :
		conn.commit()
	else :
		conn.rollback()

files.close()
cursor.close()