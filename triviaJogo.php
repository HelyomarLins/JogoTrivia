<?php
session_start();
include_once 'engine.php';

// Carregue os dados do jogador
$dadosJogador = carregarDadosJogador();

// Inicialize a pontuação da sessão se ainda não estiver definida
if (!isset($_SESSION['score']) && !isset($_SESSION['incorrect_score'])) {
    $_SESSION['score'] = 0;
    $_SESSION['incorrect_score'] = 0;
    $_SESSION['total'] = 0;
    
}
//Iniciando variáveis globais
$_SESSION['feedback'] = "";

// Obtenha a pergunta se ainda não houver pergunta na sessão
if (!isset($_SESSION['pergunta'])) {
    // Verifique se as opções foram escolhidas
    if (isset($_GET['category'], $_GET['difficulty'], $_GET['type'])) {
        $category = $_GET['category'];
        $difficulty = $_GET['difficulty'];
        $type = $_GET['type'];

        // Defina as variáveis de sessão
        $_SESSION['category'] = $category;
        $_SESSION['difficulty'] = $difficulty;
        $_SESSION['type'] = $type;

        // Obtenha a pergunta após processar as opções
        $_SESSION['pergunta'] = obterPerguntaDaAPI($category, $difficulty, $type);
        $_SESSION['question'] = $_SESSION['pergunta']['question'];
        $_SESSION['correct_answer'] = $_SESSION['pergunta']['correct_answer'];
        $_SESSION['incorrect_answers'] = $_SESSION['pergunta']['incorrect_answers'];
    } else {
        // Redirecione para a página de opções se as escolhas não foram feitas
        header("Location: opcoesTrivia.php");
        exit();
    }
}
// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifique se uma resposta foi escolhida
    if (isset($_POST['answer'])) {
        $selected_answer = $_POST['answer'];

        // Use as variáveis de sessão definidas anteriormente
        $category = $_SESSION['category'];
        $difficulty = $_SESSION['difficulty'];
        $type = $_SESSION['type'];
        
        // Verifique se a resposta escolhida está correta
        if ($selected_answer == $_SESSION['correct_answer']) {
            // Incrementar a pontuação se a resposta estiver correta
            $_SESSION['score'] += 1;
            $_SESSION['feedback'] = "Acertou!";
        } else {
            // Incrementar a pontuação se a resposta estiver correta
            $_SESSION['incorrect_score'] += 1;
            // Resposta incorreta, incluir a resposta correta na mensagem de feedback
            $_SESSION['feedback'] = "Errou!<br>Resposta certa: " . $_SESSION['correct_answer'];
            // Salve a resposta errada do jogador e penalize a pontuação (por exemplo, -1 ponto por resposta errada)
            $_SESSION['respostas_erradas'][] = [
                'pergunta' => $_SESSION['question'],
                'resposta_escolhida' => $selected_answer,
                'resposta_correta' => $_SESSION['correct_answer'],
            ];
        }
    } else {
        $_SESSION['feedback'] = "Por favor, escolha uma resposta.";
    }

    // Obtenha a próxima pergunta após processar a resposta
    $_SESSION['pergunta'] = obterPerguntaDaAPI($category, $difficulty, $type);
    $_SESSION['question'] = $_SESSION['pergunta']['question'];
    $_SESSION['correct_answer'] = $_SESSION['pergunta']['correct_answer'];
    $_SESSION['incorrect_answers'] = $_SESSION['pergunta']['incorrect_answers'];
}

// Adicione a pontuação total à sessão
$_SESSION['total'] = $_SESSION['score'] - $_SESSION['incorrect_score'];

// Verifique se o botão "Sair" foi clicado
if (isset($_POST['sair'])) {
    // Encontre o jogador atual nos dados existentes ou adicione um novo
    $jogadorAtual = null;
    foreach ($dadosJogador as &$jogador) {
        if ($jogador['nome'] === $_SESSION['username']) {
            $jogador['acertos'] += $_SESSION['score'];
            $jogador['erros'] += $_SESSION['incorrect_score'];
            $jogador['total'] += $_SESSION['total'];
            $jogadorAtual = $jogador;
            break;
        }
    }

    if ($jogadorAtual === null) {
        $dadosJogador[] = [
            'nome' => $_SESSION['username'],
            'acertos' => $_SESSION['score'],
            'erros' => $_SESSION['incorrect_score'], 
            'total' => $_SESSION['total'],
        ];
    }

    // Salve os dados do jogador no arquivo
    salvarDadosJogador($dadosJogador);

    // Limpe as variáveis de sessão
    session_unset();
    session_destroy();

    // Redirecione para a página inicial
    header("Location: indexTrivia.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Trivia</title>
</head>

<body>
    <h3>
        Bem-vindo:<br><?php echo $_SESSION['username']; ?><br>
        Acumulado: <?php echo $_SESSION['acumulado']; ?> pts.</h3>

    <h2>Pergunta:</h2>
    <p><?php echo $_SESSION['question']; ?></p>

    <form method="post" id="trivia-form">
        <h2>Escolha uma resposta:</h2>
        <?php
        // Exiba as opções de resposta como botões de rádio
        $all_answers = $_SESSION['incorrect_answers'];
        $all_answers[] = $_SESSION['correct_answer'];
        
        // Embaralhe as opções para que a resposta certa não seja sempre a última
        shuffle($all_answers); 
        foreach ($all_answers as $answer) {
            echo '<input type="radio" name="answer" value="' . $answer . '">' . $answer . '<br>';
        }
        ?>
        <input type="submit" value="Enviar Resposta">
    </form>

    <!-- Adicionando o botão "Sair" que aciona o formulário -->
    <form method="post" action="triviaJogo.php">
        <input type="hidden" name="sair" value="1">
        <button type="submit">Sair</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
    <p id="feedback"><?php echo $_SESSION['feedback']; ?></p>
    <p>Acertos: <?php echo $_SESSION['score']; ?></p>
    <p>Erros: <?php echo $_SESSION['incorrect_score']; ?></p>
    <?php endif; ?>

    <script src="js/trivia.js"></script>
</body>

</html>