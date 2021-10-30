-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 30-Out-2021 às 14:40
-- Versão do servidor: 8.0.26
-- versão do PHP: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `farmacia_painel`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `painel_pedidos`
--

CREATE TABLE `painel_pedidos` (
  `id` int NOT NULL,
  `produto` text NOT NULL,
  `quantidade` float NOT NULL,
  `ordem` text NOT NULL,
  `email` text NOT NULL,
  `total` float NOT NULL,
  `metodo` tinyint(1) NOT NULL DEFAULT '0',
  `data` datetime NOT NULL,
  `pago` tinyint(1) NOT NULL DEFAULT '0',
  `frete` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `painel_remedios`
--

CREATE TABLE `painel_remedios` (
  `id` int NOT NULL,
  `nome` text NOT NULL,
  `quantidade` text NOT NULL,
  `laboratorio` text NOT NULL,
  `valor` text NOT NULL,
  `img` text NOT NULL,
  `tipo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `painel_remedios`
--

INSERT INTO `painel_remedios` (`id`, `nome`, `quantidade`, `laboratorio`, `valor`, `img`, `tipo`) VALUES
(4, 'Ibuprofeno', '50mg/mL ', 'Geolab', '8.90', 'images/upload/ibuprofeno.png', 'Gotas'),
(5, 'Paracetamol', '200mg/mL ', 'Teuto', '12.95', 'images/upload/paracetamol.png', 'Gotas'),
(6, 'Dipirona Monoidratado', '500mg/mL ', 'EMS', '21.95', 'images/upload/dipirona.png', '30 Capsulas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `painel_usuarios`
--

CREATE TABLE `painel_usuarios` (
  `id` int NOT NULL,
  `nome` text NOT NULL,
  `email` text NOT NULL,
  `senha` text NOT NULL,
  `logradouro` text NOT NULL,
  `cep` text NOT NULL,
  `bairro` text NOT NULL,
  `uf` text NOT NULL,
  `cidade` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `painel_pedidos`
--
ALTER TABLE `painel_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `painel_remedios`
--
ALTER TABLE `painel_remedios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `painel_usuarios`
--
ALTER TABLE `painel_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `painel_pedidos`
--
ALTER TABLE `painel_pedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT de tabela `painel_remedios`
--
ALTER TABLE `painel_remedios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `painel_usuarios`
--
ALTER TABLE `painel_usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
