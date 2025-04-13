<?php
include 'db/conexao.php';

$nomeMateria = $_GET['materia'] ?? '';

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

// Buscar postagens aprovadas
$sqlPostagens = $conn->prepare("SELECT * FROM postagens WHERE materia_id = ? AND status = 'aprovado' ORDER BY id DESC");
$sqlPostagens->bind_param("i", $materiaId);
$sqlPostagens->execute();
$postagens = $sqlPostagens->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($nomeMateria) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h1><?= htmlspecialchars($nomeMateria) ?></h1>
    <div class="container">
        <?php while ($postagem = $postagens->fetch_assoc()): ?>
            <div class="card">
                <a href="postagem.php?id=<?= $postagem['id'] ?>">
                    <img src="uploads/<?= $postagem['imagem'] ?>" alt="Imagem da postagem">
                    <h2><?= htmlspecialchars($postagem['titulo']) ?></h2>
                    <p><?= htmlspecialchars($postagem['subtitulo']) ?></p>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
