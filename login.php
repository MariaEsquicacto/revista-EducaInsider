<?php
session_start();

$conn = new mysqli("localhost", "root", "", "api");

// Cadastro
if (isset($_POST['cadastrar'])) {
    $nome = $_POST['cad_nome'];
    $senha = $_POST['cad_senha'];

    // Determina o nível com base no nome
    if ($nome === 'dev368') {
        $nivel = 'Dev';
    } elseif ($nome === 'professor368') {
        $nivel = 'Professor';
    } else {
        $nivel = 'usuario';
    }

    // Verifica se o nome já existe
    $check = $conn->query("SELECT * FROM usuarios WHERE nome = '$nome'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Nome de usuário já existe!'); window.history.back();</script>";
        exit();
    }

    // Cadastra
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, senha, nivel) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $senha_hash, $nivel);
    $stmt->execute();

    echo "<script>alert('Cadastro realizado com sucesso! Faça login.'); window.location.href='login.php';</script>";
    exit();
   if ($stmt->execute()) {
    echo "Usuário cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar usuário: " . $stmt->error;
}
 
}


// Login
if (isset($_POST['entrar'])) {
    $nome = $_POST['login_nome'];
    $senha = $_POST['login_senha'];

    // Busca o usuário apenas pelo nome
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nome = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se encontrar o usuário
    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        // Verifica se a senha está correta
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['nivel'] = $usuario['nivel'];
            header("Location: perfil.php");
            exit();
        } else {
            echo "<script>alert('Senha incorreta'); window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('Usuário não encontrado'); window.history.back();</script>";
        exit();
    }
}



?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./assets/css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&family=Sigmar&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <div class="title">
                <h2>EDUCA</h2>
                <p id="insider">INSIDER</p>
        </nav>
    </header>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="" method="post">
                <h1>Cadastro</h1>
                <input type="text" id="nome" name="cad_nome" placeholder="Nome de usuário" required>
                <input type="password" id="senha" name="cad_senha" placeholder="Senha (máx. 8 caracteres)" maxlength="8" required>
                <button type="submit" name="cadastrar">Cadastrar</button>
                <div id="mensagem"></div>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="" method="post">
                <h1>Login</h1>
                <input type="text" id="login_nome" name="login_nome" placeholder="Nome de usuário" required>
                <input type="password" id="login_senha" name="login_senha" placeholder="Senha" required>
                <a href="#" onclick="proximapag()">Esqueci minha senha</a>
                <button type="submit" name="entrar">Login</button>
                <div id="login_mensagem"></div>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Bem vindo!</h1>
                    <p>Já possui um cadastro?</p>
                    <button class="hidden" id="login">Login</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Olá amigo!</h1>
                    <p>Não possui um cadastro?</p>
                    <button class="hidden" id="register">cadastre-se</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('container');
        const registerBtn = document.getElementById('register');
        const loginBtn = document.getElementById('login');

        registerBtn.addEventListener('click', () => {
            container.classList.add("active");
        });

        loginBtn.addEventListener('click', () => {
            container.classList.remove("active");
        });

        for (let i = 0; i < 1000; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            document.body.appendChild(star);
            star.style.left = `${Math.random()* 100}vw`;
            star.style.top = `${Math.random()* 100}vh`;
            star.style.width = `${Math.random() * 3 + 1}px`;
            star.style.height = star.style.width;
            star.style.animationDuration = `${Math.random()* 5 + 2}s`;
        }

        function Login() {
            alert("Login realizado com sucesso!")
            window.location.href = "painel.php"

        }

        function Cadastro() {
            alert("Cadastro realizado com sucesso! Volte para a página de login")
        }
    </script>
</body>

</html>