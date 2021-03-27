#!/bin/bash

#####################################################################
# Função para executar Queries MySQL								#
#####################################################################

function Execute () {

	QUERY=$1

	mysql -e "$QUERY" --user=$USERNAME --password=$PASSWORD --database=$DATABASE

}

function Procedure_CadastraSpedfiscal() {

	# COD_VER=$(echo $SPED | cut -d '|' -f 2)
	# COD_FIN=$(echo $SPED | cut -d '|' -f 3)
	# DT_INI=$(echo $SPED | cut -d '|' -f 4)
	# DT_FIN=$(echo $SPED | cut -d '|' -f 5)
	# CNPJ=$(echo $SPED | cut -d '|' -f 7)
	# IND_PERFIL=$(echo $SPED | cut -d '|' -f 14)

	echo 'CREATE OR REPLACE PROCEDURE Cadastra_Contador(
		IN C_nome VARCHAR(100) CHARSET utf8,
		IN C_cpf VARCHAR(11) CHARSET utf8,
		IN C_crc VARCHAR(15) CHARSET utf8,
		IN C_cnpj VARCHAR(14) CHARSET utf8,
		IN C_cep VARCHAR(8) CHARSET utf8,
		IN C_logradouro VARCHAR(60) CHARSET utf8,
		IN C_numero VARCHAR(10) CHARSET utf8,
		IN C_complemento VARCHAR(60) CHARSET utf8,
		IN C_bairro VARCHAR(60) CHARSET utf8,
		IN C_fone VARCHAR(11) CHARSET utf8,
		IN C_fax VARCHAR(11) CHARSET utf8,
		IN C_email VARCHAR(255) CHARSET utf8,
		IN C_cod_mun VARCHAR(7) CHARSET utf8
	)
	BEGIN
		IF ( (SELECT COUNT(id) FROM tb_contabilista WHERE cpf = @cpf OR cnpj = @cnpj) = 0 )
		THEN
			INSERT INTO tb_contabilista (nome, cpf, crc, cnpj, cep, logradouro, numero, complemento, bairro, fone, fax, email, cod_mun)
			VALUES (
				C_nome,
				C_cpf,
				C_crc,
				C_cnpj,
				C_cep,
				C_logradouro,
				C_numero,
				C_complemento,
				C_bairro,
				C_fone,
				C_fax,
				C_email,
				C_cod_mun
			);
			SET @idContabilista=(SELECT LAST_INSERT_ID());
		ELSE
			SET @idContabilista=(SELECT id FROM tb_contabilista WHERE cpf = C_cpf OR cnpj = C_cnpj);
		END IF;
	END $$
	'

	echo 'CREATE OR REPLACE PROCEDURE Cadastra_Spedfiscal(
		INOUT S_cod_ver INT,
		IN S_cod_fin INT,
		IN S_dt_ini INT,
		IN S_dt_fin INT,
		IN S_cnpj_fornecedor VARCHAR(17) CHARSET utf8,
		IN S_id_contabilista INT,
		IN S_ind_perfil ENUM("A", "B", "C")
	)
	BEGIN
		IF ( (SELECT COUNT(id) FROM tb_spedfiscal WHERE dt_ini = S_dt_ini AND dt_fin = S_dt_fin AND cnpj_fornecedor = S_cnpj_fornecedor) = 0 )
		THEN
			INSERT INTO tb_spedfiscal (cnpj_fornecedor, id_contabilista, cod_ver, cod_fin, dt_ini, dt_fin, ind_perfil) VALUES (
				S_cnpj_fornecedor,
				@idContabilista,
				S_cod_ver,
				S_cod_fin,
				S_dt_ini,
				S_dt_fin,
				S_ind_perfil
			);
			SET @idSpedfiscal=(SELECT LAST_INSERT_ID());
		ELSE
			SET @idSpedfiscal=(SELECT id FROM tb_spedfiscal WHERE dt_ini = S_dt_ini AND dt_fin = S_dt_fin AND cnpj_fornecedor = S_cnpj_fornecedor);
		END IF;
	END $$
	'

}

