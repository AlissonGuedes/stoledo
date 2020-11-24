-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 24-Nov-2020 às 06:37
-- Versão do servidor: 10.3.25-MariaDB-0ubuntu0.20.04.1
-- versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `stoledo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_bairro`
--

CREATE TABLE `tb_bairro` (
  `cBairro` int(11) NOT NULL,
  `xBairro` int(11) NOT NULL,
  `cMun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_config`
--

CREATE TABLE `tb_config` (
  `id` int(11) NOT NULL,
  `config` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_fornecedor`
--

CREATE TABLE `tb_fornecedor` (
  `id` int(11) NOT NULL,
  `cnpj` int(11) NOT NULL,
  `nome` int(11) NOT NULL,
  `cLgr` int(11) NOT NULL,
  `nro` int(11) NOT NULL,
  `fone` int(11) NOT NULL,
  `ie` int(11) NOT NULL,
  `crt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_icms`
--

CREATE TABLE `tb_icms` (
  `id` int(11) NOT NULL,
  `orig` int(11) NOT NULL,
  `cst` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_logradouro`
--

CREATE TABLE `tb_logradouro` (
  `cLgr` int(11) NOT NULL,
  `xLgr` int(11) NOT NULL,
  `cep` int(11) NOT NULL,
  `cBairro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_municipio`
--

CREATE TABLE `tb_municipio` (
  `cMun` int(11) NOT NULL,
  `xMun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_nfe`
--

CREATE TABLE `tb_nfe` (
  `id` int(11) NOT NULL,
  `versao` int(11) NOT NULL,
  `versao2` int(11) NOT NULL,
  `cUF` int(11) NOT NULL,
  `cNF` int(11) NOT NULL,
  `natOp` int(11) NOT NULL,
  `mod` int(11) NOT NULL,
  `serie` int(11) NOT NULL,
  `nNF` int(11) NOT NULL,
  `dhEmi` int(11) NOT NULL,
  `dhSaiEnt` int(11) NOT NULL,
  `tpNF` int(11) NOT NULL,
  `idDest` int(11) NOT NULL,
  `cMunFG` int(11) NOT NULL,
  `tpImp` int(11) NOT NULL,
  `tpEmis` int(11) NOT NULL,
  `cDV` int(11) NOT NULL,
  `tpAmb` int(11) NOT NULL,
  `finNFe` int(11) NOT NULL,
  `indFinal` int(11) NOT NULL,
  `indPres` int(11) NOT NULL,
  `procEmi` int(11) NOT NULL,
  `verProc` int(11) NOT NULL,
  `cEmi` int(11) NOT NULL COMMENT 'Código do Emitente. Chave estrangeira referente à tabela `tb_fornecedor` (id)',
  `cDest` int(11) NOT NULL COMMENT 'Código do destinatário. Chave estrangeira da tabela referente à tabela `tb_fornecedor` (id)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_nfe_item`
--

CREATE TABLE `tb_nfe_item` (
  `nItem` int(11) NOT NULL,
  `cProd` int(11) NOT NULL,
  `qCom` int(11) NOT NULL,
  `vProd` int(11) NOT NULL,
  `cEANTrib` int(11) NOT NULL,
  `uTrib` int(11) NOT NULL,
  `qTrib` int(11) NOT NULL,
  `vUnTrib` int(11) NOT NULL,
  `indTot` int(11) NOT NULL,
  `xPed` int(11) NOT NULL,
  `nItemPed` int(11) NOT NULL,
  `vTotTrib` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pais`
--

CREATE TABLE `tb_pais` (
  `cPais` int(11) NOT NULL,
  `xPais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produto`
--

CREATE TABLE `tb_produto` (
  `id` int(11) NOT NULL,
  `cProd` int(11) NOT NULL,
  `cEAN` int(11) NOT NULL,
  `xProd` int(11) NOT NULL,
  `ncm` int(11) NOT NULL,
  `cest` int(11) NOT NULL,
  `indEscala` int(11) NOT NULL,
  `cfop` int(11) NOT NULL,
  `uCom` int(11) NOT NULL,
  `vUnCom` int(11) NOT NULL,
  `vProd` int(11) NOT NULL,
  `cEANTrib` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_uf`
--

CREATE TABLE `tb_uf` (
  `cUf` int(11) NOT NULL,
  `uf` int(11) NOT NULL,
  `cPais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_config`
--
ALTER TABLE `tb_config`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_config`
--
ALTER TABLE `tb_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
