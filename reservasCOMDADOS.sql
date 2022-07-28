-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 19-Fev-2021 às 16:54
-- Versão do servidor: 5.7.18-log
-- versão do PHP: 7.0.33

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
  `termo_compromisso` text,
  `status` int(11) NOT NULL,
  `cor` varchar(10) NOT NULL,
  `grupo_gestor` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `espaços`
--

INSERT INTO `espaços` (`pk_espacos`, `nome`, `localizacao`, `capacidade`, `aprovacao`, `lista_espera`, `foto`, `termo_compromisso`, `status`, `cor`, `grupo_gestor`) VALUES
(1, 'Auditorio 20ºandar', '20º andar do Caff', '80', 1, 1, '', 'sim', 1, '#3d26ed', '1'),
(2, 'Auditório 1ºandar', '1º Andar do Caff', '300', 1, 1, '', 'sim', 1, '#00ffe1', '1'),
(4, 'Casa', 'primeiro andar', '30', 1, 1, '', 'teste', 1, '#501144', '1'),
(27, 'Deserto', 'No leste da palestina', '100000', 1, 1, '', 'teste', 2, '#c4b428', '1'),
(28, 'Teste', '1º Andar', '999999999999999999999999999999999999', 1, 1, '', 'fhsadljjjjjjjjjjjjjjjjjjjjaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaafdjadfjfasdklçkasdfkasdfkjfasdksdfajjhklghkjgfghdfjfuioAKJGDSHJGFGHKJASDFHIOEFUIOTIWEHOGHIOÇRHIOÇGHIRAEHIOÇGHIOÇEWHIOÇGEHIOÇWGHIOÇHIOÇweghewhioçGhioçwhioEHIOWGHIOewhighioewghoçewhogfhWEIOÇFHIOEhgfeHIOÇGHIOÇEWGHIOÇEWHIOGFHIOWEGHIEwhiogehigiewhighiewhigHIOWEG', 1, '#000000', '1'),
(29, 'Teste2', '20º Andar', '2', 1, 1, '', 'NULL', 2, '#26ff00', '1'),
(30, 'Auditório 2º Andar', '2º Andar', '500', 1, 1, '', 'Sim.', 1, '#ff0505', '1'),
(31, 'Auditório ', 'Térreo', '25', 1, 1, '', 'Sim', 1, '#73731c', '1'),
(32, 'fdfdg', 'dfgdfg', '123', 1, 1, '', 'sfdfgdgdfgdfgdfgdfgfg', 1, '#537d0c', '1');

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
  `div_publico` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `eventos`
--

