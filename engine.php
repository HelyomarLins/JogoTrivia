<?php
// Função para verificar os dados de login
function verificarLogin($username, $password) {
    //Coverter os dados para string
    $usuarios_json = file_get_contents("usuarios.json");
    // Decodificar o JSON para um array associativo
    $usuarios = json_decode($usuarios_json, true);
    // Tratamento de erro ao decodificar o JSON
    if ($usuarios === null) {
        return false;
    }
    // Extrair dados do usuário do array associativo
    foreach ($usuarios as $usuario) {
        $savedUsername = $usuario["Nome"];
        $savedHashedPassword = $usuario["Senha"];

        // Verificar se o nome de usuário coincide e a senha fornecida corresponde ao hash armazenado
        if ($savedUsername === $username && password_verify($password, $savedHashedPassword)) {
            // Login bem-sucedido
            return true; 
        }
    }
    // Login falhou
    return false;
}

function obterPerguntaDaAPI($category, $difficulty, $type) {
// Construir a URL da API com base nas escolhas do jogador
$url = "https://opentdb.com/api.php?amount=1&category=$category&difficulty=$difficulty&type=&type";

// Fazer a requisição à API e obter a resposta
$response = file_get_contents($url);

// Decodificar a resposta JSON para um array associativo
$data = json_decode($response, true);

// Verificar se a resposta da API foi bem-sucedida
if ($data['response_code'] === 0 && isset($data['results'][0])) {
// Retorna a pergunta, respostas erradas e resposta certa
$pergunta = [
'question' => $data['results'][0]['question'],
'incorrect_answers' => $data['results'][0]['incorrect_answers'],
'correct_answer' => $data['results'][0]['correct_answer']
];
return $pergunta;
} else {
// Em caso de falha, retorne null ou um valor padrão
return null;
}
}

function carregarDadosJogador() {
    $dadosJogadorFile = 'dadosJogador.json';
    
    if (file_exists($dadosJogadorFile)) {
        $dadosJogadorJson = file_get_contents($dadosJogadorFile);
        $dadosJogador = json_decode($dadosJogadorJson, true);

        // Tratamento de erro ao decodificar o JSON
        if ($dadosJogador === null) {
            return [];
        }
        return $dadosJogador;
    }

    return [];
}

function salvarDadosJogador($dadosJogador) {
    $dadosJogadorFile = 'dadosJogador.json';
    $dadosJogadorJson = json_encode($dadosJogador, JSON_PRETTY_PRINT);

    file_put_contents($dadosJogadorFile, $dadosJogadorJson);
}

function obterDadosJogadores() {
    $dadosJogadorFile = 'dadosJogador.json';

    if (file_exists($dadosJogadorFile)) {
        $dadosJogadorJson = file_get_contents($dadosJogadorFile);
        $dadosJogador = json_decode($dadosJogadorJson, true);

        // Tratamento de erro ao decodificar o JSON
        if ($dadosJogador === null) {
            return [];
        }

        return $dadosJogador;
    }

    return [];
}

?>