<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) {
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

// Atualizar foto se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['nova_foto'])) {
    $img_nome = $_FILES['nova_foto']['name'];
    $img_tmp = $_FILES['nova_foto']['tmp_name'];
    $destino = 'fotos_perfil/' . $img_nome;

    move_uploaded_file($img_tmp, $destino);

    // Atualiza o caminho da foto no banco
    $conn->query("UPDATE usuarios SET foto = '$destino' WHERE nome = '$nome'");
    $foto = $destino; // Atualiza a foto na tela sem precisar de refresh
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="assets/css/perfil.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&family=Sigmar&display=swap"
        rel="stylesheet">
    <style>
        @media (max-width: 480px) {
            header{
                height: 50px;
            }
            nav{
                width: 90%;
                margin-top: 0;
            }
            .nav-list{
                gap: 20px;
            }
            .nav-list h3{
                font-size: 17px;
            }
            .nav-list p{
                font-size: 15px;
                margin-left: 4px;
            }
            .nav-list li{
                width: 60%;
            }
            a{
                font-size: 12px;
            }

            main {
                height: auto;
                padding: 20px 0;
            }

            .perfil-container {
                flex-direction: column;
                width: 80%;
                height: 80%;
                padding: 20px;
                margin: auto;
            }

            .perfil {
                width: 100%;
                margin-left: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .foto {
                margin: 0 auto 10px;
                width: auto;
                text-align: center;
            }

            .foto #fotoperfil {
                width: 130px;
                height: 130px;
            }

            #alterarimagem {
                font-size: 13px;
            }

            .info h1 {
                font-size: 22px;
                text-align: center;
            }

            .info p {
                font-size: 13px;
                width: auto;
                padding: 4px 8px;
                text-align: center;
                margin-bottom: 15px;
            }

            .botoes {
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 5px;
                margin: 0 auto;
            }

            .botoes a {
                width: 80%;
                height: 30px;
                font-size: 14px;
            }

            .botoes a:hover {
                transform: scale(1.03);
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
                    <a href="#" class="menu-button">MATÉRIAS</a>
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


        <div class="perfil-container">

            <section class="perfil">
                <div class="foto">
                    <!-- Mostrar a foto de perfil atual -->
                    <?php if ($foto): ?>
                        <img id="fotoperfil" src="<?php echo $foto; ?>" alt="Foto de Perfil">
                    <?php else: ?>
                        <p style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">Você ainda não enviou uma foto.</p>
                    <?php endif; ?>

                    <button type="button" id="alterarimagem" onclick="document.getElementById('form-imagem').style.display='block'">Alterar imagem</button>

                    <form method="POST" enctype="multipart/form-data" id="form-imagem" style="display: none; margin-top: 10px;">
                        <input type="file" name="nova_foto" accept="image/*" required>
                        <button type="submit">Enviar</button>
                    </form>


                </div>
                <div class="info">
                    <h1>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h1>
                    <p>Nível: <?= htmlspecialchars($nivel) ?></p>
                    <p id="sair" onclick="sair()"> Sair <i class="bi bi-box-arrow-right"></i></p>
                </div>
            </section>

            <section class="botoes">
                <?php
                // Verifica o nível de acesso e exibe os botões correspondentes
                if ($nivel == 'Professor' || $nivel == 'Dev') {
                    // Botões visíveis apenas para Professor e Dev
                    echo '<a href="moderacao.php">Aprovar/Reprovar Conteúdo</a><br>';
                    echo '<a href="criar_questao.php">Criar Questão</a><br>';
                    echo '<a href="adicionar_livro.php">Adicionar Livro</a><br>';
                }
                ?>

                <a href="criar_postagem.php">Criar Postagem</a>
            </section>

            <!-- <section class="voltar">
    <button type="submit" id="sair" onclick="sair()">Sair <i class="bi bi-box-arrow-right"></i></button>
        <button type="submit" id="voltar"  onclick="voltar()">Voltar</button>
    </section> -->
        </div>

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
        document.querySelector("header").style.backgroundColor = "#000330";

        function voltar() {
            window.location.href = "home.html"
        }

        function sair() {
            window.location.href = "index.html"
        }
    </script>
</body>

</html>