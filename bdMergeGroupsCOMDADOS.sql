-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27-Abr-2021 às 03:24
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `reservasteste`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `espaços`
--

CREATE TABLE `espaços` (
  `pk_espacos` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `localizacao` varchar(45) DEFAULT NULL,
  `capacidade` varchar(45) DEFAULT NULL,
  `aprovacao` int(11) DEFAULT NULL,
  `lista_espera` int(11) DEFAULT NULL,
  `foto` varchar(45) DEFAULT NULL,
  `termo_compromisso` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `cor` varchar(10) NOT NULL,
  `grupo_gestor` varchar(45) DEFAULT NULL,
  `grupo_salas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `espaços`
--

INSERT INTO `espaços` (`pk_espacos`, `nome`, `localizacao`, `capacidade`, `aprovacao`, `lista_espera`, `foto`, `termo_compromisso`, `status`, `cor`, `grupo_gestor`, `grupo_salas`) VALUES
(27, 'Auditório CAFF Working', '1º Andar', '200', 1, 1, '', 'Sim', 1, '#b7c62f', '1', 1),
(28, 'Berga', '18º andar', '500', 1, 1, '', 'Sim', 1, '#4fdeba', '1', 2),
(29, 'Auditório do CAFF (Térreo)', 'Auditório do CAFF (Térreo)', '200', 1, 1, '', 'Equipamentos: Computador, tela e projeção, som, microfones com fio', 1, '#445a56', '1', 2),
(30, 'Sala 7: Findi', 'CAFF Working (19º andar)', '10', 1, 1, '', 'Equipamentos: sistema Webex', 1, '#c991cf', '1', 1),
(31, 'Sala 1: Bah', 'CAFF Working (19º andar)', '28', 1, 1, '', 'Equipamentos: sistema Webex.', 1, '#5cd33c', '1', 1),
(32, 'Sala 2: Tche', 'CAFF Working (19º andar)', '28', 1, 1, '', 'Equipamentos: sistema Webex', 0, '#6e3fc6', '1', 1),
(33, 'Sala 3: Tri', 'CAFF Working (19º andar)', '10', 1, 1, '', 'Equipamentos: sistema Webex', 0, '#f91664', '1', 1),
(34, 'Auditório 20º ', 'Auditório do 20º andar', '200', 1, 1, '', 'Webex', 0, '#8cef0b', '1', 2),
(35, 'Auditório Térreo Norte ', 'Norte', '50', 1, 1, '', 'Webex', 1, '#deabc6', '1', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE `eventos` (
  `pk_eventos` int(11) NOT NULL,
  `titulo` varchar(90) DEFAULT NULL,
  `descricao` varchar(45) DEFAULT NULL COMMENT 'Não utilizado',
  `hr_ini` varchar(5) DEFAULT NULL,
  `hr_fim` varchar(5) DEFAULT NULL,
  `dt_ini` varchar(10) DEFAULT NULL,
  `dt_fim` varchar(10) DEFAULT NULL,
  `div_publico` int(11) DEFAULT NULL,
  `select_webex` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `eventos`
--

INSERT INTO `eventos` (`pk_eventos`, `titulo`, `descricao`, `hr_ini`, `hr_fim`, `dt_ini`, `dt_fim`, `div_publico`, `select_webex`) VALUES
(1, 'Reunião de Incio do Reservas', 'Pensar na descrição', '14:54', '16:54', '2021-04-05', 'NULL', 0, NULL),
(2, 'CELIC', 'Pensar na descrição', '08:30', '17:30', '2021-04-06', 'NULL', 0, NULL),
(3, 'Leilão Celic', 'Pensar na descrição', '14:00', '17:00', '2021-04-06', 'NULL', 1, NULL),
(4, 'Leilão Celic', 'Pensar na descrição', '14:00', '17:00', '2021-04-13', 'NULL', 1, NULL),
(5, 'CELIC', 'Pensar na descrição', '08:30', '17:30', '2021-04-13', 'NULL', 0, NULL),
(6, 'Leilão Celic', 'Pensar na descrição', '14:00', '17:00', '2021-04-15', 'NULL', 1, NULL),
(7, 'Leilão Celic', 'Pensar na descrição', '14:00', '17:00', '2021-04-20', 'NULL', 1, NULL),
(8, 'CELIC', 'Pensar na descrição', '08:30', '17:30', '2021-04-15', 'NULL', 0, NULL),
(9, 'Leilão Celic', 'Pensar na descrição', '14:00', '17:00', '2021-04-22', 'NULL', 1, NULL),
(10, 'CELIC', 'Pensar na descrição', '08:30', '17:30', '2021-04-20', 'NULL', 0, NULL),
(11, 'Leilão Celic', 'Pensar na descrição', '14:00', '17:00', '2021-04-27', 'NULL', 1, NULL),
(12, 'Leilão Celic', 'Pensar na descrição', '14:00', '17:00', '2021-04-29', 'NULL', 1, NULL),
(13, 'CELIC', 'Pensar na descrição', '08:30', '17:30', '2021-04-22', 'NULL', 0, NULL),
(14, 'CELIC', 'Pensar na descrição', '08:30', '17:30', '2021-04-27', 'NULL', 0, NULL),
(15, 'CELIC', 'Pensar na descrição', '08:30', '17:30', '2021-04-29', 'NULL', 0, NULL),
(16, 'CELIC', 'Pensar na descrição', '14:00', '17:00', '2021-04-08', 'NULL', 0, NULL),
(17, 'Reunião Planejamento Futuro', 'Pensar na descrição', '14:00', '16:00', '2021-04-07', 'NULL', 0, NULL),
(18, 'reserva ', 'Pensar na descrição', '17:00', '18:00', '2021-04-07', 'NULL', 0, NULL),
(19, 'Reunião Planejamento Futuro', 'Pensar na descrição', '14:00', '16:00', '2021-04-09', 'NULL', 0, NULL),
(20, 'Reunião Planejamento Futuro', 'Pensar na descrição', '08:00', '09:30', '2021-04-28', 'NULL', 0, NULL),
(21, 'Reunião Planejamento Futuro', 'Pensar na descrição', '10:00', '12:00', '2021-04-29', 'NULL', 0, NULL),
(22, 'Reunião Planejamento Futuro', 'Pensar na descrição', '16:00', '18:00', '2021-04-29', 'NULL', 0, NULL),
(23, 'Reunião Planejamento Futuro', 'Pensar na descrição', '11:00', '12:30', '2021-04-27', 'NULL', 1, NULL),
(24, 'Teste', 'Pensar na descrição', '12:58', '15:02', '2021-04-12', 'NULL', 1, NULL),
(25, 'Reunião equipe de Infra e Dev DINFO (Não é necessário agendamento no webex)', 'Pensar na descrição', '10:00', '12:00', '2021-04-12', 'NULL', 0, NULL),
(26, 'dinfop', 'Pensar na descrição', '10:00', '12:00', '2021-04-12', 'NULL', 1, NULL),
(27, 'Dinfo', 'Pensar na descrição', '10:00', '12:00', '2021-04-12', 'NULL', 1, NULL),
(28, 'Setur', 'Pensar na descrição', '09:30', '11:00', '2021-04-13', 'NULL', 1, NULL),
(29, 'Reunião no sistema cisco webex', 'Pensar na descrição', '10:00', '11:30', '2021-04-13', 'NULL', 0, NULL),
(30, 'SEPLAG ', 'Pensar na descrição', '11:00', '12:00', '2021-04-14', 'NULL', 1, NULL),
(31, 'Turismo ', 'Pensar na descrição', '09:30', '10:30', '2021-04-13', 'NULL', 1, NULL),
(32, 'SEPLAG DEAP', 'Pensar na descrição', '14:00', '15:00', '2021-04-13', 'NULL', 1, NULL),
(33, 'Treinamento CISCO para DINFO', 'Pensar na descrição', '15:30', '17:00', '2021-04-13', 'NULL', 0, NULL),
(34, 'SPPG', 'Pensar na descrição', '17:00', '18:00', '2021-04-13', 'NULL', 1, NULL),
(35, 'Teste2', 'Pensar na descrição', '10:00', '12:00', '2021-04-26', '2021-04-28', 0, NULL),
(36, 'Teste', 'Pensar na descrição', '10:00', '10:12', '2021-04-26', 'NULL', 1, NULL),
(37, 'Teste', 'Pensar na descrição', '10:00', '12:00', '2021-04-26', '2021-04-27', 1, NULL),
(38, 'sad', 'Pensar na descrição', '10:00', '12:00', '2021-04-27', 'NULL', 0, NULL),
(39, 'Dale', 'Pensar na descrição', '10:00', '12:00', '2021-05-01', 'NULL', 1, NULL),
(40, 'sadsa', 'Pensar na descrição', '10:00', '12:00', '2021-04-29', 'NULL', 0, NULL),
(41, 'Reunião Topp', 'Pensar na descrição', '10:00', '12:00', '2021-04-26', 'NULL', 0, NULL),
(42, 'Reunião TI1', 'Pensar na descrição', '', '', '', '', 0, NULL),
(43, 'Teste', 'Pensar na descrição', '09:00', '11:00', '2021-04-27', '2021-04-30', 1, NULL),
(44, 'Reunião dos guri2', 'Pensar na descrição', '10:00', '11:00', '2021-04-28', '2021-04-29', 0, 'Não'),
(45, 'Reunião TI', 'Pensar na descrição', '10:00', '11:00', '2021-04-27', 'NULL', 0, 'Sim'),
(46, 'Reunião dos guri', 'Pensar na descrição', '10:00', '12:00', '2021-04-27', '2021-04-30', 1, 'Não');

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissao`
--

CREATE TABLE `permissao` (
  `pk_permissao` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `permissao`
--

INSERT INTO `permissao` (`pk_permissao`, `tipo`) VALUES
(1, 'Administrador'),
(2, 'Aprovador');

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservas`
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

--
-- Extraindo dados da tabela `reservas`
--

INSERT INTO `reservas` (`pk_reservas`, `status`, `dt_hr_atualizacao`, `contato`, `secretaria`, `ramal`, `fk_espacos`, `fk_eventos`, `fk_glpi_users`) VALUES
(44, 'Confirmada', '2021-04-26 22:08:10', 'Marlon Dietrich', 'seplag', '51996707829', 27, 44, 21),
(45, 'Confirmada', '2021-04-26 22:10:58', 'Marlon Dietrich', 'seplag', '51996707829', 30, 45, 21),
(46, 'Confirmada', '2021-04-26 22:23:48', 'Marlon Dietrich', 'seplag', '51996707829', 35, 46, 21);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_permissao`
--

CREATE TABLE `user_permissao` (
  `pk_user_permissao` int(11) NOT NULL,
  `fk_glpi_users` int(11) NOT NULL,
  `fk_permissao` int(11) NOT NULL,
  `grupo_salas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `user_permissao`
--

INSERT INTO `user_permissao` (`pk_user_permissao`, `fk_glpi_users`, `fk_permissao`, `grupo_salas`) VALUES
(1, 21, 1, 1),
(3, 47, 1, 1),
(4, 13, 0, 1),
(5, 31, 2, 2),
(6, 76, 1, 2),
(7, 99, 1, 2),
(8, 75, 1, 2),
(9, 79, 1, 2),
(10, 72, 1, 2),
(11, 134, 2, 2),
(12, 97, 1, 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `espaços`
--
ALTER TABLE `espaços`
  ADD PRIMARY KEY (`pk_espacos`);

--
-- Índices para tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`pk_eventos`);

--
-- Índices para tabela `permissao`
--
ALTER TABLE `permissao`
  ADD PRIMARY KEY (`pk_permissao`);

--
-- Índices para tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`pk_reservas`);

--
-- Índices para tabela `user_permissao`
--
ALTER TABLE `user_permissao`
  ADD PRIMARY KEY (`pk_user_permissao`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `espaços`
--
ALTER TABLE `espaços`
  MODIFY `pk_espacos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `pk_eventos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `permissao`
--
ALTER TABLE `permissao`
  MODIFY `pk_permissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `pk_reservas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `user_permissao`
--
ALTER TABLE `user_permissao`
  MODIFY `pk_user_permissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
