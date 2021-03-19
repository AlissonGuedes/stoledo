import os
import sys
from mysql.connector import connect, Error
from datetime import datetime, timedelta

try:
	conn = connect(host='localhost', user='alissong_stoledo',
				password='5r6kLdALaGlU', database='alissong_stoledo', raw=False)
	print('Connection established')
except Error:
	print(Error)
else:
	cursor = conn.cursor()

# func = sys.argv[1]
# registro = sys.argv[2].split('|')

def insertContador(contador):

	# verificar se existe o contador cadastrado pelo cpf ou pelo cnpj
	query = 'SELECT id FROM tb_contabilista WHERE cpf = "{}" OR cnpj = "{}";'.format(contador[2], contador[4])
	# cursor.execute(query)
	# id_contador = cursor.fetchall()

	# return id_contador

	# if cursor.rowcount == 0:

	# 	query = 'INSERT INTO tb_contabilista (nome, cpf, crc, cnpj, cep, logradouro, numero, complemento, bairro, fone, fax, email, cod_mun) \
	# 				VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);'
	# 	values = (contador[1], contador[2], contador[3], contador[4], contador[5], contador[6],
	# 			contador[7], contador[8], contador[9], contador[10], contador[11], contador[12], contador[13])

	# 	# print(query %(values))
	# 	cursor.execute(query, values)
	# 	conn.commit()

	# 	query = 'select last_insert_id();'
	# 	cursor.execute(query)
	# 	v = cursor.fetchall()

	# 	id_contador = getLastId()

	# else:

	# 	id_contador = ('%s' % (id_contador[0]))

	# return id_contador

# if ln[0] == '0100' :

# 	print(insertContador(ln))
