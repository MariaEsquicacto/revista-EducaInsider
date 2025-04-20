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
         body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f8;
            color: #333;
        }

        .conteudo {
            width: 80%;
            margin: 50px auto;
            background: #ffffff;
            padding: 40px 50px;
            border-radius: 16px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        }

        .conteudo img {
            max-width: 100%;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .conteudo h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #1e3a8a;
            border-left: 5px solid #3b82f6;
            padding-left: 15px;
        }

        .conteudo h2 {
            font-size: 20px;
            color: #555;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .conteudo p {
            text-align: justify;
            line-height: 1.8;
            font-size: 17px;
        }

        /* Botão fictício para futura navegação ou ação */
        .btn-voltar {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            background-color: #3b82f6;
            color: #fff;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-voltar:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="conteudo">
        <h1 style="color: <?= $corMateria?>;"><?= htmlspecialchars($postagem['titulo']) ?></h1>
        <h2><?= htmlspecialchars($postagem['subtitulo']) ?></h2>
        <img src="uploads/<?= $postagem['imagem'] ?>" alt="Imagem da postagem">
        <p><?= nl2br(htmlspecialchars($postagem['conteudo'])) ?></p>
        <a class="btn-voltar" href="home.php" style="color: <?= $corMateria?>;">← Voltar</a>
    </div>
</body>
</html>
