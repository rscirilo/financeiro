-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 02/04/2025 às 13:13
-- Versão do servidor: 9.1.0
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `financeiro`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_company` int NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `address_number` varchar(50) DEFAULT NULL,
  `address_neighb` varchar(100) DEFAULT NULL,
  `address_city` varchar(50) DEFAULT NULL,
  `address_state` varchar(50) DEFAULT NULL,
  `address_country` varchar(50) DEFAULT NULL,
  `address_zipcode` varchar(50) DEFAULT NULL,
  `stars` int NOT NULL DEFAULT '3',
  `internal_obs` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `clients`
--

INSERT INTO `clients` (`id`, `id_company`, `name`, `email`, `phone`, `address`, `address2`, `address_number`, `address_neighb`, `address_city`, `address_state`, `address_country`, `address_zipcode`, `stars`, `internal_obs`) VALUES
(7, 1, 'teste', 'artemisia@admin.com', '30249234230', 'aaaaaaaaaaaaa', 'aaaaaaaaaaaaa', 'aaaaaaaaaaaaa', 'aaaaaaaa', 'aaaaaaaaaaa', 'aaa', 'a', 'aaaaaaa', 3, ''),
(8, 1, 'bbbbbbbb', 'bbbbbbbbbbbbb@gmail.com', 'bbbbbbbbbbbbbb', 'bbbbbbbbbbbb', 'bbbbbbbbb', 'bbbbbbbbbbbbb', 'bbbbbbbbbb', 'bbbbbbbbbbbb', 'bbbbbbbbbbbbb', 'bbbbb', 'bbbbbbbbbbb', 3, 'bbbb');

-- --------------------------------------------------------

--
-- Estrutura para tabela `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `companies`
--

INSERT INTO `companies` (`id`, `name`) VALUES
(1, 'Diego Dantas');

-- --------------------------------------------------------

--
-- Estrutura para tabela `emprestimo`
--

DROP TABLE IF EXISTS `emprestimo`;
CREATE TABLE IF NOT EXISTS `emprestimo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_company` int NOT NULL,
  `id_client` int NOT NULL,
  `valor_emprestimo` double(10,2) NOT NULL,
  `data_emprestimo` datetime NOT NULL,
  `juros_mes` float NOT NULL,
  `recebido` float NOT NULL,
  `mensalidade` float NOT NULL,
  `qtd_mensalidade` int NOT NULL,
  `juros_sc` tinyint(1) NOT NULL,
  `valor_atual` decimal(10,2) NOT NULL,
  `devendo` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_emprestimo_cliente` (`id_client`),
  KEY `fk_emprestimo_company` (`id_company`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura para tabela `estatistica`
--

DROP TABLE IF EXISTS `estatistica`;
CREATE TABLE IF NOT EXISTS `estatistica` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_company` int NOT NULL,
  `total_emprestado` float NOT NULL,
  `total_juros` float NOT NULL,
  `total_recebido` float NOT NULL,
  `total_receber` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura para tabela `permission_groups`
--

DROP TABLE IF EXISTS `permission_groups`;
CREATE TABLE IF NOT EXISTS `permission_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_company` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `params` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `permission_groups`
--

INSERT INTO `permission_groups` (`id`, `id_company`, `name`, `params`) VALUES
(1, 1, 'MASTER', '1,2,5,6,7,11,12,13,14,15,16,17'),
(2, 1, 'ADMIN', '1,6,7,11,12,13,14,15,16,17');

-- --------------------------------------------------------

--
-- Estrutura para tabela `permission_params`
--

DROP TABLE IF EXISTS `permission_params`;
CREATE TABLE IF NOT EXISTS `permission_params` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_company` int NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `permission_params`
--

INSERT INTO `permission_params` (`id`, `id_company`, `name`) VALUES
(1, 1, 'logout'),
(2, 1, 'permissions_view'),
(5, 1, 'nome da permissãp'),
(6, 1, 'users_view'),
(7, 1, 'clients_view'),
(11, 1, 'clients_edit'),
(12, 1, 'emprestimo_view'),
(13, 1, 'emprestimo_add'),
(14, 1, 'emprestimo_edit'),
(15, 1, 'emprestimo_quitar'),
(16, 1, 'home_view'),
(17, 1, 'estatisticas_view');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_company` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `id_group` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `id_company`, `email`, `password`, `id_group`) VALUES
(1, 1, 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 1),
(3, 1, 'diego@diego.com', '202cb962ac59075b964b07152d234b70', 2),
(5, 1, 'artemisia@admin.com', '21232f297a57a5a743894a0e4a801fc3', 1);

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD CONSTRAINT `fk_emprestimo_cliente` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `fk_emprestimo_company` FOREIGN KEY (`id_company`) REFERENCES `companies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
