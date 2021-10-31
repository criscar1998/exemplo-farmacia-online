-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 31-Out-2021 às 20:07
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

--
-- Extraindo dados da tabela `painel_pedidos`
--

INSERT INTO `painel_pedidos` (`id`, `produto`, `quantidade`, `ordem`, `email`, `total`, `metodo`, `data`, `pago`, `frete`) VALUES
(251, '5', 2, 'K6XSkBR7', 'cristiansilva9899@gmail.com', 25.9, 3, '2021-10-30 15:46:16', 2, 3.55),
(252, '5', 1, 'UTnp0Gjq', 'cristiansilva9899@gmail.com', 12.95, 1, '2021-10-31 19:58:55', 1, 3.55),
(253, '6', 2, 'UTnp0Gjq', 'cristiansilva9899@gmail.com', 43.9, 1, '2021-10-31 19:58:55', 1, 3.55),
(254, '6', 1, 'LSH7mWdV', 'cristiansilva9899@gmail.com', 21.95, 2, '2021-10-31 20:04:51', 0, 3.55);

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
-- Extraindo dados da tabela `painel_usuarios`
--

INSERT INTO `painel_usuarios` (`id`, `nome`, `email`, `senha`, `logradouro`, `cep`, `bairro`, `uf`, `cidade`) VALUES
(15, 'usuario teste', 'demo@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'av sapucaia,256', '00000000', 'centro', 'RS', 'Sapucaia do Sul');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT de tabela `painel_remedios`
--
ALTER TABLE `painel_remedios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `painel_usuarios`
--
ALTER TABLE `painel_usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
