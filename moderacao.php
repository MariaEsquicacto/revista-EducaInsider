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



// Processar aprovação/reprovação
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $acao = $_POST['acao'] ?? null;

    if ($id && in_array($acao, ['aprovado', 'reprovado'])) {
        $sql = $conn->prepare("UPDATE postagens SET status = ? WHERE id = ?");
        $sql->bind_param("si", $acao, $id);
        $sql->execute();
    }

    header("Location: moderacao.php");
    exit;
}

// Buscar postagens pendentes
$sql = "SELECT p.*, m.nome AS nome_materia FROM postagens p 
        JOIN materias m ON p.materia_id = m.id 
        WHERE p.status = 'pendente' ORDER BY p.id DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Moderação de Postagens</title>
    <link rel="stylesheet" href="./assets/css/moderacao.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&family=Sigmar&display=swap"
        rel="stylesheet">
    <style>
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

            .foto {
                width: 32%;
            }

            .foto #fotoperfil {
                width: 100px;
                height: 100px;
            }

            .hr p {
                font-size: 25px;
            }

            .card-container {
                display: flex;
                flex-wrap: wrap;
                /* Permite quebra de linha */
                gap: 20px;
                justify-content: center;
                /* Centraliza em telas menores */
                margin: 30px auto;
                max-width: 100%;
                /* Ocupa toda a largura disponível */
                padding: 0 20px;
            }

            .card {
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
                flex: 1 1 280px;
                /* Cresce, encolhe, tamanho mínimo */
                max-width: 320px;
            }

            .card h3 {
                font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            }

            .card p {
                font-family: Arial, Helvetica, sans-serif;
            }

            .card #subtitulo {
                font-size: 15px;
            }

            .card img {
                width: 100%;
                max-height: 200px;
                object-fit: cover;
                border-radius: 6px;
            }

            .botoes {
                margin-top: 15px;
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .botoes form {
                display: inline;
            }

            .botoes button {
                padding: 8px 16px;
                border: none;
                border-radius: 6px;
                color: white;
                font-weight: bold;
                cursor: pointer;
                transition: 0.3s ease-in-out;
            }

            .aprovar {
                background-color: #28a745;
            }

            .reprovar {
                background-color: #dc3545;
            }

            .botoes button:hover {
                transform: scale(1.02);
            }

            .voltar button {
                font-size: 15px;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                color: #ffffff;
                background-color: #002a77;
                border-radius: 4px;
                padding: 10px;
                /* margin: 20px auto 10px auto;
    display: block; */
                border: none;
                transition: 0.3s ease-in-out;
                cursor: pointer;
                box-shadow: 0 5px 6px #61616159;
            }

            /* Responsividade adicional */
            @media (max-width: 768px) {
                .card-container {
                    gap: 15px;
                }
            }

            @media (max-width: 480px) {
                .botoes {
                    flex-direction: column;
                    align-items: stretch;
                }

                .botoes button {
                    width: 100%;
                    margin: 20px auto 10px auto;
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

        <div class="user">
            <div class="foto">
                <?php if ($foto): ?>
                    <img id="fotoperfil" src="<?php echo $foto; ?>" alt="Foto de Perfil">
                <?php endif; ?>
            </div>
            <div class="hr">
                <p>Postagens Pendentes</p>
                <hr>
            </div>
        </div>
        <div class="card-container">
            <?php while ($p = $resultado->fetch_assoc()): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($p['titulo']) ?></h3>
                    <p><strong>Matéria:</strong> <?= htmlspecialchars($p['nome_materia']) ?></p>
                    <p id="subtitulo"><?= htmlspecialchars($p['subtitulo']) ?></p>
                    <img src="uploads/<?= $p['imagem'] ?>" alt="Imagem da postagem">

                    <div class="botoes">
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <input type="hidden" name="acao" value="aprovado">
                            <button class="aprovar" type="submit">Aprovar</button>
                        </form>

                        <form method="post">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <input type="hidden" name="acao" value="reprovado">
                            <button class="reprovar" type="submit">Reprovar</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>

            <?php if ($resultado->num_rows === 0): ?>
                <p style="text-align:center; font-family:Arial, Helvetica, sans-serif">Nenhuma postagem pendente no momento.</p>
            <?php endif; ?>
        </div>

        <div class="voltar">
            <button type="submit" onclick="voltar()">Voltar</button>
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

        document.header.style.backgroundColor = "#000330";


        function voltar() {
            window.location.href = "perfil.php"
        }
    </script>
</body>

</html>