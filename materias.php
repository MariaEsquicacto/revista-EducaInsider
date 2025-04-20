<!-- materias.php -->
<?php
$materias = [
    ['nome' => 'Português', 'imagem' => 'portugues.png', 'cor' => '#4496d9'],
    ['nome' => 'Matemática', 'imagem' => 'matematica.png', 'cor' => '#f6a174'],
    ['nome' => 'História', 'imagem' => 'historia.png', 'cor' => '#cf803a'],
    ['nome' => 'Geografia', 'imagem' => 'geografia.png', 'cor' => '#81F69F'],
    ['nome' => 'Sociologia', 'imagem' => 'sociologia.png', 'cor' => '#ee657c;'],
    ['nome' => 'Filosofia', 'imagem' => 'filosofia.png', 'cor' => '#f385d0'],
    ['nome' => 'Artes', 'imagem' => 'artes.png', 'cor' => '#ffc62a'],
    ['nome' => 'Ingles', 'imagem' => 'ingles.png', 'cor' => '#FF6767;'],
    ['nome' => 'Química', 'imagem' => 'quimica.png', 'cor' => '#cba0ff;'],
    ['nome' => 'Física', 'imagem' => 'fisica.png', 'cor' => '#6ccf6c;'],
    ['nome' => 'Biologia', 'imagem' => 'biologia.png', 'cor' => '#75d500'],
    ['nome' => 'Educação Fisica', 'imagem' => 'educacaofi.png', 'cor' => '#7cb4e2'],
];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Matérias</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* * {
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            padding: 0;
        } */

        /* h1 {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            font-size: 25px;
            margin-top: 10px;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 30px;
            justify-items: center;
        }

        .card {
            width: 150px;
            height: 150px;
            background-color: #ccc;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card h2 {
            font-size: 16px;
            margin-top: 10px;
            color: #000330;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        .card a {
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card img {
            width: 90px;
            height: 90px;
        }

        .inicio {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: start;
            margin-left: 5%;
            margin-top: 5%;
        }

        hr {
            width: 70%;
            height: 1px;
            background-color: #000330;
            margin-left: 2%;
            margin-bottom: 0px;
        } */
        h1 {
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    font-size: 25px;
    margin-top: 10px;
}

.container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    padding: 30px;
    justify-items: center;
}

.card {
    width: 150px;
    height: 150px;
    background-color: #ccc;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.card:hover {
    transform: scale(1.05);
}

.card h2 {
    font-size: 16px;
    margin-top: 10px;
    color: #000330;
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
}

.card a {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.card img {
    width: 90px;
    height: 90px;
}

.inicio {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: start;
    margin-left: 5%;
    margin-top: 5%;
}

hr {
    width: 70%;
    height: 1px;
    background-color: #000330;
    margin-left: 2%;
    margin-bottom: 0px;
}

/* RESPONSIVIDADE */
@media (max-width: 992px) {
    .container {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .container {
        grid-template-columns: repeat(1, 1fr);
    }

    .card {
        width: 80%;
        height: auto;
        padding: 20px;
    }

    .card img {
        width: 70px;
        height: 70px;
    }

    .card h2 {
        font-size: 14px;
        text-align: center;
    }
}

    </style>
</head>

<body>
    <div class="inicio">
        <h1>Matérias Escolares</h1>
        <hr>
    </div>

    <div class="container">
        <?php foreach ($materias as $materia): ?>
            <div class="card" style="background-color: <?= $materia['cor'] ?>;">
                <a href="materia.php?materia=<?= urlencode($materia['nome']) ?>">
                    <img src="assets/img/<?= $materia['imagem'] ?>" alt="<?= $materia['nome'] ?>">
                    <h2><?= $materia['nome'] ?></h2>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>