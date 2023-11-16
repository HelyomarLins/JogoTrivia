<?php
include_once 'engine.php';

// Obtenha os dados dos jogadores
$dadosJogador = obterDadosJogadores();

// Ordene os jogadores pela pontuação total (do maior para o menor)
usort($dadosJogador, function($a, $b) {
    return $b['total'] - $a['total'];
});
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>Estatísticas</title>
</head>

<body>

    <h2>Estatísticas dos Jogadores</h2>

    <table>
        <tr>
            <th>Posição</th>
            <th>Jogador</th>
            <th>Erros</th>
            <th>Acertos</th>
            <th>Total</th>
        </tr>
        <?php
        // Exiba cada jogador na tabela
        foreach ($dadosJogador as $posicao => $jogador) {
            echo '<tr>';
            echo '<td>' . ($posicao + 1) . 'º</td>';
            echo '<td>' . $jogador['nome'] . '</td>';
            echo '<td>' . $jogador['erros'] . '</td>';
            echo '<td>' . $jogador['acertos'] . '</td>';
            echo '<td>' . $jogador['total'] . '</td>';
            echo '</tr>';
        }
        ?>
    </table>

</body>

</html>