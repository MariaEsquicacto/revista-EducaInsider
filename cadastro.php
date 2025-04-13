<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'api');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $nivel = 'usuario'; // Padrão

    // Definindo o nível com base no nome
    if ($nome == 'professor368') {
        $nivel = 'Professor';
    } elseif ($nome == 'dev368') {
        $nivel = 'Dev';
    }

    // Insere o novo usuário no banco de dados
    $sql = "INSERT INTO usuarios (nome, senha, nivel) VALUES ('$nome', '$senha', '$nivel')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Cadastro realizado com sucesso. <a href='login.php'>Clique aqui para fazer login</a>";
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>

<form method="POST" action="">
    Nome: <input type="text" name="nome">
    Senha: <input type="password" name="senha">
    <button type="submit">Cadastrar</button>
</form>
