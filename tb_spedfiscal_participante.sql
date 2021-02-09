-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 09-Fev-2021 às 13:23
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
-- Estrutura da tabela `tb_spedfiscal_participante`
--

CREATE TABLE `tb_spedfiscal_participante` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_sped` int(11) UNSIGNED NOT NULL,
  `id_fornecedor` int(11) UNSIGNED NOT NULL,
  `cod_part` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_spedfiscal_participante`
--
ALTER TABLE `tb_spedfiscal_participante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_spedfiscal_id_fornecedor` (`id_fornecedor`),
  ADD KEY `id_sped` (`id_sped`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_spedfiscal_participante`
--
ALTER TABLE `tb_spedfiscal_participante`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_spedfiscal_participante`
--
ALTER TABLE `tb_spedfiscal_participante`
  ADD CONSTRAINT `fk_tb_spedfiscal_id_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `tb_fornecedor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
