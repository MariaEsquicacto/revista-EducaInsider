<?php
// Conexão com o banco de dados
include 'db/conexao.php'; // Supondo que você já tenha essa variável $conn

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inicializando a variável de mensagem
    $mensagem = '';

    // Validar campos obrigatórios
    $campos = ['nome', 'autor', 'sinopse', 'imagem', 'link_compra', 'disponibilidade'];
    foreach ($campos as $campo) {
        if (empty($_POST[$campo]) && $campo !== 'imagem') {
            $mensagem = "<p class='erro'>O campo '$campo' é obrigatório.</p>";
            echo $mensagem;
            return;
        }
    }

    // Verificar se o arquivo de imagem foi enviado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagemTmp = $_FILES['imagem']['tmp_name'];
        $imagemNome = $_FILES['imagem']['name'];
        $imagemTipo = $_FILES['imagem']['type'];
        $imagemTamanho = $_FILES['imagem']['size'];

        // Validar tipo e tamanho da imagem
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($imagemTipo, $tiposPermitidos)) {
            $mensagem = "<p class='erro'>Tipo de imagem não permitido.</p>";
            echo $mensagem;
            return;
        }

        if ($imagemTamanho > 5000000) { // Limitar o tamanho para 5MB
            $mensagem = "<p class='erro'>A imagem é muito grande. O tamanho máximo permitido é 5MB.</p>";
            echo $mensagem;
            return;
        }

        // Gerar um nome único para a imagem
        $imagemDestino = 'uploads/' . uniqid() . '_' . basename($imagemNome);

        // Mover a imagem para o diretório 'uploads'
        if (!move_uploaded_file($imagemTmp, $imagemDestino)) {
            $mensagem = "<p class='erro'>Erro ao fazer o upload da imagem.</p>";
            echo $mensagem;
            return;
        }
    } else {
        $mensagem = "<p class='erro'>Nenhuma imagem foi enviada.</p>";
        echo $mensagem;
        return;
    }

    // Sanitizar outros campos
    $nome = $conn->real_escape_string($_POST['nome']);
    $autor = $conn->real_escape_string($_POST['autor']);
    $sinopse = $conn->real_escape_string($_POST['sinopse']);
    $link_compra = $conn->real_escape_string($_POST['link_compra']);
    $disponibilidade = $conn->real_escape_string($_POST['disponibilidade']);

    $opcoesDisponibilidade = ['escrito', 'possui', 'nao_possui'];
    if (!in_array($disponibilidade, $opcoesDisponibilidade)) {
        $mensagem = "<p class='erro'>Disponibilidade inválida.</p>";
        echo $mensagem;
        return;
    } else {
        // Inserir no banco de dados
        $sql = "INSERT INTO livros (nome, autor, sinopse, imagem, link_compra, disponibilidade)
                VALUES ('$nome', '$autor', '$sinopse', '$imagemDestino', '$link_compra', '$disponibilidade')";

        if ($conn->query($sql)) {
            $mensagem = "<p class='sucesso'>Livro adicionado com sucesso!</p>";
            echo $mensagem;
        } else {
            $mensagem = "<p class='erro'>Erro ao adicionar livro.</p>";
            echo $mensagem;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Adicionar Livro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&family=Sigmar&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        html {
            width: 100%;
            height: 100%;
        }

        body {
            overflow-x: hidden;
        }

        header {
            width: 100%;
            height: 70px;
            background-color: #000330;
            padding: 10px 0;
            box-shadow: 0 4px 6px rgba(35, 34, 34, 0.375);
            /* position: fixed; */
        }

        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background-color: white;
            animation: move 5s linear infinite;
            opacity: 0, 5;
            z-index: 1;

        }

        @keyframes move {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(0);
                opacity: 0;
            }
        }

        nav {
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 1300px;
            margin: 0 auto;
            /* padding: 0 20px; */
            margin-top: 7.5px;
        }

        .nav-list {
            list-style: none;
            display: flex;
            gap: 40px;
            padding: 0;
            margin: 0;

        }

        .logo {
            background-color: #000330;
            z-index: 2;
        }

        .nav-list h3 {
            color: #ffffff;
            font-family: "Sigmar", sans-serif;
            font-weight: 100;
            font-size: 22px;
        }

        .nav-list p {
            color: red;
            font-family: "Caveat", cursive;
            font-optical-sizing: auto;
            font-weight: 700;
            letter-spacing: 4px;
            font-size: 19px;
            margin-left: 5px;
        }

        .nav-list li {
            /* display: inline; */
            width: 80px;
            height: 25px;
            background-color: #000330;
            z-index: 2;
            margin-top: 10px;
        }

        a {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            text-decoration: none;
            color: #ffffff;
            font-weight: bold;
            padding: 10px 15px;
            transition: 0.3s;
            /* transition: color 0.3s, background-color 0.3s; */
        }

        a:hover {
            /* background-color: #000;
    border-radius: 5px; */
            opacity: 0.7;
        }

        main {
            width: 100%;
            height: 100%;
        }

        .tudo {
            width: 90%;
            margin-left: 45px;
            display: flex;
            justify-content: space-evenly;
            align-items: center;

        }

        .usuario {
            width: 30%;
            height: auto;
            border: none;
            margin-left: 10%;
            margin-bottom: 30%;
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
            /* display: flex;
            justify-content: center;
            align-items: center; */
        }

        .info hr {
            width: 70%;
            height: 2px;
            background-color: #002a77;
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
            width: 60%;
            border: 1px solid #002a77;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h1 {
            font-family: Arial, Helvetica, sans-serif;
            color: #002a77;
            font-size: 25px;
            margin-bottom: 25px;
        }

        form input,
        form textarea,
        form select {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 2px solid #000330;
        }

        form button {
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
        .formulario label {
            display: block;
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

        .erro {
            color: red;
            text-align: center;
            margin-top: 10px;
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
        .voltar button:hover{
            transform: scale(1.02);
        }
        @media (max-width: 480px){
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
                    <a href="#" class="menu-button" onclick="carregarMaterias()">MATÉRIAS</a>
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
            <div class="usuario">
                <div class="foto">
                    <?php if ($foto): ?>
                        <img id="fotoperfil" src="<?php echo $foto; ?>" alt="Foto de Perfil">
                    <?php endif; ?>
                </div>
                <div class="info">
                    <p> <?php echo $_SESSION['nome']; ?></p>
                    <p id="nivel"> Nível: <?= htmlspecialchars($nivel) ?></p>

                </div>
            </div>
            <div class="formulario">
                <h1>Adicionar Livro</h1>
                <?php if ($mensagem): ?>
                    <p class="mensagem"><?= $mensagem ?></p>
                <?php endif; ?>
                <form method="POST" action="" enctype="multipart/form-data">
    <label for="nome">Nome do livro:</label>
    <input type="text" id="nome" name="nome" placeholder="Ex: Dom Casmurro" required>

    <label for="autor">Autor:</label>
    <input type="text" id="autor" name="autor" placeholder="Ex: Machado de Assis" required>

    <label for="sinopse">Sinopse:</label>
    <textarea id="sinopse" name="sinopse" placeholder="Digite a sinopse aqui..." required></textarea>

    <label for="imagem">Imagem:</label>
    <input type="file" id="imagem" name="imagem" accept="image/*" required>

    <label for="link_compra">Link de compra:</label>
    <input type="text" id="link_compra" name="link_compra" placeholder="Ex: https://..." required>


    <button type="submit">Salvar Livro</button>

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