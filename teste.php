<?php
include 'db/conexao.php';

$nomeMateria = $_GET['materia'] ?? '';

// Buscar o ID da matéria
$sqlMateria = $conn->prepare("SELECT id FROM materias WHERE nome = ?");
$sqlMateria->bind_param("s", $nomeMateria);
$sqlMateria->execute();
$resultMateria = $sqlMateria->get_result();
$materia = $resultMateria->fetch_assoc();

if (!$materia) {
    echo "Matéria não encontrada.";
    exit;
}

$materiaId = $materia['id'];

// Buscar questões e alternativas
$pesquisa = $_GET['pesquisa'] ?? '';
$sqlQuestao = "SELECT * FROM questoes WHERE materia_id = ?";

if ($pesquisa) {
    $sqlQuestao .= " AND tema LIKE ?";
    $pesquisa = "%$pesquisa%"; // Adiciona o % para buscar por qualquer ocorrência do termo
}

$stmtQuestao = $conn->prepare($sqlQuestao);
if ($pesquisa) {
    $stmtQuestao->bind_param("is", $materiaId, $pesquisa);
} else {
    $stmtQuestao->bind_param("i", $materiaId);
}

$stmtQuestao->execute();
$resultadoQuestao = $stmtQuestao->get_result();

// Buscar postagens aprovadas
$sqlPostagens = $conn->prepare("SELECT * FROM postagens WHERE materia_id = ? AND status = 'aprovado' ORDER BY id DESC");
$sqlPostagens->bind_param("i", $materiaId);
$sqlPostagens->execute();
$postagens = $sqlPostagens->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Estilo geral */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f8f9fa;
    margin: 0;
    padding: 0;
    color: #333;
}

/* Título da matéria */
.title {
    text-align: center;
    padding: 40px 20px 20px;
    background-color: #2c3e50;
    color: white;
}

.title h1 {
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.title p {
    font-size: 1.2rem;
    font-weight: 300;
    color: #ecf0f1;
}

/* Container geral */
.container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    padding: 30px 10px;
}

/* Cards de postagens */
.card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    width: 280px;
    text-align: center;
}

.card:hover {
    transform: translateY(-5px);
}

.card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.card h2 {
    font-size: 1.2rem;
    margin: 15px;
    color: #2c3e50;
}

/* Seção de Questões */
.quest {
    padding: 20px;
    background: #eef2f3;
}

.quest h2 {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 30px;
    color: #34495e;
}

/* Questão */
.quest .container > div {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    width: 100%;
    max-width: 700px;
}

/* Estilo do formulário */
.form-questao {
    margin-top: 15px;
}

.form-questao div {
    margin: 10px 0;
}

.form-questao input[type="radio"] {
    margin-right: 10px;
}

.form-questao button {
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #3498db;
    border: none;
    border-radius: 6px;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.form-questao button:hover {
    background-color: #2980b9;
}

/* Feedback da resposta */
.feedback {
    margin-top: 10px;
    font-weight: bold;
    color: #27ae60;
}

    </style>
</head>
<body>
    <div class="title">
        <h1><?= htmlspecialchars($nomeMateria) ?></h1>
        <p>CONTEÚDOS</p>
    </div>

    <article>
        <div class="container">
            <!-- Exibição das Postagens -->
            <?php while ($postagem = $postagens->fetch_assoc()): ?>
                <div class="card">
                    <a href="postagem.php?id=<?= $postagem['id'] ?>">
                        <img src="uploads/<?= $postagem['imagem'] ?>" alt="Imagem da postagem">
                        <h2><?= htmlspecialchars($postagem['titulo']) ?></h2>
                        <!-- <p><?= htmlspecialchars($postagem['subtitulo']) ?></p> -->
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    

    <section class="quest">
    <!-- Exibição das Questões -->
    <h2 >Questões</h2>

    <div class="container">
        <?php while ($questao = $resultadoQuestao->fetch_assoc()): ?>
            <div style="margin: 20px; padding: 20px; background: #f0f0f0; border-radius: 10px;">
                <h3><?= htmlspecialchars($questao['enunciado']) ?></h3>
                <p><strong>Tema:</strong> <?= htmlspecialchars($questao['tema']) ?></p>

                <!-- Formulário de Resposta -->
                <form class="form-questao" data-explicacao="<?= htmlspecialchars($questao['explicacao']) ?>">
                    <?php
                    // Buscar alternativas
                    $questaoId = $questao['id'];
                    $sqlAlternativas = $conn->prepare("SELECT * FROM alternativas WHERE questao_id = ?");
                    $sqlAlternativas->bind_param("i", $questaoId);
                    $sqlAlternativas->execute();
                    $resAlternativas = $sqlAlternativas->get_result();

                    while ($alt = $resAlternativas->fetch_assoc()): ?>
                        <div>
                            <input type="radio" name="resposta_<?= $questaoId ?>" value="<?= $alt['id'] ?>" data-correta="<?= $alt['correta'] ? '1' : '0' ?>">
                            <?= htmlspecialchars($alt['texto']) ?>
                        </div>
                    <?php endwhile; ?>
                    <button type="submit">Responder</button>
                    <p class="feedback"></p>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
    </section>
    </article>
</body>
</html>