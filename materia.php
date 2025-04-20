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

$coresMateria = [
    'Português' => '#4496d9',
    'Matemática' => '#f6a174',
    'História' => '#cf803a',
    'Geografia' => '#81F69F',
    'Ciências' => '#75d500',
    'Sociologia' => '#ee657c',
    'Filosifia' => '#f385d0',
    'Artes' => '#ffc62a',
    'Ingles' => '#FF6767',
    'Química' => '#cba0ff',
    'Física' => '#6ccf6c',
    'Educação Física' => '#7cb4e2',
    // adicione mais conforme necessário
];
$corMateria = $coresMateria[$nomeMateria] ?? '#002a77';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($nomeMateria) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&family=Sigmar&display=swap"
        rel="stylesheet">
    <style>
        * {
            padding: 0;
            margin: 0;
        }
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
            /* background-color: #002a77; */
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            color: #002a77;
        }

        /* Questão */
        .quest .container>div {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.18);
            width: 100%;
            
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
        .voltar{
            width: 100%;
            display: flex;
            justify-content: start;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="title" style="background-color: <?= $corMateria ?>;">
    <div class="voltar">
        <p onclick="voltarhome()"><i class="bi bi-arrow-left-circle"></i></p>
    </div>
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
            <h2 style="color: <?= $corMateria ?>;">Questões</h2>

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
                            <button type="submit" style="background-color: <?= $corMateria ?>;">Responder</button>
                            <p class="feedback"></p>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </article>

    <div class="img2">
        <div class="container1">
            <div class="shape" id="lateral"></div>
            <div class="shape" id="baixo"></div>
        </div>

    </div>


    <script>
        // Lógica de feedback para respostas corretas ou erradas
        document.querySelectorAll('.form-questao').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const selecionada = form.querySelector('input[type="radio"]:checked');
                const feedback = form.querySelector('.feedback');
                if (!selecionada) {
                    feedback.textContent = "Escolha uma alternativa.";
                    feedback.style.color = 'orange';
                    return;
                }

                if (selecionada.dataset.correta === "1") {
                    feedback.textContent = "✅ Resposta correta!";
                    feedback.style.color = 'green';
                } else {
                    const explicacao = form.dataset.explicacao;
                    feedback.innerHTML = "❌ Resposta errada.<br><strong>Explicação:</strong> " + explicacao;
                    feedback.style.color = 'red';
                }
            });
        });

        function voltarhome(){
            window.location.href = "home.php"
        }
    </script>
</body>

</html>