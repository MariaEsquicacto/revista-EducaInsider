<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livros Disponíveis</title>
    <!-- Link do Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&family=News+Cycle:wght@400;700&family=Poetsen+One&family=Sigmar&family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #f8f9fc;
        --text-color: #343a40;
        --card-bg: #ffffff;
        --hover-color: #2e59d9;
        --scrollbar-bg: #dee2e6;
        --scrollbar-thumb: #4e73df;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    html{
        width: 100%;
        height: 100%;
        background-color: #000330;
    }

    body {
        width: 100%;
        height: 100%;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #000330;
        overflow-x: hidden;
    }
    #estrelas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    pointer-events: none; /* para não atrapalhar cliques nos elementos da página */
    z-index: 1; /* deve ficar atrás de todo o conteúdo */
}
    .star {
    position: absolute;
    width: 2px;
    height: 2px;
    background-color: white;
    animation: move 5s linear infinite;
    opacity: 0.5;


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

    .containerlivro {
        width: 90%;
        max-width: 1200px;
        margin: 60px auto;
        margin-bottom: 30px;

    }

    h1 {
        color: white;
        font-size: 50px;
        margin-bottom: 30px;
        font-family: "Sigmar", sans-serif;
        font-weight: 400;
        font-style: normal;
    }
    #livros{
        margin-top: 2%;
    }

    .livros-container {
        display: flex;
        overflow-x: auto;
        gap: 20px;
        padding: 10px 0;
        scrollbar-width: thin;
        scrollbar-color: var(--scrollbar-thumb) var(--scrollbar-bg);
    }

    /* Scrollbar estilizada para navegadores WebKit */
    .livros-container::-webkit-scrollbar {
        height: 8px;
    }

    .livros-container::-webkit-scrollbar-track {
        background: var(--scrollbar-bg);
        border-radius: 10px;
    }

    .livros-container::-webkit-scrollbar-thumb {
        background-color: var(--scrollbar-thumb);
        border-radius: 10px;
    }

    .livro-card {
        min-width: 160px;
        cursor: pointer;
        background-color: var(--card-bg);
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .livro-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .livro-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 8px;
    }

    .modal-content {
        border-radius: 10px;
        background-color: var(--card-bg);
        padding: 20px;
    }

    .modal-title {
        color: var(--primary-color);
        font-weight: bold;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: var(--hover-color);
    }
    #forms{
        margin-top: 5%;
    }
    .voltar{
            width: 100%;
            /* height: 60px; */
            display: flex;
            justify-content: start;
            align-items: center;
 
        }
        .voltar p{
            margin: 30px;
            transition: 0.3s ease-in-out;
        }
        .voltar p:hover{
            transform: scale(1.2);
        }

    
</style>

</head>
<body>
<div id="estrelas"></div>
    

<div class="title" style="background-color: <?= $corMateria ?>;">
    <div class="voltar">
        <p onclick="voltarhome()"><i class="bi bi-arrow-left-circle-fill" style="color: #ffffff;"></i></p>
    </div>
<div class="containerlivro">
    <h1 class="text-center mb-4">Catálogo de Livros</h1>
    <form class="d-flex mb-4" role="search" id="forms" >
    <input class="form-control me-2" type="search" placeholder="Buscar livro..." aria-label="Search" id="pesquisaLivro">
</form>
    <div class="row g-4" id="livros">
    <?php
    $conn = new mysqli("localhost", "root", "", "api");
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM livros ORDER BY id DESC LIMIT 10";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($livro = $result->fetch_assoc()) {
            echo '<div class="col-md-3">';
            echo '  <div class="livro-card h-100">';
            echo '    <img 
                        src="'.$livro['imagem'].'" 
                        alt="'.$livro['nome'].'" 
                        data-bs-toggle="modal" 
                        data-bs-target="#livroModal" 
                        data-nome="'.$livro['nome'].'" 
                        data-sinopse="'.$livro['sinopse'].'" 
                        data-imagem="'.$livro['imagem'].'" 
                    >';
            echo '  </div>';
            echo '</div>';
        }
    } else {
        echo "<p>Nenhum livro encontrado.</p>";
    }

    $conn->close();
    ?>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="livroModal" tabindex="-1" aria-labelledby="livroModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="livroModalLabel">Detalhes do Livro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img id="modalImagem" src="" alt="Imagem do Livro" class="img-fluid mb-3">
        <h5 id="modalNome"></h5>
        <p id="modalSinopse"></p>

        

        <p><a id="modalLink" href="" target="_blank" class="btn btn-primary">Comprar</a></p>
      </div>
    </div>
  </div>
</div>


<!-- Scripts do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    for (let i = 0; i < 1000; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            document.querySelector('#estrelas').appendChild(star); // ✅ Agora as estrelas estão no header
            star.style.left = `${Math.random() * 100}%`;
            star.style.top = `${Math.random() * 100}%`; // 🔹 Mantém as estrelas dentro da altura do header
            star.style.width = `${Math.random() * 2 + 0.1}px`;
            star.style.height = star.style.width;
            star.style.animationDuration = `${Math.random() * 3 + 2}s`;
        }



    // Script para preencher o modal com os dados do livro
    const livroModal = document.getElementById('livroModal');
livroModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // O botão que abriu o modal
    const nome = button.getAttribute('data-nome');
    const sinopse = button.getAttribute('data-sinopse');
    const imagem = button.getAttribute('data-imagem');

    const link = button.getAttribute('data-link');

    document.getElementById('modalNome').innerText = nome;
    document.getElementById('modalSinopse').innerText = sinopse;
    document.getElementById('modalImagem').src = imagem;
    document.getElementById('modalLink').href = link;

   
});
document.getElementById('pesquisaLivro').addEventListener('input', function () {
    const termo = this.value.toLowerCase();
    const cards = document.querySelectorAll('.livro-card');

    cards.forEach(card => {
        const nomeLivro = card.querySelector('img').getAttribute('alt').toLowerCase();
        if (nomeLivro.includes(termo)) {
            card.parentElement.style.display = 'block'; // mostra a coluna
        } else {
            card.parentElement.style.display = 'none'; // esconde a coluna
        }
    });
});

function voltarhome(){
    window.location.href = "home.php"
}

</script>

</body>
</html>
