SELECT cEmi, cDest, count(cEmi) as total, (select nome from tb_fornecedor where cnpj = cDest) as nome FROM `tb_nfe` 
where cEmi = 03524990000155
GROUP BY cEmi
ORDER BY `tb_nfe`.`cDest`  DESC
