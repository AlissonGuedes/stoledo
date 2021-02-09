SELECT p.descricao, p.cod_item, i.unidade, i.id_produto FROM `tb_produto` as  `p`, `tb_produto_conversao` as i where p.id = i.id_produto and p.cod_item = '00000000002504' ORDER BY `id_produto` ASC