function Procedure_CadastraFornecedor() {

	echo 'CREATE OR REPLACE PROCEDURE Cadastra_Fornecedor (
			IN F_cnpj VARCHAR(17) CHARSET utf8,
			IN F_nome VARCHAR(255) CHARSET utf8,
			IN F_xFant VARCHAR(255) CHARSET utf8,
			IN F_cPais VARCHAR(5) CHARSET utf8,
			IN F_cMun VARCHAR(7) CHARSET utf8,
			IN F_uf CHAR(2) CHARSET utf8,
			IN F_xBairro VARCHAR(60) CHARSET utf8,
			IN F_xLgr VARCHAR(255) CHARSET utf8,
			IN F_cep VARCHAR(8) CHARSET utf8,
			IN F_nro VARCHAR(11) CHARSET utf8,
			IN F_complemento VARCHAR(60) CHARSET utf8,
			IN F_fone VARCHAR(16) CHARSET utf8,
			IN F_fax VARCHAR(16) CHARSET utf8,
			IN F_email VARCHAR(255) CHARSET utf8,
			IN F_ie VARCHAR(20) CHARSET utf8,
			IN F_indIEDest INT,
			IN F_crt VARCHAR(11) CHARSET utf8,
			IN F_cpf VARCHAR(11) CHARSET utf8,
			IN F_im VARCHAR(20) CHARSET utf8,
			IN F_suframa VARCHAR(9) CHARSET utf8,
			IN F_ind_ativ INT
		)
		BEGIN

			IF ( F_cnpj <> "" ) THEN

				SET @fornecedor = (SELECT id FROM tb_fornecedor WHERE cnpj = F_cnpj);

			ELSEIF ( F_cpf <> "" ) THEN

				SET @fornecedor = (SELECT id FROM tb_fornecedor WHERE `cpf` = F_cpf);

			ELSEIF ( F_ie <> "" ) THEN

				SET @fornecedor = (SELECT id FROM tb_fornecedor WHERE `ie` = F_ie);

			END IF;

			IF @fornecedor IS NULL THEN

				INSERT INTO tb_fornecedor (cnpj, nome, xFant, cPais, cMun, uf, xBairro, xLgr, cep, nro, complemento, fone, fax, email, ie, indIEDest, crt, cpf, im, suframa, ind_ativ) VALUES (
					F_cnpj,
					F_nome,
					F_xFant,
					F_cPais,
					F_cMun,
					F_uf,
					F_xBairro,
					F_xLgr,
					F_cep,
					F_nro,
					F_complemento,
					F_fone,
					F_fax,
					F_email,
					F_ie,
					F_indIEDest,
					F_crt,
					F_cpf,
					F_im,
					F_suframa,
					F_ind_ativ
				);

				SET @idFornecedor=(SELECT LAST_INSERT_ID());

			ELSE

				SET @idFornecedor=@fornecedor;

			END IF;

		END $$'

}

function Procedure_NautrezaOperacao() {

	echo 'CREATE OR REPLACE PROCEDURE Cadastra_NaturezaOperacao	(
		IN N_cod VARCHAR(10) CHARSET utf8,
		IN N_descricao TEXT
	)
	BEGIN
		IF ( (SELECT COUNT(id) FROM tb_natureza_operacao WHERE cod_nat = N_cod) = 0 )
		THEN
			INSERT INTO tb_natureza_operacao (cod_nat, descr_nat) VALUES (
				N_cod,
				N_descricao
			);
		END IF;
	END $$
	'

}

function Procedure_UnidadesMedidas() {
	echo 'CREATE OR REPLACE PROCEDURE Cadastra_UnidadesMedidas(
		IN U_unidade VARCHAR(6) CHARSET utf8,
		IN U_descricao VARCHAR(100) CHARSET utf8
	)
	BEGIN

		SET @idUnidade = (SELECT id FROM tb_unidade_medida WHERE unidade = U_unidade);

		IF ( @idUnidade IS NULL ) THEN

			INSERT INTO tb_unidade_medida (unidade, descricao) VALUES (
				U_unidade,
				U_descricao
			);

			SET @idUnidadeMedida=(SELECT LAST_INSERT_ID());

		ELSE

			SET @idUnidadeMedida=(SELECT @idUnidade);

		END IF;

	END $$
	'
}

function Procedure_InformacaoComplementar() {

	echo 'CREATE OR REPLACE PROCEDURE Cadastra_InformacaoComplementar	(
		IN INF_codInformacao INT,
		IN INF_descricao TEXT
	)
	BEGIN
		IF ( (SELECT COUNT(id) FROM tb_informacao_complementar WHERE cod_inf = INF_codInformacao) = 0 ) THEN

			INSERT INTO tb_natureza_operacao (cod_nat, descr_nat) VALUES (
				INF_codInformacao,
				INF_descricao
			);

		END IF;

	END $$
	'

}

