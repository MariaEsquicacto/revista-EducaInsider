<?php
include 'db/conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID da questão não informado.";
    exit;
}

// Pega os dados da questão, incluindo o campo 'tema'
$questao = $conn->query("SELECT * FROM questoes WHERE id = $id")->fetch_assoc();
$alternativas = $conn->query("SELECT * FROM alternativas WHERE questao_id = $id ORDER BY id ASC");
?>

<h2><?= htmlspecialchars($questao['titulo']) ?></h2>

<!-- Exibe o tema da questão -->
<p><strong>Tema:</strong> <?= htmlspecialchars($questao['tema']) ?></p>

<p><?= nl2br(htmlspecialchars($questao['enunciado'])) ?></p>

<?php if (!empty($questao['imagem'])): ?>
    <img src="uploads/<?= $questao['imagem'] ?>" style="max-width: 300px;"><br>
<?php endif; ?>

<form method="POST" id="respostaForm">
    <?php foreach ($alternativas as $alt): ?>
        <div>
            <label>
                <input type="radio" name="resposta" value="<?= $alt['id'] ?>" required>
                <?= htmlspecialchars($alt['texto']) ?>
            </label>
        </div>
    <?php endforeach; ?>
    <br>
    <button type="submit">Responder</button>
</form>

<div id="resultado" style="margin-top: 20px; font-weight: bold;"></div>

<script>
    const form = document.getElementById('respostaForm');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        formData.append('questao_id', <?= $id ?>);

        const response = await fetch('verificar_resposta.php', {
            method: 'POST',
            body: formData
        });

        const resultado = await response.text();
        document.getElementById('resultado').innerHTML = resultado;
    });
</script>
