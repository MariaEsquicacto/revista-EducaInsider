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
    $materia_id = $_POST['materia'] ?? '';
    $titulo = $_POST['titulo'] ?? '';
    $subtitulo = $_POST['subtitulo'] ?? '';
    $conteudo = $_POST['conteudo'] ?? '';
    $imagem = $_FILES['imagem'] ?? null;

    if ($materia_id && $titulo && $subtitulo && $conteudo && $imagem) {
        $nomeImagem = uniqid() . "-" . basename($imagem['name']);
        $caminhoImagem = "uploads/" . $nomeImagem;

        if (move_uploaded_file($imagem['tmp_name'], $caminhoImagem)) {
            $sql = $conn->prepare("INSERT INTO postagens (materia_id, titulo, subtitulo, conteudo, imagem, status) 
                                   VALUES (?, ?, ?, ?, ?, 'pendente')");
            $sql->bind_param("issss", $materia_id, $titulo, $subtitulo, $conteudo, $nomeImagem);

            if ($sql->execute()) {
                $mensagem = "Postagem enviada para análise!";
            } else {
                $mensagem = "Erro ao salvar no banco de dados.";
            }
        } else {
            $mensagem = "Erro ao enviar imagem.";
        }
    } else {
        $mensagem = "Preencha todos os campos!";
    }
}

// buscar matérias
$materias = $conn->query("SELECT id, nome FROM materias ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Postagem</title>
    <link rel="stylesheet" href="./assets/css/criar_postagem.css">
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

    <section class="tudo">
    <section class="usuario">

    <div class="foto">
     <?php if ($foto): ?>
        <img  id="fotoperfil" src="<?php echo $foto; ?>" alt="Foto de Perfil" >
    <?php endif; ?>
    </div>
    <div class="info">
        <p> <strong>Nome:</strong> <?php echo $_SESSION['nome']; ?></p>
        <p> <strong>Nível:</strong> <?= htmlspecialchars($nivel) ?></p>
     </div>   

    </section>

    <div class="divisao"></div>


    <div class="formulario">
        <h2>Criar Nova Postagem</h2>
        <?php if ($mensagem): ?>
            <p class="mensagem"><?= $mensagem ?></p>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <label for="materia">Matéria:</label>
            <select name="materia" required>
                <option value="">Selecione</option>
                <?php while ($m = $materias->fetch_assoc()): ?>
                    <option value="<?= $m['id'] ?>"><?= $m['nome'] ?></option>
                <?php endwhile; ?>
            </select>

            <label for="titulo">Título:</label>
            <input type="text" name="titulo" required>

            <label for="subtitulo">Subtítulo:</label>
            <input type="text" name="subtitulo" required>

            <label for="conteudo">Conteúdo:</label>
            <textarea name="conteudo" rows="8" required></textarea>

            <label for="imagem">Imagem:</label>
            <input type="file" name="imagem" accept="image/*" required>

            <button type="submit">Criar Postagem</button>
        </form>
    </div>
    </section>
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
