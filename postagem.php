<?php
include 'db/conexao.php';

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    echo "ID inválido.";
    exit;
}

$sql = $conn->prepare("SELECT p.*, m.nome AS nome_materia FROM postagens p 
                       JOIN materias m ON p.materia_id = m.id
                       WHERE p.id = ? AND p.status = 'aprovado'");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$postagem = $result->fetch_assoc();

if (!$postagem) {
    echo "Postagem não encontrada ou ainda não foi aprovada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($postagem['titulo']) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .conteudo {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        .conteudo img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .conteudo h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .conteudo h2 {
            font-size: 20px;
            color: #555;
            margin-bottom: 20px;
        }

        .conteudo p {
            text-align: justify;
            line-height: 1.7;
        }
    </style>
</head>
<body>
    <div class="conteudo">
        <h1><?= htmlspecialchars($postagem['titulo']) ?></h1>
        <h2><?= htmlspecialchars($postagem['subtitulo']) ?></h2>
        <img src="uploads/<?= $postagem['imagem'] ?>" alt="Imagem da postagem">
        <p><?= nl2br(htmlspecialchars($postagem['conteudo'])) ?></p>
    </div>
</body>
</html>
