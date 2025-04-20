-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/04/2025 às 22:44
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
-- Banco de dados: `api`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alternativas`
--

CREATE TABLE `alternativas` (
  `id` int(11) NOT NULL,
  `questao_id` int(11) DEFAULT NULL,
  `texto` varchar(255) DEFAULT NULL,
  `correta` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alternativas`
--

INSERT INTO `alternativas` (`id`, `questao_id`, `texto`, `correta`) VALUES
(1, 1, 'ssssssssssssssssss', 1),
(2, 1, 'aaaaaaaaaaaaaaa', 0),
(3, 1, 'ccccccccccccc', 0),
(4, 1, 'ddddddddddddd', 0),
(5, 2, 'cccccccccccccc', 1),
(6, 2, 'sssssssssss', 0),
(7, 2, 'dddddddddddd', 0),
(8, 2, 'aaaaaaaaaaaaaaa', 0),
(9, 3, 'sssssssssss', 1),
(10, 3, 'ccccccccccccc', 0),
(11, 3, 'sssssssssss', 0),
(12, 3, 'dddddddddddddddd', 0),
(13, 4, 'eeeeeeeeee', 1),
(14, 4, 'eeeeeeeeeeee', 0),
(15, 4, 'eeeeeeeeeeeee', 0),
(16, 4, 'eeeeeeeeeee', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `livros`
--

CREATE TABLE `livros` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `sinopse` text DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `link_compra` varchar(255) DEFAULT NULL,
  `disponibilidade` enum('escrito','possui na biblioteca escolar','não possui na biblioteca escolar') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livros`
--

INSERT INTO `livros` (`id`, `nome`, `autor`, `sinopse`, `imagem`, `link_compra`, `disponibilidade`) VALUES
(1, 'Dom Casmurro', 'Machado de Assis', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.amazon.com.br%2FDom-Casmurro-Machado-Assis%2Fdp%2F859431860X&psig=AOvVaw358JgWt3h6MeiQ0IatdqS4&ust=1745188443390000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCNCpjOOT5YwDFQAAAAAdAAAAABAE', 'https://www.amazon.com.br/Dom-Casmurro-Machado-Assis/dp/859431860X', ''),
(2, 'professor368', 'Machado de Assis', 'aaaaaaaaaaaaaaaaaaaaaaaaa', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.amazon.com.br%2FDom-Casmurro-Machado-Assis%2Fdp%2F859431860X&psig=AOvVaw358JgWt3h6MeiQ0IatdqS4&ust=1745188443390000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCNCpjOOT5YwDFQAAAAAdAAAAABAE', 'https://www.amazon.com.br/Dom-Casmurro-Machado-Assis/dp/859431860X', ''),
(3, 'Dom Casmurro', 'Machado de Assis', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'uploads/68042c846a935_lavoisier.jpg', 'https://www.amazon.com.br/Dom-Casmurro-Machado-Assis/dp/859431860X', ''),
(4, 'professor368', 'Machado de Assis', 'bbbbbbbbbbbbbbbbbbbbbbbb', 'uploads/68042d9105be3_proust.jpg', 'https://www.amazon.com.br/Dom-Casmurro-Machado-Assis/dp/859431860X', ''),
(5, 'professor1', 'Machado de Assis', 'aaaaaaaaaaaaaa', 'uploads/68042dd631ce7_3337c7b1795424d4eb37ae3787d8a33d.jpg', 'https://www.amazon.com.br/Dom-Casmurro-Machado-Assis/dp/859431860X', ''),
(6, 'Maria Clara', 'Machado de Assis', 'bbbbbbbbbbbbb', 'uploads/68042ffab328c_3337c7b1795424d4eb37ae3787d8a33d.jpg', 'https://www.amazon.com.br/Dom-Casmurro-Machado-Assis/dp/859431860X', ''),
(7, 'bbbbbbbbbbbb', 'Machado de Assis', 'vgggggvvvvvv', 'uploads/680430e013530_bioeletricidade. prova de ciencias.jpg', 'https://www.amazon.com.br/Dom-Casmurro-Machado-Assis/dp/859431860X', ''),
(8, 'professor1', 'Machado de Assis', 'aaaaaaaaaaaaaaa', 'uploads/680431da93305_c19c9e7239416658b76c8270a5fcca92.jpg', 'https://www.amazon.com.br/Dom-Casmurro-Machado-Assis/dp/859431860X', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `materias`
--

INSERT INTO `materias` (`id`, `nome`) VALUES
(1, 'Português'),
(2, 'Matemática'),
(3, 'História'),
(4, 'Geografia'),
(5, 'Biologia'),
(6, 'Física'),
(7, 'Química'),
(8, 'Inglês'),
(9, 'Educação Física'),
(10, 'Sociologia'),
(11, 'Filosofia'),
(12, 'Artes');

-- --------------------------------------------------------

--
-- Estrutura para tabela `postagens`
--

CREATE TABLE `postagens` (
  `id` int(11) NOT NULL,
  `materia_id` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `subtitulo` varchar(255) DEFAULT NULL,
  `conteudo` text DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `status` enum('pendente','aprovado','reprovado') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `postagens`
--

INSERT INTO `postagens` (`id`, `materia_id`, `titulo`, `subtitulo`, `conteudo`, `imagem`, `status`) VALUES
(1, 2, 'Equacoes', 'aaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaa', '67fbb486e5493-lavoisier.jpg', 'aprovado'),
(2, 2, 'Cilo', 'aaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '67fbb508219d3-3337c7b1795424d4eb37ae3787d8a33d.jpg', 'aprovado'),
(3, 3, 'Guerras', 'aaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '67fbb80a2af46-bioeletricidade. prova de ciencias.jpg', 'aprovado'),
(4, 1, 'Literatura', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb', '67fbd3e8d53fa-c19c9e7239416658b76c8270a5fcca92.jpg', 'reprovado'),
(5, 1, 'Literatura', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb', '67fbd404ca06d-c19c9e7239416658b76c8270a5fcca92.jpg', 'reprovado'),
(6, 1, 'Literatura', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb', '67fbd40c07225-c19c9e7239416658b76c8270a5fcca92.jpg', 'aprovado'),
(7, 2, 'Equacoes', 'aaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaa', '6802b113ae8b1-3337c7b1795424d4eb37ae3787d8a33d.jpg', 'aprovado'),
(8, 11, 'Filosofia', 'Filosofia, no seu sentido mais amplo, é o estudo de questões fundamentais sobre a existência, conhecimento, valores, razão, mente e linguagem', 'É uma atividade do pensamento que busca entender a realidade e o lugar do ser humano nela, questionando e refletindo sobre questões como o sentido da vida, a natureza da realidade, a moralidade e a verdade. \r\nElaboração:\r\nA filosofia, do grego \"philosophia\" (φιλοσοφία), significa \"amor à sabedoria\" ou \"amor pelo conhecimento\". Ela se distingue de outras áreas do conhecimento, como as ciências, pela sua abordagem mais ampla e reflexiva, buscando a compreensão geral dos problemas, em vez de soluções específicas. \r\nPrincipais áreas da filosofia:\r\nMetafísica: Estuda a natureza da realidade e questões como a existência de Deus, a natureza do universo e a existência de um plano superior.\r\nLógica: Estuda os princípios do raciocínio correto e da argumentação.\r\nÉtica: Estuda a moralidade e os valores, procurando definir o que é certo e errado.\r\nEstética: Estuda a beleza e o gosto artístico.\r\nTeoria do Conhecimento: Estuda a natureza do conhecimento, como o conhecemos e o que podemos saber com certeza.\r\nFilosofia da Ciência: Analisa a natureza do método científico e os limites do conhecimento científico.\r\nFilosofia Política: Estuda as questões políticas e sociais, como o governo, os direitos humanos e a justiça social.\r\nAntropologia Filosófica: Estuda a natureza humana e questões sobre a existência, a liberdade e o propósito da vida.\r\nFilosofia da Natureza: Estuda a natureza e a origem do universo. \r\nOrigem e evolução da filosofia:\r\nA filosofia surgiu na Grécia Antiga, no século VI a.C., com pensadores como Tales de Mileto, que foi considerado o primeiro filósofo. A filosofia antiga teve como principais figuras Platão e Aristóteles, cujos pensamentos influenciaram a filosofia ocidental por séculos. A filosofia medieval foi dominada pela filosofia cristã, com pensadores como São Tomás de Aquino. A filosofia moderna se caracteriza pelo racionalismo, com pensadores como René Descartes, e pelo empirismo, com pensadores como John Locke. A filosofia contemporânea é marcada por uma grande diversidade de correntes de pensamento, como o existencialismo, o estruturalismo e o pós-estruturalismo. \r\nImportância da filosofia:\r\nA filosofia é importante para o desenvolvimento do pensamento crítico, da capacidade de análise e da tomada de decisões. Ela contribui para a compreensão do mundo e da nossa própria existência, e para a construção de uma sociedade mais justa e humana. ', '68051ebc409ba-filosofia.png', 'aprovado'),
(9, 5, 'bbbbbbbbbbbbbbbb', 'ssssssssssssssss', 'ssssssssssssssssssssss', '680549aa7c635-ingles.png', 'reprovado'),
(10, 5, 'Equacoes', 'rrrrrrrrrrrrrrr', 'rrrrrrrrrrrrrrrr', '680549f8d4c6d-livro.png', 'reprovado'),
(11, 7, 'aaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaa', '68054caa28f61-filosofia.png', 'pendente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `questoes`
--

CREATE TABLE `questoes` (
  `id` int(11) NOT NULL,
  `materia_id` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `enunciado` text DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `explicacao` text DEFAULT NULL,
  `tema` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `questoes`
--

INSERT INTO `questoes` (`id`, `materia_id`, `titulo`, `enunciado`, `imagem`, `explicacao`, `tema`) VALUES
(1, 2, 'Equacoes', 'aaaaaaaaaaaaaaaaaaaaa', NULL, 'ssssssssssssssssss', NULL),
(2, 1, 'bbbbbbbbbbbbbbbb', 'bbbbbbbbbbbbbbbbbbbb', NULL, 'ccccccccccccc', 'ddddd'),
(3, 2, 'sdcsdcsdc', 'ssssssssssssssssssssssss', NULL, 'ssssssssssssssssssssssss', 'ddddd'),
(4, 12, 'eeeeeeeeeeeee', 'eeeeeeeeeeeeeeee', NULL, 'eeeeeeeeeeeeeee', 'eeeeeeeeeeeee');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel` enum('usuario','Professor','Dev') DEFAULT 'usuario',
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `senha`, `nivel`, `foto`) VALUES
(14, 'dev368', '$2y$10$EmW.tDZYsdq5evaBB4KXIuMFnfgFBZnB87IzeGIL19Gk3gG9hHHf.', 'Dev', 'fotos_perfil/lavoisier.jpg'),
(15, 'Maria ', '$2y$10$MsMO.YMlbzxAt0FzCvsn6.2.xxWvMkI3jh.9U3.w.flUyZn/vIOaa', 'usuario', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alternativas`
--
ALTER TABLE `alternativas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questao_id` (`questao_id`);

--
-- Índices de tabela `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `postagens`
--
ALTER TABLE `postagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Índices de tabela `questoes`
--
ALTER TABLE `questoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alternativas`
--
ALTER TABLE `alternativas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `postagens`
--
ALTER TABLE `postagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `questoes`
--
ALTER TABLE `questoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `alternativas`
--
ALTER TABLE `alternativas`
  ADD CONSTRAINT `alternativas_ibfk_1` FOREIGN KEY (`questao_id`) REFERENCES `questoes` (`id`);

--
-- Restrições para tabelas `postagens`
--
ALTER TABLE `postagens`
  ADD CONSTRAINT `postagens_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

--
-- Restrições para tabelas `questoes`
--
ALTER TABLE `questoes`
  ADD CONSTRAINT `questoes_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
