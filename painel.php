<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['nome'])) {
    header('Location: login.php'); // Redireciona para o login
    exit();
}

// Verifica o nível de acesso
$nivel = $_SESSION['nivel'];

if ($nivel == 'usuario') {
    echo "Bem-vindo, " . $_SESSION['nome'] . "! Você pode criar postagens.";
} elseif ($nivel == 'Professor' || $nivel == 'Dev') {
    echo "Bem-vindo, " . $_SESSION['nome'] . "! Você pode criar postagens, aprovar/reprovar conteúdo e criar questões.";
}
?>
