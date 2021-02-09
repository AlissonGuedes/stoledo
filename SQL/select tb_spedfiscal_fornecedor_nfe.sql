SELECT COUNT(*) FROM tb_nfe N LEFT JOIN tb_spedfiscal_nfe S ON S.chv_nfe = N.chNFe LEFT JOIN tb_spedfiscal_participante P ON P.id_sped = S.id LEFT JOIN tb_fornecedor F ON F.cnpj = N.cEmi
