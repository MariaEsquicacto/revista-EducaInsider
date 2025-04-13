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
                <li><a href="home.html">HOME</a></li>

                <div class="logo">
                    <h3>EDUCA</h3>
                    <p id="insider">insider</p>
                    <!-- <img src="" alt="livro">  -->
                </div>

                <li><a href="perfil.html">PERFIL</a></li>
                <li><a href="jogos.html">JOGOS</a></li>
            </ul>
        </nav>
    </header>

    <main>

    <div class="user">
                <div class="foto">
                <?php if ($foto): ?>
        <img  id="fotoperfil" src="<?php echo $foto; ?>" alt="Foto de Perfil" >
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


        function voltar(){
            window.location.href = "perfil.php"
        }
    </script>
</body>
</html>
