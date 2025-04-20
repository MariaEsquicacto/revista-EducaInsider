<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&family=Sigmar&display=swap"
        rel="stylesheet">
    <style>
        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            animation: move 2s infinite alternate ease-in-out;
        }

        @keyframes shine {
            0% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        .text {
            margin-top: 2%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .carousel {
            position: relative;
            width: 900px;
            height: 400px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .carousel img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .carousel img.active {
            opacity: 1;
        }
        #mural{
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .mural {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      border: 20px solid #402401;
      background-color: #cdaf7b;
      width: 80%;
      height: 500px;
    }

    .cardm {
        margin-left: 30px;
        height: 180px;
        width: 200px;
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: transform 0.2s;
      
    }

    .cardm:hover {
      transform: scale(1.02);
    }

    .titulo {
      font-size: 20px;
      font-weight: bold;
      color: #444;
      margin-bottom: 10px;
      font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    }

    .conteudom {
      color: #666;
      font-size: 15px;
      font-family: Arial, Helvetica, sans-serif;
      width: 200px;
    }

    .data {
      margin-top: 15px;
      font-size: 0.8em;
      color: #999;
      text-align: right;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
    }
    @media (max-width: 480px){
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
            .carousel {
        width: 80%;
        height: 220px;
    }
    .conteudo{
        width: 95%;
        height: 490px;
        margin-left: 15px;
    }
    .conteudo2{
        height: 90%;
    }
    .conteudo2 p{
        font-size: 15px;
    }
    h1, h2{
        font-size: 18px;
    }
    .caixa{
        width: 70px;
    }
    .mural{
        width: 80%;
        height: 800px;
    }
    .cardm {
        margin-left: 15px;
    }
    .conteudom{
        font-size: 14px;
    }
    .final hr{
        margin-top: 20px;
    }
    footer p{
        font-size: 15px;
    }
        }
            

/* RESPONSIVIDADE */
/* @media (max-width: 992px) {
    .carousel {
        width: 80%;
        height: 350px;
    }
}

@media (max-width: 768px) {
    .carousel {
        width: 80%;
        height: 300px;
    }
} */



        
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="imagem">
            </div>
            <ul class="nav-list">
                <li>
                    <a href="#" class="menu-button" onclick="carregarMaterias()">MATÉRIAS</a>
                </li>
                <li><a href="home.html">HOME</a></li>

                <div class="logo">
                    <h3>EDUCA</h3>
                    <p id="insider">insider</p>
                    <!-- <img src="" alt="livro">  -->
                </div>

                <li><a href="perfil.php">PERFIL</a></li>
                <li><a href="mostrar_livro.php" onclick="carregarLivros()">LIVROS</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="text">
            <div class="carousel">
                <img src="assets/img/artes.png" class="active">
                <img src="assets/img/biologia.png">
                <img src="assets/img/educacaofi.png">
            </div>
        </section>

        <div class="conteudo">
            <div class="conteudo2">
                <h1><strong>Como surgiu essa ideia?</strong></h1>
                <p>A ideia da revista nasceu do desejo de criar um espaço onde a voz dos alunos pudesse ser ouvida e
                    valorizada.
                    Queríamos um meio de registrar os momentos especiais, divulgar conquistas, compartilhar
                    aprendizados e dar visibilidade
                    aos talentos que fazem parte da nossa comunidade. Assim, com o apoio de professores e estudantes
                    engajados, surgiu este
                    projeto, feito com dedicação e entusiasmo, para conectar a escola de uma forma mais interativa.
                </p>
            </div>

            <div class="conteudo2">
                <h1><strong>Porque a revista escolar é importante?</strong></h1>
                <p>A revista escolar é mais do que um simples informativo; ela é uma janela para o talento, a
                    criatividade e o conhecimento dos alunos. Por meio dela, podemos compartilhar conquistas,
                    divulgar projetos, discutir temas relevantes e dar voz à comunidade estudantil. Além disso, é
                    uma oportunidade para os alunos desenvolverem habilidades de escrita, design e trabalho em
                    equipe.</p>
            </div>
        </div>
        </div>

        <div class="details">
            <div class="caixa"></div>
            <div class="caixa"></div>
            <div class="caixa"></div>
            <div class="caixa"></div>
            <div class="caixa"></div>
            <div class="caixa"></div>
        </div>

        <div id="materias-container"></div>

        <div class="details">
            <div class="caixa"></div>
            <div class="caixa"></div>
            <div class="caixa"></div>
            <div class="caixa"></div>
            <div class="caixa"></div>
            <div class="caixa"></div>
        </div>

        <div class="inicio">
            <h2>Mural Escolar</h2>
            <hr>
        </div>

        <section id="mural">
        <div class="mural">
            
    <div class="cardm">
      <div class="titulo">Reunião de Pais</div>
      <div class="conteudom">A reunião será realizada na próxima segunda-feira às 18h.</div>
      <div class="data">Postado em: 20/04/2025</div>
    </div>
    <div class="cardm">
      <div class="titulo">Feira de Ciências</div>
      <div class="conteudom">Não se esqueça de levar seu projeto até sexta-feira.</div>
      <div class="data">Postado em: 19/04/2025</div>
    </div>
    <div class="cardm">
      <div class="titulo">Feriado</div>
      <div class="conteudom">Na próxima terça-feira não haverá aula devido ao feriado nacional.</div>
      <div class="data">Postado em: 18/04/2025</div>
    </div>
  </div>
  </section>

        <div class="final">
            <hr>
        </div>

    </main>

    <footer>
    <p>Todos os direitos reservados por &copy; 
  <span style="color: #ffffff; font-family:  'Sigmar', sans-serif;">EDUCA</span> 
  <span style="color: red; font-family: 'Caveat', cursive; letter-spacing: 3px;">insider</span>
</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        for (let i = 0; i < 1000; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            document.querySelector('header').appendChild(star); // ✅ Agora as estrelas estão no header
            star.style.left = `${Math.random() * 100}vw`;
            star.style.top = `${Math.random() * 84}px`; // 🔹 Mantém as estrelas dentro da altura do header
            star.style.width = `${Math.random() * 2 + 0.1}px`;
            star.style.height = star.style.width;
            star.style.animationDuration = `${Math.random() * 2 + 1}s`;
        }



        class MobileNavbar {
            constructor(mobileMenu) {
                this.mobileMenu = document.querySelector(mobileMenu);
                this.navList = document.querySelector(".nav-list"); // Certifique-se que essa classe existe no HTML
                this.navLinks = document.querySelectorAll(".nav-links"); // Certifique-se que essa classe existe no HTML
                this.activeClass = "active";
            }

            addClickEvent() {
                this.mobileMenu.addEventListener("click", () => console.log("Hey"));
            }

            init() {
                if (this.mobileMenu) {
                    this.addClickEvent();
                }
            }
        }





        function carregarMaterias() {
            const container = document.getElementById('materias-container');

            // Verifica se já foi carregado antes para não repetir
            if (container.dataset.carregado === "true") return;

            fetch('materias.php')
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                    container.dataset.carregado = "true"; // marca como carregado
                })
                .catch(error => {
                    console.error('Erro ao carregar matérias:', error);
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const imagens = document.querySelectorAll('.carousel img');
            let index = 0;

            setInterval(() => {
                imagens[index].classList.remove('active');
                index = (index + 1) % imagens.length;
                imagens[index].classList.add('active');
            }, 5000);
        });
    </script>
</body>

</html>