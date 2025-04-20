<?php
include 'db/conexao.php';

session_start();
if (!isset($_SESSION['nome'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'api');
$nome = $_SESSION['nome'];
$nivel = $_SESSION['nivel'];

// Busca a foto do usuário
$sql = "SELECT foto, nivel FROM usuarios WHERE nome = '$nome'";
$result = $conn->query($sql);
$usuario = $result->fetch_assoc();
$foto = $usuario['foto'];
$nivel = $usuario['nivel'];

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tema = $_POST['tema'];
    $materia_id = $_POST['materia'] ?? '';
    $titulo = $_POST['titulo'] ?? '';
    $enunciado = $_POST['enunciado'] ?? '';
    $explicacao = $_POST['explicacao'] ?? '';
    $imagem = $_FILES['imagem'] ?? null;
    $alternativas = $_POST['alternativas'] ?? [];
    $correta = $_POST['correta'] ?? '';

    if ($materia_id && $titulo && $enunciado && count($alternativas) >= 2) {
        $nomeImagem = null;
        if ($imagem && $imagem['tmp_name']) {
            $nomeImagem = uniqid() . "-" . basename($imagem['name']);
            move_uploaded_file($imagem['tmp_name'], "uploads/" . $nomeImagem);
        }

        // Inserir a questão
        $stmt = $conn->prepare("INSERT INTO questoes (tema, materia_id, titulo, enunciado, imagem, explicacao) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissss", $tema, $materia_id, $titulo, $enunciado, $nomeImagem, $explicacao);
        $stmt->execute();
        $questao_id = $stmt->insert_id;

        // Inserir as alternativas
        foreach ($alternativas as $i => $texto) {
            $texto = trim($texto);
            if ($texto) {
                $correta_bool = ($i == $correta) ? 1 : 0;
                $stmtAlt = $conn->prepare("INSERT INTO alternativas (questao_id, texto, correta) VALUES (?, ?, ?)");
                $stmtAlt->bind_param("isi", $questao_id, $texto, $correta_bool);
                $stmtAlt->execute();
            }
        }

        $mensagem = "Questão criada com sucesso!";
    } else {
        $mensagem = "Preencha todos os campos corretamente!";
    }
}


$materias = $conn->query("SELECT id, nome FROM materias ORDER BY nome ASC");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Questão</title>
    <link rel="stylesheet" href="assets/css/criar_questao.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&family=Sigmar&display=swap"
        rel="stylesheet">
    <style>
        main {
            width: 100%;
            height: 100%;
        }

        .tudo {
            width: 90%;
            height: 100%;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
        }

        .usuario {
            width: 30%;
            margin-bottom: 50%;
            margin-left: 15%;
        }

        .foto #fotoperfil {
            width: 200px;
            height: 200px;
            border-radius: 50%;
        }

        .info {
            margin-top: 0;
            width: 90%;
            display: block;
            margin: 0 30px;
        }

        .info p {
            margin: 0;
            border: none;
            font-size: 40px;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        .info #nivel {
            font-size: 15px;
            background-color: #002a77;
            color: #fff;
            width: 100px;
            border-radius: 10px;
            text-align: center;
            padding: 5px;
            margin-left: 3%;
        }

        .formulario {
            width: 50%;
            border: 1px solid #002a77;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        .formulario button {
            width: 100%;
            background: #002a77;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .formulario button:hover {
            background: #1b386e;
        }

        h2,
        h3 {
            font-size: 25px;
            color: #002a77;
            font-family: Arial, Helvetica, sans-serif;
        }

        h3 {
            font-size: 19px;
        }

        .formulario label {
            /* display: block; */
            margin-top: 15px;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        .mensagem {
            font-family: 'Courier New', Courier, monospace;
            /* text-align: center; */
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }

        .formulario input,
        .formulario select,
        .formulario textarea {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 2px solid #000330;
        }

        #alternativas {
            width: 250px;
            padding: 5px;
        }

        .voltar button {
            font-size: 30px;
            border: none;
            padding: 10px;
            margin: 10px 50px;
            transition: 0.3s ease-in-out;
            cursor: pointer;
            background-color: #fff;
            height: 20px;
        }

        .voltar button:hover {
            transform: scale(1.02);
        }

        @media (max-width: 480px) {
            header {
                height: 50px;
            }

            nav {
                width: 90%;
                margin-top: 0;
            }

            .nav-list {
                gap: 20px;
            }

            .nav-list h3 {
                font-size: 17px;
            }

            .nav-list p {
                font-size: 15px;
                margin-left: 4px;
            }

            .nav-list li {
                width: 60%;
            }

            a {
                font-size: 12px;
            }

            main {
                width: 100%;
                height: 100%;
            }

            .tudo {
                width: 90%;
                height: 100%;
                display: flex;
                justify-content: space-evenly;
                align-items: center;
                flex-wrap: wrap;
                /* permite quebra de linha */
                margin: 0 auto;
                gap: 30px;
            }

            .usuario {
                width: 30%;
                margin-bottom: 50%;
                margin-left: 15%;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .foto {
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .foto #fotoperfil {
                width: 150px;
                height: 150px;
                border-radius: 50%;
            }

            .info {
                margin-top: 0;
                width: 90%;
                display: block;
                margin: 0 20px;
            }

            .info p {
                margin: 0;
                border: none;
                font-size: 40px;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
            }

            .info #nivel {
                font-size: 15px;
                background-color: #002a77;
                color: #fff;
                width: 100px;
                border-radius: 10px;
                text-align: center;
                padding: 5px;
                margin-left: 3%;
            }

            .formulario {
                width: 50%;
                border: 1px solid #002a77;
                margin: 30px auto;
                background: white;
                padding: 25px;
                border-radius: 10px;
            }

            .formulario button {
                width: 100%;
                background: #002a77;
                color: white;
                padding: 12px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-size: 16px;
                margin-top: 20px;
            }

            .formulario button:hover {
                background: #1b386e;
            }

            h2,
            h3 {
                font-size: 25px;
                color: #002a77;
                font-family: Arial, Helvetica, sans-serif;
            }

            h3 {
                font-size: 19px;
            }

            .formulario label {
                margin-top: 15px;
                font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            }

            .mensagem {
                font-family: 'Courier New', Courier, monospace;
                color: green;
                font-weight: bold;
                margin-top: 20px;
            }

            .formulario input,
            .formulario select,
            .formulario textarea {
                width: 95%;
                padding: 10px;
                margin-top: 5px;
                border-radius: 6px;
                border: 2px solid #000330;
            }

            #alternativas {
                width: 250px;
                padding: 5px;
            }

            /* RESPONSIVIDADE */
            @media (max-width: 992px) {
                .usuario {
                    width: 45%;
                    margin-left: 0;
                    margin-bottom: 30px;
                }

                .formulario {
                    width: 80%;
                }

                .info p {
                    font-size: 30px;
                }
            }

            @media (max-width: 600px) {
                .tudo {
                    flex-direction: column;
                    align-items: center;
                }

                .usuario,
                .formulario {
                    width: 90%;
                    margin: 0 auto 30px auto;
                }

                .foto #fotoperfil {
                    width: 150px;
                    height: 150px;
                }

                .info p {
                    font-size: 24px;
                    text-align: center;
                }

                .info #nivel {
                    margin: 10px auto;
                }
            }

        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="imagem">
            </div>
            <ul class="nav-list">
                <li>
                    <a href="#" onclick="abrir()" class="menu-button">MENU</a>
                </li>
                <li><a href="home.php">HOME</a></li>

                <div class="logo">
                    <h3>EDUCA</h3>
                    <p id="insider">insider</p>
                    <!-- <img src="" alt="livro">  -->
                </div>

                <li><a href="perfil.php">PERFIL</a></li>
                <li><a href="mostrar_livro.php">LIVROS</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="voltar">
            <button type="submit" onclick="voltar()"><i class="bi bi-arrow-left-circle-fill"></i></button>
        </div>
        <section class="tudo">
            <section class="usuario">
                <div class="foto">
                    <?php if ($foto): ?>
                        <img id="fotoperfil" src="<?php echo $foto; ?>" alt="Foto de Perfil">
                    <?php endif; ?>
                </div>
                <div class="info">
                    <p> <?php echo $_SESSION['nome']; ?></p>
                    <p id="nivel"> Nível:<?= htmlspecialchars($nivel) ?></p>
                </div>

            </section>

            <div class="formulario">
                <h2>Criar Questão</h2>
                <?php if ($mensagem): ?>
                    <p class="mensagem"><?= $mensagem ?></p>
                <?php endif; ?>
                <form method="POST" enctype="multipart/form-data">
                    <label>Matéria:</label>
                    <select name="materia" required>
                        <option value="">Selecione</option>
                        <?php while ($m = $materias->fetch_assoc()): ?>
                            <option value="<?= $m['id'] ?>"><?= $m['nome'] ?></option>
                        <?php endwhile; ?>
                    </select><br><br>

                    <label for="tema">Tema:</label>
                    <input type="text" id="tema" name="tema" required>

                    <label>Título:</label>
                    <input type="text" name="titulo" required><br><br>

                    <label>Enunciado:</label>
                    <textarea name="enunciado" required></textarea><br><br>

                    <label>Imagem (opcional):</label>
                    <input type="file" name="imagem" accept="image/*"><br><br>

                    <label>Explicação (mostrada se errar):</label>
                    <textarea name="explicacao" required></textarea><br><br>

                    <h3>Alternativas</h3>
                    <?php for ($i = 0; $i < 4; $i++): ?>
                        <label>
                            <input id="alternativas" type="radio" name="correta" value="<?= $i ?>" required>
                            <input id="alternativas" type="text" name="alternativas[]" required placeholder="Texto da alternativa">
                        </label><br>
                    <?php endfor; ?>

                    <br><button type="submit">Salvar Questão</button>
                </form>
            </div>
        </section>

    </main>



    <script>
        for (let i = 0; i < 1000; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            document.querySelector('header').appendChild(star); // ✅ Agora as estrelas estão no header
            star.style.left = `${Math.random() * 100}vw`;
            star.style.top = `${Math.random() * 84}px`; // 🔹 Mantém as estrelas dentro da altura do header
            star.style.width = `${Math.random() * 2 + 0.1}px`;
            star.style.height = star.style.width;
            star.style.animationDuration = `${Math.random() * 3 + 2}s`;
        }

        document.header.style.backgroundColor = "#000330";

        function voltar() {
            window.location.href = "perfil.php"
        }
    </script>
</body>

</html>