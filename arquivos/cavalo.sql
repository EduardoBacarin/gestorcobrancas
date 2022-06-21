-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 20/04/2022 às 21:44
-- Versão do servidor: 10.4.21-MariaDB
-- Versão do PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cavalo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `animal`
--

CREATE TABLE `animal` (
  `codigo_ani` int(11) NOT NULL,
  `codigo_lab` int(11) NOT NULL,
  `codigo_prop` int(11) DEFAULT NULL,
  `codigo_pro` int(11) NOT NULL,
  `codigo_vet` int(11) NOT NULL,
  `nome_ani` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `registro_ani` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `especie_ani` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `raca_ani` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `sexo_ani` varchar(1) COLLATE utf8mb4_bin NOT NULL,
  `idade_ani` int(11) NOT NULL,
  `classificacao_ani` varchar(10) COLLATE utf8mb4_bin NOT NULL,
  `outraclassificacao_ani` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `resenha_ani` varchar(250) COLLATE utf8mb4_bin NOT NULL,
  `ativo_ani` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Despejando dados para a tabela `animal`
--

INSERT INTO `animal` (`codigo_ani`, `codigo_lab`, `codigo_prop`, `codigo_pro`, `codigo_vet`, `nome_ani`, `registro_ani`, `especie_ani`, `raca_ani`, `sexo_ani`, `idade_ani`, `classificacao_ani`, `outraclassificacao_ani`, `resenha_ani`, `ativo_ani`) VALUES
(1, 13, 2, 1, 7, 'Cavalo', '1726371623', 'Cavalinho', 'Cavalar', 'M', 17, '1', '', 'assets/resenhas/10203028372873_1650325635.png', 1),
(2, 13, 2, 1, 7, 'Cavalinho', '18276371623', 'Cavalar', 'Cavalo', 'M', 26, '1', '', 'assets/resenhas/716237617236_1650325916.png', 1),
(6, 13, 2, 1, 7, 'Cavalo Marinho', '102030', 'Do Mar', 'Marinha', 'M', 38, '1', '', 'assets/resenhas/123123_1650330597.png', 1),
(7, 13, 2, 1, 7, 'Cavalo do Mar', '12837874623', 'moranomar', 'Marinho', 'M', 83, '1', '', 'assets/resenhas/123123123123_1650330924.png', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `exame`
--

CREATE TABLE `exame` (
  `codigo_exa` int(11) NOT NULL,
  `codigo_lab` int(11) NOT NULL,
  `codigo_prop` int(11) NOT NULL,
  `codigo_vet` int(11) NOT NULL,
  `codigo_ani` int(11) NOT NULL,
  `numeroexame_exa` int(11) NOT NULL,
  `registroanimal_exa` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `status_exa` int(11) NOT NULL DEFAULT 1 COMMENT '1- Aguardando\r\n2- Em Análise\r\n3- Aprovado\r\n4- Reprovado',
  `comentarios_exa` text COLLATE utf8mb4_bin NOT NULL,
  `ativo_exa` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Despejando dados para a tabela `exame`
--

INSERT INTO `exame` (`codigo_exa`, `codigo_lab`, `codigo_prop`, `codigo_vet`, `codigo_ani`, `numeroexame_exa`, `registroanimal_exa`, `status_exa`, `comentarios_exa`, `ativo_exa`) VALUES
(4, 13, 2, 7, 5, 126317263, '1726371623', 1, 'Observações importantes sobre o exame', 1),
(5, 13, 2, 7, 1, 0, '1726371623', 1, '', 1),
(6, 13, 2, 7, 6, 123123, '102030', 1, 'ele vive em um abacaxi e mora no mar', 1),
(7, 13, 2, 7, 6, 123123123, '102030', 1, '123123123', 1),
(8, 13, 2, 7, 7, 2147483647, '12837874623', 1, '123123123123123132', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `laboratorio`
--

CREATE TABLE `laboratorio` (
  `codigo_lab` int(11) NOT NULL,
  `senha_lab` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `tipo_lab` int(11) NOT NULL,
  `nome_lab` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `email_lab` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `telefone_lab` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `portariacredenciamento_lab` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `documento_lab` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `cep_lab` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `rua_lab` varchar(250) COLLATE utf8mb4_bin NOT NULL,
  `bairro_lab` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `numero_lab` int(11) NOT NULL,
  `cidade_lab` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `estadouf_lab` varchar(2) COLLATE utf8mb4_bin NOT NULL,
  `ativo_lab` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Despejando dados para a tabela `laboratorio`
--

INSERT INTO `laboratorio` (`codigo_lab`, `senha_lab`, `tipo_lab`, `nome_lab`, `email_lab`, `telefone_lab`, `portariacredenciamento_lab`, `documento_lab`, `cep_lab`, `rua_lab`, `bairro_lab`, `numero_lab`, `cidade_lab`, `estadouf_lab`, `ativo_lab`) VALUES
(13, '243b52a2d15a5668a85665ee51f2a28b2a65512271d9494283884f651ebca8b5', 2, 'Laboratório vExames', 'vexames@laboratorio.com', '18996359212', '83478374873', '43679305800', '19020220', 'Rua Antônio Fioravante Menezes', 'Vila Lessa', 95, 'Presidente Prudente', 'SP', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `propriedade`
--

CREATE TABLE `propriedade` (
  `codigo_pro` int(11) NOT NULL,
  `codigo_prop` int(11) NOT NULL,
  `codigo_vet` int(11) NOT NULL,
  `nome_pro` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `qtdequinos_pro` int(11) NOT NULL,
  `cep_pro` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `logradouro_pro` varchar(250) COLLATE utf8mb4_bin DEFAULT NULL,
  `numero_pro` int(11) DEFAULT NULL,
  `cidade_pro` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `estadouf_pro` varchar(2) COLLATE utf8mb4_bin NOT NULL,
  `observacao_pro` text COLLATE utf8mb4_bin NOT NULL,
  `latitude_pro` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `longitude_pro` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `ativo_pro` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Despejando dados para a tabela `propriedade`
--

INSERT INTO `propriedade` (`codigo_pro`, `codigo_prop`, `codigo_vet`, `nome_pro`, `qtdequinos_pro`, `cep_pro`, `logradouro_pro`, `numero_pro`, `cidade_pro`, `estadouf_pro`, `observacao_pro`, `latitude_pro`, `longitude_pro`, `ativo_pro`) VALUES
(1, 2, 7, 'Chácara do Duzão', 18, '19020220', 'Rodovia Julio Budisk, KM 439', 193, 'Presidente Prudente', 'SP', 'Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, Teste de observação, ', NULL, NULL, 1),
(2, 2, 7, 'Teste Modal', 123, '19020220', 'Rua Antonio F Menezes', 95, 'Presidente Prudente', 'SP', '123123123123123123123', NULL, NULL, 1),
(3, 2, 7, 'Teste Modal 2', 83, '19020220', 'Rua A', 38, 'Presidente Prudente', 'SP', '123123123123123123', NULL, NULL, 1),
(4, 2, 7, 'Teste 3', 18, '19020220', 'Rua 39', 32, 'PP', 'SP', '123123123', NULL, NULL, 1),
(7, 3, 7, 'Teste V', 83, '19020220', 'RUA C', 482, 'PP', 'SP', '129389238932', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `proprietario`
--

CREATE TABLE `proprietario` (
  `codigo_prop` int(11) NOT NULL,
  `codigo_vet` int(11) NOT NULL,
  `nome_prop` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `datanascimento_prop` date NOT NULL,
  `documento_prop` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `email_prop` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `telefone_prop` varchar(25) COLLATE utf8mb4_bin NOT NULL,
  `cep_prop` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `endereco_prop` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `bairro_prop` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `numero_prop` int(11) NOT NULL,
  `cidade_prop` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `estadouf_prop` varchar(2) COLLATE utf8mb4_bin NOT NULL,
  `ativo_prop` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Despejando dados para a tabela `proprietario`
--

INSERT INTO `proprietario` (`codigo_prop`, `codigo_vet`, `nome_prop`, `datanascimento_prop`, `documento_prop`, `email_prop`, `telefone_prop`, `cep_prop`, `endereco_prop`, `bairro_prop`, `numero_prop`, `cidade_prop`, `estadouf_prop`, `ativo_prop`) VALUES
(1, 0, 'Eduardo de Oliveira Bacarin', '0000-00-00', '', 'eduardo@l8.vc', '18996359212', '19020220', 'Rua Antônio Fioravante Menezes', 'Vila Lessa', 95, 'Presidente Prudente', 'SP', 1),
(2, 7, 'Eduardo de Oliveira Bacarin', '1994-06-09', '43679305800', 'eduardo@l8.vc', '18996359212', '19020220', 'KM 12 Chácara Bacarin', 'Agrovilla 3', 12, 'Presidente Prudente ', 'SP', 1),
(3, 7, 'Luis Felipe', '1994-12-21', '43679305800', 'luis@felipe.com', '18996359212', '19020220', 'Luisão Não mora aqui', 'Mora Sim', 123, 'Presidente Prudente', 'SP', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `veterinario`
--

CREATE TABLE `veterinario` (
  `codigo_vet` int(11) NOT NULL,
  `nome_vet` varchar(250) COLLATE utf8mb4_bin NOT NULL,
  `telefone_vet` varchar(25) COLLATE utf8mb4_bin NOT NULL,
  `documento_vet` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `crmv_vet` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `email_vet` varchar(250) COLLATE utf8mb4_bin NOT NULL,
  `senha_vet` varchar(250) COLLATE utf8mb4_bin NOT NULL,
  `tipo_vet` int(11) DEFAULT 1,
  `ativo_vet` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Despejando dados para a tabela `veterinario`
--

INSERT INTO `veterinario` (`codigo_vet`, `nome_vet`, `telefone_vet`, `documento_vet`, `crmv_vet`, `email_vet`, `senha_vet`, `tipo_vet`, `ativo_vet`) VALUES
(7, 'Eduardo de Oliveira Bacarin', '18996359212', '43679305800', '', 'eduardo@l8.vc', '243b52a2d15a5668a85665ee51f2a28b2a65512271d9494283884f651ebca8b5', 1, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`codigo_ani`);

--
-- Índices de tabela `exame`
--
ALTER TABLE `exame`
  ADD PRIMARY KEY (`codigo_exa`);

--
-- Índices de tabela `laboratorio`
--
ALTER TABLE `laboratorio`
  ADD PRIMARY KEY (`codigo_lab`);

--
-- Índices de tabela `propriedade`
--
ALTER TABLE `propriedade`
  ADD PRIMARY KEY (`codigo_pro`);

--
-- Índices de tabela `proprietario`
--
ALTER TABLE `proprietario`
  ADD PRIMARY KEY (`codigo_prop`);

--
-- Índices de tabela `veterinario`
--
ALTER TABLE `veterinario`
  ADD PRIMARY KEY (`codigo_vet`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `animal`
--
ALTER TABLE `animal`
  MODIFY `codigo_ani` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `exame`
--
ALTER TABLE `exame`
  MODIFY `codigo_exa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `laboratorio`
--
ALTER TABLE `laboratorio`
  MODIFY `codigo_lab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `propriedade`
--
ALTER TABLE `propriedade`
  MODIFY `codigo_pro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `proprietario`
--
ALTER TABLE `proprietario`
  MODIFY `codigo_prop` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `veterinario`
--
ALTER TABLE `veterinario`
  MODIFY `codigo_vet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
