-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 02-Jun-2022 às 14:51
-- Versão do servidor: 5.7.18-log
-- versão do PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Estrutura da tabela `alternativa`
--

CREATE TABLE `alternativa` (
  `pk_alternativa` int(11) NOT NULL,
  `texto` varchar(100) NOT NULL,
  `pontuacao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `enunciado`
--

INSERT INTO `alternativa` (`pk_alternativa`, `texto`, `pontuacao`) VALUES
(1, 'Muito Insatisfeito', 1),
(2, 'Insatisfeito', 2),
(3, 'Neutro', 3),
(4, 'Satisfeito', 4),
(5, 'Muito Satisfeito', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `enunciado`
--

CREATE TABLE `enunciado` (
  `pk_enunciado` int(11) NOT NULL,
  `enunciado` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `enunciado`
--

INSERT INTO `enunciado` (`pk_enunciado`, `enunciado`) VALUES
(1, 'Conforto do Lounge:\r\nAvalie sua satisfação quanto ao conforto do Lounge.'),
(2, 'Limpeza e Organização do Lounge:\r\nAvalie sua satisfação quanto a limpeza e organização do Lounge.'),
(3, 'Nichos para reuniões:\r\nAvalie sua satisfação quanto aos nichos para reuniões.'),
(4, 'Máquinas automáticas:\r\nAvalie sua satisfação quanto as máquinas automáticas de venda de doces, salgados e cafés.'),
(5, 'Facilidades do Lounge:\r\nAvalie sua satisfação quanto as facilidades do Lounge, tais como wi-fi, tomadas para carregamento de equipamentos e etc.'),
(6, 'Acessibilidade do Lounge:\r\nAvalie sua satisfação quanto a acessibilidade disponível para acesso ao Lounge.'),
(7, 'Satisfação geral com o Lounge:\r\nAvalie sua satisfação geral quanto ao Lounge do CAFFWorking.'),
(8, 'Conforto das salas:\r\nAvalie sua satisfação quanto ao conforto do Lounge.'),
(9, 'Limpeza e Organização das salas:\r\nAvalie sua satisfação quanto a limpeza e organização do Lounge.'),
(10, 'Tecnologia Webex:\r\nAvalie sua satisfação quanto a tecnologia Webex empregada nas salas de reuniões.'),
(11, 'Disponibilidade das salas:\r\nAvalie sua satisfação quanto a disponibilidade das salas de reuniões para reserva.'),
(12, 'Sistema de Reserva de salas:\r\nAvalie sua satisfação quanto ao sistema de reservas das salas de reuniões do CAFFWorking.'),
(13, 'Acessibilidade das salas de reuniões:\r\nAvalie sua satisfação quanto a acessibilidade disponível para acesso as salas de reuniões.'),
(14, 'Satisfação geral com as salas de reuniões:\r\nAvalie sua satisfação geral quanto as salas de reuniões do CAFFWorking.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `espaços`
--

ALTER TABLE `espaços` ADD `satisfacao_status` INT(11) NOT NULL DEFAULT '0' ;
ALTER TABLE `espaços` ADD `titulo_satisfacao` VARCHAR(100) NOT NULL DEFAULT 'Pesquisa de Satisfação' ;
ALTER TABLE `espaços` ADD `texto_satisfacao` VARCHAR(1000) NOT NULL DEFAULT 'Prezado (a) Usuário (a)<br><br>Convidamo-os a participar da pesquisa de satisfação da sua experiência com o espaço do CAFF. <br><br>Com a sua participação será possível mensurar o contentamento com o espaço e com as facilidades disponibilizadas para a realização de reuniões virtuais e videoconferências para todos os servidores do Rio Grande do Sul.' ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservas`
--

ALTER TABLE `reservas` ADD `email` VARCHAR(100) NULL ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `resposta`
--

CREATE TABLE `resposta` (
  `pk_resposta` int(11) NOT NULL,
  `fk_alternativa` int(11) NOT NULL,
  `fk_enunciado` int(11) NOT NULL,
  `fk_satisfacao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `satisfacao`
--

CREATE TABLE `satisfacao` (
  `pk_satisfacao` int(11) NOT NULL,
  `fk_reservas` int(11) NOT NULL,
  `hash` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `satisfacao_parametros`
--

CREATE TABLE `satisfacao_parametros` (
  `pk_parametros_satisfacao` int(11) NOT NULL,
  `fk_espacos` int(11) NOT NULL,
  `fk_enunciado` int(11) NOT NULL,
  `status_enunciado` INT(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `alternativa`
--
ALTER TABLE `alternativa`
  ADD PRIMARY KEY (`pk_alternativa`);

--
-- Índices para tabela `enunciado`
--
ALTER TABLE `enunciado`
  ADD PRIMARY KEY (`pk_enunciado`);

--
-- Índices para tabela `resposta`
--
ALTER TABLE `resposta`
  ADD PRIMARY KEY (`pk_resposta`);

--
-- Índices para tabela `satisfacao`
--
ALTER TABLE `satisfacao`
  ADD PRIMARY KEY (`pk_satisfacao`);

--
-- Índices para tabela `satisfacao_parametros`
--
ALTER TABLE `satisfacao_parametros`
  ADD PRIMARY KEY (`pk_parametros_satisfacao`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alternativa`
--
ALTER TABLE `alternativa`
  MODIFY `pk_alternativa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `enunciado`
--
ALTER TABLE `enunciado`
  MODIFY `pk_enunciado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `resposta`
--
ALTER TABLE `resposta`
  MODIFY `pk_resposta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `satisfacao`
--
ALTER TABLE `satisfacao`
  MODIFY `pk_satisfacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `satisfacao_parametros`
--
ALTER TABLE `satisfacao_parametros`
  MODIFY `pk_parametros_satisfacao` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