INSERT INTO `eventos` (`pk_eventos`, `titulo`, `descricao`, `hr_ini`, `hr_fim`, `dt_ini`, `dt_fim`, `div_publico`) VALUES
(1, 'teste', 'Pensar na descrição', '14:22', 'NULL', '2020-12-04', NULL, 0),
(3, 'teste', 'Pensar na descrição', '08:37', 'NULL', '2020-12-04', NULL, 0),
(4, 'teste', 'Pensar na descrição', '19:14', 'NULL', '2020-12-04', NULL, 0),
(5, 'teste', 'Pensar na descrição', '19:14', 'NULL', '2020-12-04', NULL, 0),
(6, 'hgj', 'Pensar na descrição', '11:17', 'NULL', '2020-12-07', NULL, 1),
(7, 'hgj', 'Pensar na descrição', '11:17', 'NULL', '2020-12-07', NULL, 1),
(8, 'hgj', 'Pensar na descrição', '11:17', 'NULL', '2020-12-07', NULL, 1),
(9, 'hgj', 'Pensar na descrição', '11:17', 'NULL', '2020-12-07', NULL, 1),
(11, 'hgj', 'Pensar na descrição', '11:17', 'NULL', '2020-12-07', NULL, 1),
(12, 'hgj', 'Pensar na descrição', '11:17', 'NULL', '2020-12-07', NULL, 1),
(13, 'hgj', 'Pensar na descrição', '11:17', 'NULL', '2020-12-07', NULL, 1),
(15, 'hgj', 'Pensar na descrição', '11:17', 'NULL', '2020-12-07', NULL, 1),
(16, 'teste', 'Pensar na descrição', '15:12', 'NULL', '2020-12-07', NULL, 1),
(17, 'teste', 'Pensar na descrição', '15:12', NULL, '2020-12-07', NULL, 1),
(18, 'Teste', 'Pensar na descrição', '15:46', '16:00', '2020-12-08', '2020-12-09', 0),
(19, 'Teste', 'Pensar na descrição', '15:46', 'NULL', '2020-12-08', NULL, 0),
(20, 'Teste', 'Pensar na descrição', '15:46', 'NULL', '2020-12-08', NULL, 0),
(21, 'Teste', 'Pensar na descrição', '15:46', NULL, '2020-12-08', NULL, 0),
(22, 'teste', 'Pensar na descrição', '18:05', '19:06', '2020-12-08', '2000', 0),
(23, 'teste', 'Pensar na descrição', '18:05', '19:06', '2020-12-08', '2000', 0),
(24, 'teste', 'Pensar na descrição', '18:05', 'NULL', '2020-12-08', NULL, 0),
(25, 'teste', 'Pensar na descrição', '18:20', 'NULL', '2020-12-08', NULL, 0),
(26, 'teste', 'Pensar na descrição', '18:20', '18:24', '2020-12-08', '1999', 0),
(27, 'teste', 'Pensar na descrição', '18:20', '18:24', '2020-12-08', '1999', 0),
(28, 'teste', 'Pensar na descrição', '18:20', 'NULL', '2020-12-08', NULL, 0),
(29, 'teste', 'Pensar na descrição', '18:20', 'NULL', '2020-12-08', NULL, 0),
(30, 'teste', 'Pensar na descrição', '20:36', 'NULL', '2020-12-08', NULL, 0),
(31, 'teste', 'Pensar na descrição', '20:36', 'NULL', '2020-12-08', NULL, 0),
(32, 'teste', 'Pensar na descrição', '20:36', 'NULL', '2020-12-08', NULL, 0),
(33, 'dfsdf', 'Pensar na descrição', '10:05', 'NULL', '2020-12-10', NULL, 0),
(34, 'dfsdf', 'Pensar na descrição', '10:05', 'NULL', '2020-12-10', NULL, 0),
(35, 'sdfdf', 'Pensar na descrição', '10:07', 'NULL', '2020-12-10', NULL, 0),
(36, 'sdfdf', 'Pensar na descrição', '10:07', 'NULL', '2020-12-10', NULL, 0),
(37, 'sadasd', 'Pensar na descrição', '11:45', 'NULL', '2020-12-09', NULL, 0),
(38, 'sadasd', 'Pensar na descrição', '11:45', 'NULL', '2020-12-09', NULL, 0),
(39, 'sadasd', 'Pensar na descrição', '11:45', 'NULL', '2020-12-09', NULL, 0),
(40, 'teste', 'Pensar na descrição', '14:02', 'NULL', '2020-12-09', NULL, 0),
(41, 'teste', 'Pensar na descrição', '14:02', 'NULL', '2020-12-09', NULL, 0),
(42, 'teste', 'Pensar na descrição', '14:02', 'NULL', '2020-12-09', NULL, 0),
(43, 'teste', 'Pensar na descrição', '14:02', 'NULL', '2020-12-09', NULL, 0),
(44, 'teste', 'Pensar na descrição', '14:02', 'NULL', '2020-12-09', NULL, 0),
(45, 'teste', 'Pensar na descrição', '14:11', 'NULL', '2020-12-09', NULL, 0),
(46, 'teste', 'Pensar na descrição', '14:11', 'NULL', '2020-12-09', NULL, 0),
(47, 'teste', 'Pensar na descrição', '14:11', 'NULL', '2020-12-09', NULL, 0),
(48, 'teste', 'Pensar na descrição', '14:11', 'NULL', '2020-12-09', NULL, 0),
(49, 'teste', 'Pensar na descrição', '14:11', 'NULL', '2020-12-09', NULL, 0),
(50, 'teste', 'Pensar na descrição', '14:11', 'NULL', '2020-12-09', NULL, 0),
(51, 'teste', 'Pensar na descrição', '14:11', 'NULL', '2020-12-09', NULL, 0),
(52, 'Novoa', 'Pensar na descrição', '15:12', 'NULL', '2020-12-11', NULL, 1),
(54, 'teste', 'Pensar na descrição', '14:35', 'NULL', '2020-12-17', NULL, 0),
(55, 'teste carla', 'Pensar na descrição', '14:00', '16:00', '2021-02-04', 'NULL', 0),
(56, 'Comemorar o fim do ano', 'Pensar na descrição', '12:30', 'NULL', '2020-12-23', NULL, 1),
(57, 'Reunião de Diretoria', 'Pensar na descrição', '13:30', '14:30', '2021-01-20', '1998', 0),
(58, 'O Dia do Leitor', 'Pensar na descrição', '08:00', '20:00', '2021-01-07', '2021-01-08', 0),
(59, 'Este dia', 'Pensar na descrição', '14:44', '16:46', '2021-01-07', '2012', 0),
(60, 'Este dia', 'Pensar na descrição', '14:44', '16:46', '2021-01-06', '2021-01-08', 0),
(61, 'Reunião Teste', 'Pensar na descrição', '15:24', '17:32', '2021-01-11', 'NULL', 0),
(62, 'Reunião Teste', 'Pensar na descrição', '15:32', '19:32', '2021-01-11', 'NULL', 1),
(63, 'Reunião em casa', 'Pensar na descrição', '11:38', '12:39', '2021-01-15', '2021-01-16', 1),
(64, 'Reunião Teste', 'Pensar na descrição', '15:32', '19:32', '2021-01-11', 'NULL', 1),
(65, 'Reunião Teste', 'Pensar na descrição', '15:32', '19:32', '2021-01-11', 'NULL', 1),
(66, 'Reunião Teste', 'Pensar na descrição', '15:32', '19:32', '2021-01-11', 'NULL', 1),
(79, 'Reunião Teste', 'Pensar na descrição', '15:32', '19:32', '2021-01-11', 'NULL', 1),
(80, 'Reunião de trabalho', 'Pensar na descrição', '15:32', '19:32', '2021-01-11', 'NULL', 1),
(81, 'Teste roxo', 'Pensar na descrição', '17:49', '18:50', '2021-01-28', '2021-01-29', 1),
(82, 'Fazer', 'Pensar na descrição', '21:44', '22:45', '2021-01-29', 'NULL', 1),
(83, 'Realizar', 'Pensar na descrição', '21:45', '22:46', '2021-01-29', '2021-01-30', 1),
(84, 'Reunião TOP', 'Pensar na descrição', '15:00', '16:00', '2021-02-04', '2021-02-05', 1),
(85, 'Reunião TOP v2', 'Pensar na descrição', '14:30', '15:30', '2021-02-04', '2021-02-05', 1),
(86, 'Reunião TOP v3 (privada)', 'Pensar na descrição', '14:30', '16:00', '2021-02-01', '2021-02-05', 0),
(87, 'Reunião xxxx', 'Pensar na descrição', '14:40', '17:00', '2021-02-02', '2021-02-04', 1),
(89, 'Teste', 'Pensar na descrição', '17:00', '16:00', '2020-12-01', 'NULL', 0),
(90, 'Teste', 'Pensar na descrição', '17:00', '16:00', '2021-02-01', 'NULL', 1),
(91, 'Testee', 'Pensar na descrição', '18:00', '19:00', '2021-02-01', 'NULL', 1),
(92, '99595959595', 'Pensar na descrição', '12:00', '12:00', '2021-02-02', 'NULL', 1),
(93, 'Ferias do Marlon', 'Pensar na descrição', '12:00', '18:15', '2021-03-09', '2021-03-24', 1),
(94, 'Carnaval', 'Pensar na descrição', '09:00', '18:00', '2021-02-13', '2021-02-16', 1),
(95, '787878887778888777', 'Pensar na descrição', '11:26', '12:30', '2021-02-03', 'NULL', 1),
(99, 'Comida', 'Pensar na descrição', '08:00', '07:00', '2999-12-31', 'NULL', 1),
(101, 'Reunião', 'Pensar na descrição', '16:00', '17:00', '2021-02-03', 'NULL', 1),
(103, 'Expediente Vespertino ', 'Pensar na descrição', '13:00', '18:00', '2021-02-17', 'NULL', 1),
(104, 'Testee', 'Pensar na descrição', '11:00', '10:00', '2021-02-01', '2021-01-31', 0),
(105, 'Testeee', 'Pensar na descrição', '11:00', '12:00', '2021-02-01', 'NULL', 1),
(106, 'Reunião Teste', 'Pensar na descrição', '11:00', '12:00', '2021-02-01', 'NULL', 0),
(107, 'Testee2', 'Pensar na descrição', '12:00', '13:00', '2021-02-01', 'NULL', 0),
(108, 'ReuniãoTeste', 'Pensar na descrição', '11:00', '12:00', '2021-02-01', 'NULL', 1),
(109, 'peps', 'Pensar na descrição', '12:00', '18:00', '2021-02-08', '2021-02-12', 0),
(110, 'Reunião Teste', 'Pensar na descrição', '14:00', '15:00', '2021-02-03', '2021-02-03', 0),
(111, 'Reunião Teste', 'Pensar na descrição', '15:00', '17:00', '2021-02-03', '2021-02-06', 0),
(112, 'Dormir bem ', 'Pensar na descrição', '13:49', '13:49', '2021-02-03', 'NULL', 0),
(115, 'asd', 'Pensar na descrição', '10:00', '09:00', '2021-02-12', 'NULL', 0),
(117, 'Testeee', 'Pensar na descrição', '10:00', '11:01', '2021-02-01', '2021-02-08', 1),
(118, 'dfgdfgfdgdfg', 'Pensar na descrição', '11:44', '11:44', '2021-02-03', '2021-02-17', 1),
(119, 'teste', 'Pensar na descrição', '10:02', '12:11', '2021-02-18', '2021-03-01', 1),
(120, 'teste conflito', 'Pensar na descrição', '05:10', '11:11', '2021-02-18', '2021-02-19', 1),
(121, 'ertretert', 'Pensar na descrição', '16:39', '17:40', '2021-02-18', 'NULL', 0),
(122, 'te', 'Pensar na descrição', '16:50', '16:50', '2021-02-18', '2021-02-19', 1),
(123, 'testete', 'Pensar na descrição', '05:52', '17:53', '2021-02-18', 'NULL', 0),
(124, 'teste', 'Pensar na descrição', '13:24', '17:25', '2021-02-18', 'NULL', 1),
(125, 'testet', 'Pensar na descrição', '19:57', '19:57', '2021-02-18', 'NULL', 0),
(126, 'teste conflito so datas', 'Pensar na descrição', '09:59', '20:59', '2021-02-18', 'NULL', 1),
(127, 'teste conflito 2', 'Pensar na descrição', '08:18', '20:19', '2021-02-18', 'NULL', 1),
(128, 'teste', 'Pensar na descrição', '08:31', '20:32', '2021-02-18', 'NULL', 1),
(129, 'teste 3', 'Pensar na descrição', '09:07', '22:07', '2021-02-18', 'NULL', 1),
(130, 'teste', 'Pensar na descrição', '09:09', '07:16', '2021-02-19', '2021-02-20', 0),
(131, 'fdsfsd', 'Pensar na descrição', '22:19', '19:19', '2021-02-19', '2021-02-20', 0),
(132, 'dfsdf', 'Pensar na descrição', '00:11', '21:11', '2021-02-19', 'NULL', 0),
(133, 'trtyrtyrt', 'Pensar na descrição', '00:12', '18:12', '2021-02-19', 'NULL', 1);

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
(1, 'Novo', '2020-12-04 17:25:30', 'Diego', 'SEPLAG', '1267', 3, 1, 1),
(2, 'Novo', '2020-12-04 18:37:31', 'diego', 'SEPLAG', '1267', 1, 3, 1),
(3, 'Novo', '2020-12-04 19:14:19', 'Diego', 'SEPLAG', '1267', 1, 4, 1),
(4, 'Novo', '2020-12-04 19:27:49', 'Diego', 'SEPLAG', '1267', 3, 5, 1),
(5, 'Novo', '2020-12-07 11:17:35', 'ertret', 'SEPLAG', '1267', 1, 6, 1),
(6, 'Novo', '2020-12-07 14:22:17', 'ertret', 'SEPLAG', '1267', 1, 7, 1),
(7, 'Novo', '2020-12-07 14:23:24', 'ertret', 'SEPLAG', '1267', 1, 8, 1),
(8, 'Novo', '2020-12-07 14:23:29', 'ertret', 'SEPLAG', '1267', 1, 9, 1),
(10, 'Novo', '2020-12-07 14:56:28', 'ertret', 'SEPLAG', '1267', 1, 11, 1),
(11, 'Novo', '2020-12-07 15:06:04', 'ertret', 'SEPLAG', '1267', 1, 12, 1),
(12, 'Novo', '2020-12-07 15:09:33', 'ertret', 'SEPLAG', '1267', 1, 13, 1),
(13, 'Novo', '2020-12-07 15:10:34', 'ertret', 'SEPLAG', '1267', 1, 15, 1),
(14, 'Novo', '2020-12-07 15:12:24', 'dsfdsf', 'SEPLAG', '1267', 1, 16, 1),
(15, 'Novo', '2020-12-07 15:13:21', 'dsfdsf', 'SEPLAG', '1267', 1, 17, 1),
(16, 'Novo', '2020-12-08 15:50:10', 'Diego', 'SEPLAG', '1267', 1, 18, 1),
(17, 'Novo', '2020-12-08 15:56:50', 'Diego', 'SEPLAG', '1267', 1, 19, 1),
(18, 'Novo', '2020-12-08 16:01:57', 'Diego', 'SEPLAG', '1267', 1, 20, 1),
(19, 'Novo', '2020-12-08 16:03:12', 'Diego', 'SEPLAG', '1267', 1, 21, 1),
(20, 'Novo', '2020-12-08 18:07:15', 'diego', 'SEPLAG', '12687', 1, 22, 1),
(21, 'Cancelada', '2020-12-08 18:07:56', 'diego', 'SEPLAG', '12687', 1, 23, 1),
(22, 'Novo', '2020-12-08 18:08:49', 'diego', 'SEPLAG', '12687', 1, 24, 1),
(23, 'Novo', '2020-12-08 18:20:43', 'teste', 'SEPLAG', '1267', 1, 25, 1),
(24, 'Novo', '2020-12-08 18:24:10', 'teste', 'SEPLAG', '1267', 1, 26, 1),
(25, 'Novo', '2020-12-08 18:53:48', 'teste', 'SEPLAG', '1267', 1, 27, 1),
(26, 'Novo', '2020-12-08 19:43:38', 'teste', 'SEPLAG', '1267', 1, 28, 1),
(27, 'Novo', '2020-12-08 19:43:49', 'teste', 'SEPLAG', '1267', 1, 29, 1),
(28, 'Novo', '2020-12-08 20:36:03', 'tete', 'SEPLAG', '1267', 1, 30, 1),
(29, 'Novo', '2020-12-09 10:04:07', 'tete', 'SEPLAG', '1267', 1, 31, 1),
(30, 'Novo', '2020-12-09 10:05:03', 'tete', 'SEPLAG', '1267', 1, 32, 1),
(31, 'Novo', '2020-12-09 10:05:26', 'sdfsdf', 'SEPLAG', '1267', 2, 33, 1),
(32, 'Novo', '2020-12-09 10:06:03', 'sdfsdf', 'SEPLAG', '1267', 2, 34, 1),
(33, 'Novo', '2020-12-09 10:07:13', 'dsfsdf', 'SEPLAG', '126865', 2, 35, 1),
(34, 'Novo', '2020-12-09 10:12:06', 'dsfsdf', 'SEPLAG', '126865', 2, 36, 1),
(35, 'Novo', '2020-12-09 11:45:28', 'asdasd', 'SEPLAG', '5198', 2, 37, 1),
(36, 'Novo', '2020-12-09 12:34:20', 'asdasd', 'SEPLAG', '5198', 2, 38, 1),
(37, 'Novo', '2020-12-09 12:34:25', 'asdasd', 'SEPLAG', '5198', 2, 39, 1),
(38, 'Novo', '2020-12-09 14:02:49', 'stete', 'SEPLAG', '23432', 1, 40, 1),
(39, 'Novo', '2020-12-09 14:04:09', 'stete', 'SEPLAG', '23432', 1, 41, 1),
(40, 'Novo', '2020-12-09 14:04:15', 'stete', 'SEPLAG', '23432', 1, 42, 1),
(41, 'Novo', '2020-12-09 14:04:32', 'stete', 'SEPLAG', '23432', 1, 43, 1),
(42, 'Novo', '2020-12-09 14:08:13', 'stete', 'SEPLAG', '23432', 1, 44, 1),
(43, 'Novo', '2020-12-09 14:11:13', '123', 'SEPLAG', '2324', 1, 45, 1),
(44, 'Novo', '2020-12-09 14:12:51', '123', 'SEPLAG', '2324', 1, 46, 1),
(45, 'Novo', '2020-12-09 14:13:18', '123', 'SEPLAG', '2324', 1, 47, 1),
(46, 'Confirmada', '2020-12-09 14:13:50', '123', 'SEPLAG', '2324', 1, 48, 1),
(47, 'Confirmada', '2020-12-09 14:14:08', '123', 'SEPLAG', '2324', 1, 49, 1),
(48, 'Novo', '2020-12-09 14:14:25', '123', 'SEPLAG', '2324', 1, 50, 1),
(49, 'Novo', '2020-12-09 14:19:37', '123', 'SEPLAG', '2324', 1, 51, 1),
(50, 'Novo', '2020-12-11 18:12:32', 'Diego Alberto', 'SEPLAG', '1267', 1, 52, 1),
(51, 'Novo', '2020-12-17 17:38:05', 'teste', 'SEPLAG', '12', 1, 54, 21),
(52, 'Editado', '2021-02-01 16:20:05', 'Carla', 'SEPLAG', '99999999999999', 1, 55, 47),
(53, 'Novo', '2020-12-22 13:34:47', 'Diego ', 'SEPLAG', '1267', 3, 56, 21),
(54, 'Cancelada', '2021-01-05 14:30:30', 'Cláudia', 'SEPLAG', '5132881267', 1, 57, 59),
(55, 'Confirmada', '2021-01-07 17:31:47', 'Diego', 'SEPLAG', '1267', 1, 58, 21),
(56, 'Cancelada', '2021-01-07 17:45:59', 'diego', 'SEPLAG', '1267', 1, 60, 21),
(57, 'Confirmada', '2021-01-11 18:32:24', 'Diego', 'SEPLAG', '1267', 1, 61, 21),
(58, 'Cancelada', '2021-01-11 18:33:04', 'Diego', 'SEPLAG', '1268', 1, 62, 21),
(59, 'Novo', '2021-01-15 14:38:15', 'Diego', 'SEPLAG', '1267', 2, 63, 21),
(60, 'Novo', '2021-01-27 13:20:21', 'Diego', 'SEPLAG', '1267', 1, 64, 21),
(61, 'Novo', '2021-01-27 13:20:40', 'Diego', 'SEPLAG', '1268', 1, 65, 21),
(62, 'Novo', '2021-01-27 14:07:45', 'Diego', 'SEPLAG', '1267', 1, 66, 21),
(75, 'Confirmada', '2021-01-27 16:39:35', 'Diego', 'SEPLAG', '1267', 1, 79, 21),
(76, 'Confirmada', '2021-02-01 17:13:16', 'Diego', 'SEPLAG', '1270', 1, 80, 21),
(77, 'Novo', '2021-01-28 20:46:54', 'teste', 'SEPLAG', '1267', 4, 81, 21),
(78, 'Novo', '2021-01-30 00:41:10', 'teste', 'SEPLAG', '1270', 4, 82, 21),
(79, 'Novo', '2021-01-30 00:42:15', 'diego', 'SEPLAG', '1270', 27, 83, 21),
(80, 'Confirmada', '2021-02-01 16:23:02', 'lauro', 'SEPLAG', '519999999999', 1, 84, 47),
(81, 'Novo', '2021-02-01 16:24:57', 'lauro', 'SEPLAG', '51999999999', 2, 85, 47),
(82, 'Novo', '2021-02-01 16:26:18', 'Lauro', 'SEPLAG', '519999999999', 2, 86, 47),
(83, 'Novo', '2021-02-01 16:35:00', 'Carla', 'SEPLAG', '51555555555', 4, 87, 47),
(84, 'Excluída', '2021-02-01 17:57:48', 'Marlon Dietrich', 'SEPLAG', '5132881267', 2, 89, 31),
(85, 'Confirmada', '2021-02-01 17:59:39', 'Marlon Dietrich', 'SEPLAG', '5132881267', 1, 90, 31),
(86, 'Excluída', '2021-02-03 13:38:29', 'Marlon Dietrich', 'SEPLAG', '5132881267', 1, 91, 31),
(87, 'Excluída', '2021-02-03 12:25:41', 'Marlon Dietrich', 'SEPLAG', '2131323', 4, 92, 31),
(88, 'Editado', '2021-02-03 11:16:25', 'Diego', 'SEPLAG', '51995710503', 4, 93, 21),
(89, 'Novo', '2021-02-03 11:18:25', 'Eduardo Leite', 'SEPLAG', '1288', 4, 94, 21),
(90, 'Cancelada', '2021-02-03 13:31:13', '778787878787878yy', 'SEPLAG', '51998853961', 1, 95, 61),
(91, 'Novo', '2021-02-03 11:41:12', 'Vini Sapatinho', 'SEPLAG', '3', 4, 99, 61),
(92, 'Excluída', '2021-02-03 12:27:55', 'Marlon Dietrich', 'SEPLAG', '999999999999999999999', 28, 101, 31),
(93, 'Novo', '2021-02-03 12:57:07', 'Diego', 'SEPLAG', '1267', 4, 103, 21),
(94, 'Novo', '2021-02-03 13:28:24', 'Marlon Dietrich', 'SEPLAG', '9599259259', 28, 104, 31),
(95, 'Novo', '2021-02-03 13:32:53', '959595', 'SEPLAG', '119959592', 28, 105, 31),
(96, 'Novo', '2021-02-03 13:34:31', 'Marlon D.', 'SEPLAG', '12312312', 2, 106, 31),
(97, 'Novo', '2021-02-03 13:35:18', 'Marlon D.', 'SEPLAG', '1267', 28, 107, 31),
(98, 'Novo', '2021-02-03 13:36:20', 'Marlon D.', 'SEPLAG', '4959595', 28, 108, 31),
(99, 'Novo', '2021-02-03 13:38:07', 'Touro ', 'SEPLAG', '55999657525', 4, 109, 61),
(100, 'Novo', '2021-02-03 13:42:08', 'Marlon D.', 'SEPLAG', '1267', 30, 110, 31),
(101, 'Novo', '2021-02-03 13:45:18', 'Marlon D.', 'SEPLAG', '1267', 28, 111, 31),
(102, 'Confirmada', '2021-02-03 13:50:02', 'Touro ', 'SEPLAG', '519999999999999999999999999999999999999999', 28, 112, 61),
(103, 'Novo', '2021-02-11 12:55:13', 'asdas', 'SEPLAG', '959595', 28, 115, 31),
(104, 'Editado', '2021-02-11 22:12:16', 'Marlond', 'SEPLAG', '51996707829', 2, 117, 31),
(105, 'Novo', '2021-02-17 11:44:48', 'fdgdfgdfgdfg', 'SEPLAG', '51995710503', 4, 118, 22),
(106, 'Novo', '2021-02-18 10:04:48', 'diego santos', 'seplag', '5199999999999999999999999999999', 4, 119, 21),
(107, 'Editado', '2021-02-18 20:14:04', 'fdfdgfd', 'spgg', '454545', 30, 120, 21),
(108, 'Novo', '2021-02-18 16:39:38', 'ertertert', 'spgg', '51957100503', 28, 121, 21),
(109, 'Novo', '2021-02-18 16:51:04', 'tes', 'spgg', '51515', 28, 122, 21),
(110, 'Novo', '2021-02-18 16:52:44', 'diego', 'spgg', '5111111111', 28, 123, 21),
(111, 'Editado', '2021-02-18 19:55:08', 'ddffffffffffffffffffffffffffffffffffffffff', 'spgg', 'fffffffffff', 28, 124, 21),
(112, 'Novo', '2021-02-18 19:58:43', 'ete', 'spgg', '65415', 28, 125, 21),
(113, 'Novo', '2021-02-18 19:59:46', 'teste', 'spgg', '51995710503', 28, 126, 21),
(114, 'Novo', '2021-02-18 20:19:17', 'dfsdfsdf', 'spgg', '454455445', 30, 127, 21),
(115, 'Novo', '2021-02-18 20:32:08', 'teste', 'spgg', '26233', 30, 128, 21),
(116, 'Novo', '2021-02-18 22:07:37', 'diego', 'spgg', '45554645', 30, 129, 21),
(117, 'Novo', '2021-02-18 22:17:07', 'teetet', 'SEPLAG', '1265456465', 28, 130, 21),
(118, 'Novo', '2021-02-18 22:19:17', 'sdfsdf', 'spgg', '123121', 28, 131, 21),
(119, 'Novo', '2021-02-19 00:12:15', 'sdfdsf', 'spgg', '1231', 28, 132, 21),
(120, 'Novo', '2021-02-19 00:12:43', 'tetgd', 'spgg', '123', 28, 133, 21);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_permissao`
--

CREATE TABLE `user_permissao` (
  `pk_user_permissao` int(11) NOT NULL,
  `fk_glpi_users` int(11) NOT NULL,
  `fk_permissao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `user_permissao`
--

INSERT INTO `user_permissao` (`pk_user_permissao`, `fk_glpi_users`, `fk_permissao`) VALUES
(1, 21, 1),
(3, 47, 1),
(4, 13, 0),
(5, 31, 1);

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
  MODIFY `pk_espacos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `pk_eventos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT de tabela `permissao`
--
ALTER TABLE `permissao`
  MODIFY `pk_permissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `pk_reservas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de tabela `user_permissao`
--
ALTER TABLE `user_permissao`
  MODIFY `pk_user_permissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
