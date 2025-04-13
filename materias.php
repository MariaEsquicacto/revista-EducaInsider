<!-- materias.php -->
<?php
$materias = [
    ['nome' => 'Português', 'imagem' => 'portugues.jpg'],
    ['nome' => 'Matemática', 'imagem' => 'matematica.jpg'],
    ['nome' => 'História', 'imagem' => 'historia.jpg'],
    ['nome' => 'Geografia', 'imagem' => 'geografia.jpg'],
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Matérias</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h1>Escolha uma matéria</h1>
    <div class="container">
        <?php foreach ($materias as $materia): ?>
            <div class="card">
                <a href="materia.php?materia=<?= urlencode($materia['nome']) ?>">
                    <img src="assets/img/<?= $materia['imagem'] ?>" alt="<?= $materia['nome'] ?>">
                    <h2><?= $materia['nome'] ?></h2>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