function Procedure_CadastraParticipante() {

	echo 'CREATE OR REPLACE PROCEDURE Cadastra_Participante (
			IN P_idSpedfiscal INT,
			IN P_idFornecedor INT,
			IN P_codPart VARCHAR(60) CHARSET utf8
		)
		BEGIN
			IF (( SELECT COUNT(id) FROM tb_spedfiscal_participante WHERE id_sped = P_idSpedfiscal AND id_fornecedor = P_idFornecedor AND cod_part = P_codPart ) = 0 ) THEN

				INSERT INTO tb_spedfiscal_participante (id_sped, id_fornecedor, cod_part) VALUES (
					P_idSpedfiscal,
					P_idFornecedor,
					P_codPart
				);

				SET @idParticipante=(SELECT LAST_INSERT_ID());

			ELSE

				SET @idParticipante=(SELECT id FROM tb_spedfiscal_participante WHERE id_sped = P_idSpedfiscal AND id_fornecedor = P_idFornecedor AND cod_part = P_codPart);

			END IF;
		END $$'

}

function Procedure_CadastraProduto() {

	echo 'CREATE OR REPLACE PROCEDURE Cadastra_Produto (
			IN P_codItem VARCHAR(60) CHARSET utf8,
			IN P_descricao VARCHAR(100) CHARSET utf8,
			IN P_codBarra VARCHAR(50) CHARSET utf8,
			IN P_codAntItem VARCHAR(6) CHARSET utf8,
			IN P_unidInv VARCHAR(6) CHARSET utf8,
			IN P_tipoItem INT(2) UNSIGNED ZEROFILL,
			IN P_codNcm VARCHAR(8) CHARSET utf8,
			IN P_exIpi VARCHAR(3) CHARSET utf8,
			IN P_codGen INT(2),
			IN P_codLst VARCHAR(5) CHARSET utf8,
			IN P_aliqICMS DECIMAL(6, 2),
			IN P_cest INT(7)
		)
		BEGIN

			IF P_codItem <> ""
			THEN

				SET @produto = (SELECT id FROM tb_produto WHERE cod_item = P_codItem);

			ELSEIF P_descricao <> ""
			THEN

				SET @produto = (SELECT id FROM tb_produto WHERE cod_item = P_descricao);

			END IF;

			IF @produto IS NULL THEN

				INSERT INTO tb_produto (cod_item, descricao, cod_barra, cod_ant_item, unidade_inv, tipo_item, cod_ncm, ex_ipi, cod_gen, cod_lst, aliquota_icms, cest) VALUES (
					P_codItem,
					P_descricao,
					P_codBarra,
					P_codAntItem,
					P_unidInv,
					P_tipoItem,
					P_codNcm,
					P_exIpi,
					P_codGen,
					P_codLst,
					P_aliqICMS,
					P_cest
				);

				SET @idProduto=(SELECT LAST_INSERT_ID());

			ELSE

				SET @idProduto=@produto;

			END IF;

		END $$'

}

function Procedure_CadastraProdutoConversao() {

	echo 'CREATE OR REPLACE PROCEDURE Cadastra_ProdutoConversao (
			IN P_idProduto INT,
			IN P_unidade VARCHAR(6) CHARSET utf8,
			IN P_fatorConversao DECIMAL(11, 6)
		)
		BEGIN

			IF ( (SELECT COUNT(id) FROM tb_produto_conversao WHERE id_produto = P_idProduto AND unidade = P_unidade) = 0 ) THEN

				INSERT INTO tb_produto_conversao (id_produto, unidade, fator_conversao) VALUES (
					P_idProduto,
					P_unidade,
					P_fatorConversao
				);

			END IF;

		END $$'

}

