-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 19/02/2021 às 21:53
-- Versão do servidor: 5.7.33-0ubuntu0.18.04.1
-- Versão do PHP: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `reservas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `espaços`
--

CREATE TABLE `espaços` (
  `pk_espacos` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `localizacao` varchar(45) DEFAULT NULL,
  `capacidade` varchar(45) DEFAULT NULL,
  `aprovacao` int(11) DEFAULT NULL,
  `lista_espera` int(11) DEFAULT NULL,
  `foto` varchar(45) DEFAULT NULL,
  `termo_compromisso` text,
  `status` int(11) NOT NULL,
  `cor` varchar(10) NOT NULL,
  `grupo_gestor` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos`
--

CREATE TABLE `eventos` (
  `pk_eventos` int(11) NOT NULL,
  `titulo` varchar(90) DEFAULT NULL,
  `descricao` varchar(45) DEFAULT NULL COMMENT 'Não utilizado',
  `hr_ini` varchar(5) DEFAULT NULL,
  `hr_fim` varchar(5) DEFAULT NULL,
  `dt_ini` varchar(10) DEFAULT NULL,
  `dt_fim` varchar(10) DEFAULT NULL,
  `div_publico` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `permissao`
--

CREATE TABLE `permissao` (
  `pk_permissao` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `permissao`
--

INSERT INTO `permissao` (`pk_permissao`, `tipo`) VALUES
(1, 'Administrador'),
(2, 'Aprovador');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservas`
--

CREATE TABLE `reservas` (
  `pk_reservas` int(11) NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  `dt_hr_atualizacao` varchar(45) DEFAULT NULL,
  `contato` varchar(45) DEFAULT NULL,
  `secretaria` varchar(45) DEFAULT NULL,
  `ramal` varchar(45) DEFAULT NULL,
  `fk_espacos` int(11) NOT NULL,
  `fk_eventos` int(11) NOT NULL,
  `fk_glpi_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `user_permissao`
--

CREATE TABLE `user_permissao` (
  `pk_user_permissao` int(11) NOT NULL,
  `fk_glpi_users` int(11) NOT NULL,
  `fk_permissao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `user_permissao`
--

INSERT INTO `user_permissao` (`pk_user_permissao`, `fk_glpi_users`, `fk_permissao`) VALUES
(1, 21, 1),
(3, 47, 1),
(4, 13, 0),
(5, 31, 1);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `espaços`
--
ALTER TABLE `espaços`
  ADD PRIMARY KEY (`pk_espacos`);

--
-- Índices de tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`pk_eventos`);

--
-- Índices de tabela `permissao`
--
ALTER TABLE `permissao`
  ADD PRIMARY KEY (`pk_permissao`);

--
-- Índices de tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`pk_reservas`);

--
-- Índices de tabela `user_permissao`
--
ALTER TABLE `user_permissao`
  ADD PRIMARY KEY (`pk_user_permissao`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `espaços`
--
ALTER TABLE `espaços`
  MODIFY `pk_espacos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `pk_eventos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `permissao`
--
ALTER TABLE `permissao`
  MODIFY `pk_permissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `pk_reservas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `user_permissao`
--
ALTER TABLE `user_permissao`
  MODIFY `pk_user_permissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
