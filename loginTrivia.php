<?php
session_start();
include_once 'engine.php';

// Verificar o login se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    if (empty($username) || empty($password) || !verificarLogin($username, $password)) {
        $mensagemErro = "Usuário ou senha não cadastrado.";
        $mensagemErro .= '<br><a class="link-cadastro" href="cadastroTrivia.php">Cadastrar agora!</a>';
    } else {
        // Obter dados do jogador
        $dadosJogador = carregarDadosJogador();

        // Iniciar a sessão e configurar variáveis globais
        $_SESSION['username'] = $username;
        $_SESSION['acumulado'] = 0;

        // Verificar se o jogador já existe nos dados
        foreach ($dadosJogador as $jogador) {
            if ($jogador['nome'] === $username) {
                $_SESSION['acumulado'] = $jogador['total'];
                break;
            }
        }

        // Redirecionar para o jogo
        header('location: opcoesTrivia.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Nova Trivia - Login</title>
</head>

<body>

    <main>
        <form method="post" action="loginTrivia.php">
            <div class="cadjog">
                <?php
            if (isset($mensagemErro)) {
                echo '<div class="erro">' . $mensagemErro . '</div>';
            }
            ?>
                <label for=" username">Jogador:</label>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required><br>
                <button type="submit">Jogar</button>
            </div>
        </form>
    </main>
</body>

</html>