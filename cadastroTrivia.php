<?php
session_start();
//Inicializar variáveis globais
$_SESSION["message"] = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);

    // Validar e salvar no arquivo
    if (!empty($email) && !empty($password) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
    // Gerar hash seguro da senha
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    // Sanitizar dados antes de salvar
        $username = htmlspecialchars($username);
        $email = htmlspecialchars($email);
        //Criar array associativo com os dados do usuário
        $user_data =[
            "Nome" => $username,
            "Email" => $email,
            "Senha" => $hashedPassword
        ];
         // Obter o conteúdo atual do arquivo e decodificar como JSON (se existir)
         $existing_data = file_exists("usuarios.json") ? json_decode(file_get_contents("usuarios.json"), true) : [];

         // Adicionar novos dados ao array existente
         $existing_data[] = $user_data;
 
         // Codificar o array completo como JSON
         $json_data = json_encode($existing_data, JSON_PRETTY_PRINT);
 
         // Salvar os dados no arquivo
         file_put_contents("usuarios.json", $json_data, LOCK_EX);

        // Mensagem de confirmação
        $_SESSION["message"] = "Cadastro realizado com sucesso!";
        //Redirecionar para o index.php
        header("Location: indexTrivia.php");
        exit;
    } else {
        // Mensagem de erro, se houver
        $_SESSION["error"] = "Preencha todos os campos corretamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Cadastro</title>

</head>

<body>
    <main>

        <?php
        // Exibir mensagens de sucesso ou erro
        if (isset($_SESSION["message"])) {
            echo "<p>{$_SESSION["message"]}</p>";
            unset($_SESSION["message"]);
        } elseif (isset($_SESSION["error"])) {
            echo "<p style='color: red;'>{$_SESSION["error"]}</p>";
            unset($_SESSION["error"]);
        }
        ?>
        <form method="post" action="cadastroTrivia.php">

            <div class="cadjog">

                <label for=" username">Jogador:</label>
                <input type="text" id="username" name="username" required placeholder="Nome do jogador">


                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required placeholder="Melhor e-mail">


                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required placeholder="Senha">

                <button type=" submit">Cadastrar</button>
            </div>
        </form>
    </main>
</body>

</html>