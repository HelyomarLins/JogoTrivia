<?php
session_start();
// Recuperar o nome do usuário da sessão
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style3.css">
    <title>Document</title>
</head>

</html>

<body>

    <div class="title">
        <h2>Bem-vindo <?php echo $username; ?>!</h2>
        <h2>Escolha as Opções.</h2>
    </div>
    <div class="container">
        <!-- Conteúdo da página trivia -->
        <form id="trivia-form">
            <div class="trivjogo">
                <label for=" category">Assunto:</label>
                <select id="category">
                    <!-- Opções de categoria aqui -->
                    <option value="9">Conhecimentos Gerais</option>
                    <option value="10">Livros</option>
                    <option value="11">Filmes</option>
                    <option value="12">Música</option>
                    <option value="14">Televisão</option>
                    <option value="15">Video Games</option>
                    <option value="16">Jogos de Tabuleiro</option>
                    <option value="20">Mitologia</option>
                    <option value="21">Esportes</option>
                    <option value="26">Celebridades</option>
                    <option value="27">Animais</option>
                </select>
            </div>
            <div class="trivjogo">
                <label for=" difficulty">Dificuldade:</label>
                <select id="difficulty">
                    <!-- Opções de dificuldade aqui -->
                    <option value="easy" selected>Fácil</option>
                    <option value="medium">Médio</option>
                    <option value="hard">Difícil</option>
                </select>
            </div>
            <div class="trivjogo">
                <label for="type">Resposta:</label>
                <select id="type">
                    <!-- Opções de dificuldade aqui -->
                    <option value="multiple" selected>Multipla Escolha</option>
                    <option value="boolean">Verdadeiro ou Falso</option>
                </select>
            </div>
            <button id="iniciarJogoBtn">Iniciar Jogo</button>
        </form>
    </div>
    <script src="js/trivia.js"></script>
</body>

</html>