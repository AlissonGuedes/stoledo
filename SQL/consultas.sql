/**
 * Contagem de registros por restrição de chave de acesso e código do produto
 */
SELECT DISTINCT
	(SELECT count(cod_prod) FROM tb_lista_nfe WHERE cod_prod = nf.cod_prod) as cod_prod,
	chave_de_acesso,
	cod_prod,
	descricao_do_produto_ou_servicos
FROM	`tb_lista_nfe` as nf
WHERE
	cod_prod IN (
		SELECT cod_prod FROM tb_lista_nfe WHERE chave_de_acesso = nf.chave_de_acesso
		AND	id = nf.id
	)
ORDER BY id DESC;

/**
 * Selecionar todos os registros do arquivo `lista NFe` pelo código do produto.
 */

SELECT cod_prod, chave_de_acesso descricao_do_produto_ou_servicos from tb_lista_nfe where cod_prod = '00312';

/**
 * Consulta inválida. Leva muito tempo para ser executada e não retorna nenhum resultado.
 */
-- SELECT DISTINCT chave_de_acesso from tb_lista_nfe as n left join tb_spedfiscal_nfe as s on s.chv_nfe = n.chave_de_acesso WHERE n.chave_de_acesso NOT IN (SELECT s.chv_nfe FROM tb_spedfiscal_nfe );

/**
 * LISTAR TODAS AS NOTAS NÃO ESCRITURADAS. EXPLICAÇÃO:
 * 	Selecionar todas as notas fiscais do arquivo `lista NFe` em que a chave de acesso não esteja no arquivo de SPED.
 */

SELECT DISTINCT chave_de_acesso from tb_lista_nfe as n WHERE n.chave_de_acesso NOT IN (SELECT chv_nfe FROM tb_spedfiscal_nfe);