function Procedure_CadastraNFe() {

	echo 'CREATE OR REPLACE PROCEDURE Cadastra_NFe	(
		IN N_indOper CHAR(1) CHARSET utf8,
		IN N_indEmit CHAR(1) CHARSET utf8,
		IN N_codPart VARCHAR(60) CHARSET utf8,
		IN N_codMod VARCHAR(60) CHARSET utf8,
		IN N_codSit SMALLINT(2),
		IN N_serie VARCHAR(3) CHARSET utf8,
		IN N_numDoc INT(9),
		IN N_chvNFe CHAR(44) CHARSET utf8,
		IN N_dtDoc INT(8),
		IN N_dtES INT(8),
		IN N_vlDoc DECIMAL(11, 2),
		IN N_indPag CHAR(1) CHARSET utf8,
		IN N_vlDesc DECIMAL(11, 2),
		IN N_vlAbatNt DECIMAL(11, 2),
		IN N_indFrt CHAR(1) CHARSET utf8,
		IN N_vlFrt DECIMAL(11, 2),
		IN N_vlSeg DECIMAL(11, 2),
		IN N_vlOutDa DECIMAL(11, 2),
		IN N_vlBcICMS DECIMAL(11, 2),
		IN N_vlICMS DECIMAL(11, 2),
		IN N_vlBcIcmsSt DECIMAL(11, 2),
		IN N_vlIcmsSt DECIMAL(11, 2),
		IN N_vlIpi DECIMAL(11, 2),
		IN N_vlPis DECIMAL(11, 2),
		IN N_vlCofins DECIMAL(11, 2),
		IN N_vlPisSt DECIMAL(11, 2),
		IN N_vlCofinsSt DECIMAL(11, 2)
	)
	BEGIN

		SET @NFe = (SELECT id FROM tb_spedfiscal_nfe WHERE num_doc = N_numDoc AND chv_nfe = N_chvNFe);

		IF @NFe IS NULL THEN

			INSERT INTO tb_spedfiscal_nfe (id_sped, ind_oper, ind_emit, cod_part, cod_mod, cod_sit, ser, num_doc, chv_nfe, dt_doc, dt_e_s, vl_doc, ind_pgto, vl_desc, vl_abat_nt, ind_frt, vl_frt, vl_seg, vl_out_dia, vl_bc_icms, vl_icms, vl_bc_icms_st, vl_icms_cst, vl_ipi, vl_pis, vl_cofins, vl_pis_st, vl_cofins_st) VALUES (
				@idSpedfiscal,
				N_indOper,
				N_indEmit,
				N_codPart,
				N_codMod,
				N_codSit,
				N_serie,
				N_numDoc,
				N_chvNFe,
				N_dtDoc,
				N_dtES ,
				N_vlDoc,
				N_indPag,
				N_vlDesc,
				N_vlAbatNt,
				N_indFrt,
				N_vlFrt,
				N_vlSeg,
				N_vlOutDa,
				N_vlBcICMS,
				N_vlICMS,
				N_vlBcIcmsSt,
				N_vlIcmsSt,
				N_vlIpi,
				N_vlPis,
				N_vlCofins,
				N_vlPisSt,
				N_vlCofins
			);

			SET @idNFe=(SELECT LAST_INSERT_ID());
		ELSE

			SET @idNFe=@NFe;

		END IF;

	END $$
	'

}

function Procedure_NFe_InformacaoComplementar() {

	echo 'CREATE OR REPLACE PROCEDURE Cadastra_NFe_InformacaoComplementar	(
		IN INF_codInformacao VARCHAR(6) CHARSET utf8,
		IN INF_descricao TEXT
	)
	BEGIN
		IF ( (SELECT COUNT(id) FROM tb_spedfiscal_nfe_informacao_complementar WHERE cod_inf = INF_codInformacao) = 0 ) THEN

			INSERT INTO tb_spedfiscal_nfe_informacao_complementar (id_nfe, cod_inf, texto) VALUES (
				@idNFe,
				INF_codInformacao,
				INF_descricao
			);

		END IF;

	END $$
	'

}


