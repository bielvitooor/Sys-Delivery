-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/06/2025 às 08:35
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `categorias_id` int(11) UNSIGNED NOT NULL,
  `categorias_nome` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`categorias_id`, `categorias_nome`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Pizza', NULL, NULL, NULL),
(2, 'Hamburguer', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidades`
--

CREATE TABLE `cidades` (
  `cidades_id` int(11) UNSIGNED NOT NULL,
  `cidades_nome` varchar(255) NOT NULL,
  `cidades_uf` char(2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cidades`
--

INSERT INTO `cidades` (`cidades_id`, `cidades_nome`, `cidades_uf`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Ceres', 'GO', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`cliente_id`, `usuario_id`) VALUES
(4, 25),
(5, 26);

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `enderecos_id` int(11) UNSIGNED NOT NULL,
  `usuarios_id` int(11) UNSIGNED NOT NULL,
  `cidades_id` int(11) UNSIGNED NOT NULL,
  `logradouro` varchar(255) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `enderecos`
--

INSERT INTO `enderecos` (`enderecos_id`, `usuarios_id`, `cidades_id`, `logradouro`, `numero`, `status`, `complemento`, `bairro`, `cep`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 24, 1, 'rua 33', '231', '1', 'Ceres', 'Vila Nova', '763000000', NULL, NULL, NULL),
(6, 25, 1, 'Rua 09 ', 's/n', '', '', 'Setor Sorisso II', '763000000', NULL, NULL, NULL),
(7, 26, 1, 'Rua 33', '231B', '1', '', 'Vila Nova', '763000000', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `entregas`
--

CREATE TABLE `entregas` (
  `entrega_id` int(10) UNSIGNED NOT NULL,
  `venda_id` int(10) UNSIGNED DEFAULT NULL,
  `funcionario_id` int(10) UNSIGNED DEFAULT NULL,
  `data_entrega` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `data_saiu_entrega` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `entregas`
--

INSERT INTO `entregas` (`entrega_id`, `venda_id`, `funcionario_id`, `data_entrega`, `status`, `data_saiu_entrega`) VALUES
(1, 18, 4, NULL, 'Saiu para Entrega', '2025-06-17 06:33:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `estoque_id` int(10) UNSIGNED NOT NULL,
  `produto_id` int(10) UNSIGNED DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `estoque`
--

INSERT INTO `estoque` (`estoque_id`, `produto_id`, `quantidade`) VALUES
(1, 1, 10),
(2, 2, 19);

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `funcionario_id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `cargo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`funcionario_id`, `usuario_id`, `cargo`) VALUES
(4, 24, '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `imgprodutos`
--

CREATE TABLE `imgprodutos` (
  `imgprodutos_id` int(11) UNSIGNED NOT NULL,
  `imgprodutos_link` varchar(255) NOT NULL,
  `imgprodutos_descricao` text DEFAULT NULL,
  `imgprodutos_produtos_id` int(11) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `itens_pedido_id` int(11) UNSIGNED NOT NULL,
  `pedidos_pedido_id` int(10) UNSIGNED NOT NULL,
  `produtos_produtos_id` int(11) UNSIGNED NOT NULL,
  `preco_venda` decimal(10,2) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`itens_pedido_id`, `pedidos_pedido_id`, `produtos_produtos_id`, `preco_venda`, `quantidade`) VALUES
(17, 9, 1, 24.00, 3),
(18, 9, 2, 12.00, 1),
(19, 10, 1, 24.00, 1),
(20, 11, 1, 24.00, 2),
(21, 12, 2, 12.00, 1),
(24, 13, 1, 24.00, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_venda`
--

CREATE TABLE `itens_venda` (
  `itens_venda_id` int(11) UNSIGNED NOT NULL,
  `vendas_venda_id` int(10) UNSIGNED NOT NULL,
  `produtos_produtos_id` int(11) UNSIGNED NOT NULL,
  `preco_venda` decimal(10,2) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens_venda`
--

INSERT INTO `itens_venda` (`itens_venda_id`, `vendas_venda_id`, `produtos_produtos_id`, `preco_venda`, `quantidade`) VALUES
(19, 17, 1, 24.00, 3),
(20, 17, 2, 12.00, 1),
(21, 18, 1, 24.00, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(15, '2025-04-23-000001', 'App\\Database\\Migrations\\Categorias', 'default', 'App', 1748209024, 1),
(16, '2025-04-23-000002', 'App\\Database\\Migrations\\Cidades', 'default', 'App', 1748209024, 1),
(17, '2025-04-23-000003', 'App\\Database\\Migrations\\Usuarios', 'default', 'App', 1748209024, 1),
(18, '2025-04-23-000004', 'App\\Database\\Migrations\\Produtos', 'default', 'App', 1748209024, 1),
(19, '2025-04-23-000005', 'App\\Database\\Migrations\\ImgProdutos', 'default', 'App', 1748209024, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `pedido_id` int(10) UNSIGNED NOT NULL,
  `cliente_id` int(10) UNSIGNED DEFAULT NULL,
  `data_pedido` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) DEFAULT NULL,
  `endereco_id` int(10) UNSIGNED DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`pedido_id`, `cliente_id`, `data_pedido`, `total`, `endereco_id`, `status`) VALUES
(9, 4, '2025-06-16 18:20:34', 84.00, 6, 'Aceito'),
(10, NULL, '2025-06-17 02:58:38', 24.00, 4, 'Pendente'),
(11, 4, '2025-06-17 04:56:14', 48.00, 6, 'Pendente'),
(12, 5, '2025-06-17 05:02:50', 12.00, 7, 'Pendente'),
(13, 5, '2025-06-17 06:23:52', 24.00, 7, 'Aceito');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `produtos_id` int(11) UNSIGNED NOT NULL,
  `produtos_nome` varchar(150) NOT NULL,
  `produtos_descricao` text DEFAULT NULL,
  `produtos_preco_custo` decimal(10,2) NOT NULL DEFAULT 0.00,
  `produtos_preco_venda` decimal(10,2) NOT NULL DEFAULT 0.00,
  `produtos_categorias_id` int(11) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`produtos_id`, `produtos_nome`, `produtos_descricao`, `produtos_preco_custo`, `produtos_preco_venda`, `produtos_categorias_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Pizza', 'Pizza ', 12.00, 24.00, 1, NULL, NULL, NULL),
(2, 'X-Salada', 'goiano', 6.90, 12.89, 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `usuarios_id` int(11) UNSIGNED NOT NULL,
  `usuarios_nome` varchar(100) NOT NULL,
  `usuarios_sobrenome` varchar(100) NOT NULL,
  `usuarios_email` varchar(150) NOT NULL,
  `usuarios_cpf` char(14) NOT NULL,
  `usuarios_nivel` tinyint(1) NOT NULL DEFAULT 0,
  `usuarios_fone` varchar(20) DEFAULT NULL,
  `usuarios_senha` varchar(255) NOT NULL,
  `usuarios_data_nasc` date NOT NULL,
  `usuarios_data_cadastro` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`usuarios_id`, `usuarios_nome`, `usuarios_sobrenome`, `usuarios_email`, `usuarios_cpf`, `usuarios_nivel`, `usuarios_fone`, `usuarios_senha`, `usuarios_data_nasc`, `usuarios_data_cadastro`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Vilson', 'Soares de Siqueira', 'vilsonsoares@gmail.com', '999.999.999-99', 1, '6398474-3380', 'e10adc3949ba59abbe56e057f20f883e', '1981-12-03', '0000-00-00 00:00:00', NULL, NULL, NULL),
(24, 'Gabriel ', 'Brito', 'gabrielvitorsilvabrito@gmail.com', '12345678901', 3, '62986073404', 'e10adc3949ba59abbe56e057f20f883e', '2004-03-19', NULL, NULL, NULL, NULL),
(25, 'Warlley Felipe', 'Teste', '12345@gmail.com', '123456', 0, '62986073404', 'e10adc3949ba59abbe56e057f20f883e', '2004-03-19', NULL, NULL, NULL, NULL),
(26, 'Vanilda ', 'Maria da Silva', 'vanilda@gmail.com', '00000000000', 0, '62984119650', 'fcea920f7412b5da7be0cf42b8c93759', '1977-05-11', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `venda_id` int(10) UNSIGNED NOT NULL,
  `pedido_id` int(10) UNSIGNED NOT NULL,
  `data_venda` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`venda_id`, `pedido_id`, `data_venda`) VALUES
(17, 9, '2025-06-16 18:21:50'),
(18, 13, '2025-06-17 06:23:52');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`categorias_id`);

--
-- Índices de tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`cidades_id`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cliente_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`enderecos_id`),
  ADD KEY `usuarios_id` (`usuarios_id`),
  ADD KEY `cidades_id` (`cidades_id`);

--
-- Índices de tabela `entregas`
--
ALTER TABLE `entregas`
  ADD PRIMARY KEY (`entrega_id`),
  ADD KEY `venda_id` (`venda_id`),
  ADD KEY `funcionario_id` (`funcionario_id`);

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`estoque_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`funcionario_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `imgprodutos`
--
ALTER TABLE `imgprodutos`
  ADD PRIMARY KEY (`imgprodutos_id`),
  ADD KEY `imgprodutos_imgprodutos_produtos_id_foreign` (`imgprodutos_produtos_id`);

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`itens_pedido_id`),
  ADD KEY `fk_itens_pedido_pedidos1_idx` (`pedidos_pedido_id`),
  ADD KEY `fk_itens_pedido_produtos1_idx` (`produtos_produtos_id`);

--
-- Índices de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD PRIMARY KEY (`itens_venda_id`),
  ADD KEY `fk_itens_venda_produtos1_idx` (`produtos_produtos_id`),
  ADD KEY `fk_itens_venda_vendas1` (`vendas_venda_id`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`pedido_id`),
  ADD KEY `pedidos_endereco_fk` (`endereco_id`),
  ADD KEY `pedidos_cliente_fk` (`cliente_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`produtos_id`),
  ADD KEY `fk_categoria` (`produtos_categorias_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuarios_id`),
  ADD UNIQUE KEY `usuarios_email` (`usuarios_email`),
  ADD UNIQUE KEY `usuarios_cpf` (`usuarios_cpf`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`venda_id`),
  ADD UNIQUE KEY `pedido_id` (`pedido_id`),
  ADD UNIQUE KEY `pedido_id_2` (`pedido_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `categorias_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `cidades`
--
ALTER TABLE `cidades`
  MODIFY `cidades_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `cliente_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `enderecos_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `entregas`
--
ALTER TABLE `entregas`
  MODIFY `entrega_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `estoque_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `funcionario_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `imgprodutos`
--
ALTER TABLE `imgprodutos`
  MODIFY `imgprodutos_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `itens_pedido_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  MODIFY `itens_venda_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `pedido_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `produtos_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuarios_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `venda_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enderecos_ibfk_2` FOREIGN KEY (`cidades_id`) REFERENCES `cidades` (`cidades_id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `entregas`
--
ALTER TABLE `entregas`
  ADD CONSTRAINT `entregas_ibfk_1` FOREIGN KEY (`venda_id`) REFERENCES `vendas` (`venda_id`),
  ADD CONSTRAINT `entregas_ibfk_2` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`funcionario_id`);

--
-- Restrições para tabelas `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`produtos_id`);

--
-- Restrições para tabelas `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD CONSTRAINT `funcionarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `imgprodutos`
--
ALTER TABLE `imgprodutos`
  ADD CONSTRAINT `imgprodutos_imgprodutos_produtos_id_foreign` FOREIGN KEY (`imgprodutos_produtos_id`) REFERENCES `produtos` (`produtos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `fk_itens_pedido_pedidos1` FOREIGN KEY (`pedidos_pedido_id`) REFERENCES `pedidos` (`pedido_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_itens_pedido_produtos1` FOREIGN KEY (`produtos_produtos_id`) REFERENCES `produtos` (`produtos_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD CONSTRAINT `fk_itens_venda_produtos1` FOREIGN KEY (`produtos_produtos_id`) REFERENCES `produtos` (`produtos_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_itens_venda_vendas1` FOREIGN KEY (`vendas_venda_id`) REFERENCES `vendas` (`venda_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_cliente_fk` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`cliente_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_endereco_fk` FOREIGN KEY (`endereco_id`) REFERENCES `enderecos` (`enderecos_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`produtos_categorias_id`) REFERENCES `categorias` (`categorias_id`),
  ADD CONSTRAINT `produtos_produtos_categorias_id_foreign` FOREIGN KEY (`produtos_categorias_id`) REFERENCES `categorias` (`categorias_id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `fk_vendas_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`pedido_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
