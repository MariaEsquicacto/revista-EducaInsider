<?php
include 'db/conexao.php';

$questao_id = $_POST['questao_id'] ?? null;
$resposta_id = $_POST['resposta'] ?? null;

if (!$questao_id || !$resposta_id) {
    echo "Erro: dados incompletos.";
    exit;
}

// Busca a alternativa escolhida
$alt_escolhida = $conn->query("SELECT * FROM alternativas WHERE id = $resposta_id")->fetch_assoc();

if (!$alt_escolhida) {
    echo "Alternativa não encontrada.";
    exit;
}

// Verifica se está correta
if ($alt_escolhida['correta']) {
    echo "<span style='color: green;'>✔️ Resposta correta!</span>";
} else {
    // Busca a alternativa correta
    $alt_correta = $conn->query("SELECT texto FROM alternativas WHERE questao_id = $questao_id AND correta = 1")->fetch_assoc();
    $questao = $conn->query("SELECT explicacao FROM questoes WHERE id = $questao_id")->fetch_assoc();

    echo "<span style='color: red;'>❌ Resposta incorreta.</span><br>";
    echo "<strong>Resposta correta:</strong> " . htmlspecialchars($alt_correta['texto']) . "<br><br>";
    echo "<strong>Explicação:</strong> " . nl2br(htmlspecialchars($questao['explicacao']));
}