function Procedure_NFe_Itens() {

	echo 'CREATE OR REPLACE PROCEDURE Cadastra_NFe_Itens (
		IN I_cod_item INT(11),
		IN I_num_item INT(3),
		IN I_qtd DECIMAL(11, 2),
		IN I_unid VARCHAR(6) CHARSET utf8,
		IN I_vl_item DECIMAL(11, 2),
		IN I_vl_desc DECIMAL(11, 2),
		IN I_ind_mov CHAR(1),
		IN I_cst_icms INT(3),
		IN I_cfop INT(4),
		IN I_cod_nat VARCHAR(10) CHARSET utf8,
		IN I_vl_bc_icms DECIMAL(11, 2),
		IN I_aliq_icms DECIMAL(11, 2),
		IN I_vl_icms DECIMAL(11, 2),
		IN I_vl_bc_icms_st DECIMAL(6, 2),
		IN I_aliq_st DECIMAL(6, 2),
		IN I_vl_icms_st DECIMAL(11, 2),
		IN I_ind_apur CHAR(1),
		IN I_cst_ipi VARCHAR(2) CHARSET utf8,
		IN I_cod_enq VARCHAR(3) CHARSET utf8,
		IN I_vl_bc_ipi DECIMAL(11, 2),
		IN I_aliq_ipi DECIMAL(6, 2),
		IN I_vl_ipi DECIMAL(11, 2),
		IN I_cst_pis INT(2),
		IN I_vl_bc_pis DECIMAL(11, 2),
		IN I_aliq_pis_percent DECIMAL(8, 4),
		IN I_quant_bc_pis DECIMAL(11, 3),
		IN I_aliq_pis_real DECIMAL(11, 4),
		IN I_vl_pis DECIMAL(11, 2),
		IN I_cst_cofins DECIMAL(11, 2),
		IN I_vl_bc_cofins DECIMAL(11, 2),
		IN I_aliq_cofins_percent DECIMAL(8, 4),
		IN I_quant_bc_cofins DECIMAL(11, 3),
		IN I_aliq_cofins_real DECIMAL(11, 4),
		IN I_vl_cofins DECIMAL(11, 2),
		IN I_cod_cta VARCHAR(11) CHARSET utf8,
		IN I_vl_abat_nt DECIMAL(11, 2)
	)
	BEGIN

		SET @itemNFe = (SELECT id FROM tb_spedfiscal_nfe_item WHERE id_nfe = @idNFe AND cod_item = I_cod_item);

		IF @itemNFe IS NULL THEN

			INSERT INTO tb_spedfiscal_nfe_item (
				id_nfe, cod_item, num_item, qtd, unid, vl_item, vl_desc, ind_mov, cst_icms, cfop, cod_nat, vl_bc_icms, aliq_icms, vl_icms, vl_bc_icms_st, aliq_st, vl_icms_st, ind_apur, cst_ipi, cod_enq, vl_bc_ipi, aliq_ipi, vl_ipi, cst_pis, vl_bc_pis, aliq_pis_percent, quant_bc_pis, aliq_pis_real, vl_pis, cst_cofins, vl_bc_cofins, aliq_cofins_percent, quant_bc_cofins, aliq_cofins_real, vl_cofins, cod_cta, vl_abat_nt
			) VALUES (
				@idNFe,
				I_cod_item,
				I_num_item,
				I_qtd,
				I_unid,
				I_vl_item,
				I_vl_desc,
				I_ind_mov,
				I_cst_icms,
				I_cfop,
				I_cod_nat,
				I_vl_bc_icms,
				I_aliq_icms,
				I_vl_icms,
				I_vl_bc_icms_st,
				I_aliq_st,
				I_vl_icms_st,
				I_ind_apur,
				I_cst_ipi,
				I_cod_enq,
				I_vl_bc_ipi,
				I_aliq_ipi,
				I_vl_ipi,
				I_cst_pis,
				I_vl_bc_pis,
				I_aliq_pis_percent,
				I_quant_bc_pis,
				I_aliq_pis_real,
				I_vl_pis,
				I_cst_cofins,
				I_vl_bc_cofins,
				I_aliq_cofins_percent,
				I_quant_bc_cofins,
				I_aliq_cofins_real,
				I_vl_cofins,
				I_cod_cta,
				I_vl_abat_nt
			);

			SET @idItemNFe=(SELECT LAST_INSERT_ID());

		ELSE

			SET @idItemNFe=@itemNFe;

		END IF;

	END $$
	'

}

function Procedures() {

	echo -e 'DELIMITER $$'

	echo -e $(Procedure_CadastraSpedfiscal)
	echo -e $(Procedure_CadastraFornecedor)
	echo -e $(Procedure_CadastraParticipante)
	echo -e $(Procedure_UnidadesMedidas)
	echo -e $(Procedure_CadastraProduto)
	echo -e $(Procedure_CadastraProdutoConversao)
	echo -e $(Procedure_NautrezaOperacao)
	echo -e $(Procedure_CadastraNFe)
	echo -e $(Procedure_NFe_InformacaoComplementar)
	echo -e $(Procedure_NFe_Itens)

	echo -e $PROCEDURES
	echo -e 'DELIMITER ;'

}