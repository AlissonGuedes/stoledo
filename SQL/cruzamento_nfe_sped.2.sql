
-- --------------------------------------------------------------------------------
SELECT

	f.cnpj,
	f.nome,
	n.chv_nfe

FROM
	`tb_spedfiscal_participante` p
	
left join	tb_fornecedor		f on f.id		= p.id_fornecedor
left join	tb_spedfiscal_nfe	n on n.cod_part	= p.cod_part
inner join	tb_lista_nfe		l on l.chave_de_acesso	= n.chv_nfe and
			replace(replace(replace(l.cpf_cnpj_emit, '-', ''), '.', ''), '/', '') = f.cnpj

group by f.cnpj, n.chv_nfe

order by f.nome

limit 100
-- --------------------------------------------------------------------------------

-- --------------------------------------------------------------------------------
select DISTINCT `chv_nfe` from `tb_spedfiscal_participante` as `P` left join `tb_fornecedor` as `F` on `F`.`id` = `P`.`id_fornecedor` inner join `tb_spedfiscal_nfe` as `N` on (`N`.`cod_part` = `P`.`cod_part` and `F`.`id` = `P`.`id_fornecedor`) 
-- left join `tb_lista_nfe` as `L` on replace(replace(replace(L.cpf_cnpj_emit, "-", ""), ".", ""), "/", "") = `F`.`cnpj`

where `F`.`cnpj` = '75315333011496' and N.chv_nfe not in (select chave_de_acesso from tb_lista_nfe

 WHERE chave_de_acesso = N.chv_nfe and replace(replace(replace(cpf_cnpj_emit, "-", ""), ".", ""), "/", "") = F.cnpj) 
-- --------------------------------------------------------------------------------

-- --------------------------------------------------------------------------------
select distinct `chave_de_acesso`

from `tb_lista_nfe` as `NFE` where `chave_de_acesso` in

(select `chv_nfe` from `tb_spedfiscal_nfe` where `chv_nfe` = `NFE`.`chave_de_acesso` and `chv_nfe` is null)
-- --------------------------------------------------------------------------------

