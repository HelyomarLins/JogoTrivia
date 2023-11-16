<?php
include_once 'engine.php';
// Inicialize a pontuação da sessão como 0 quando a sessão é iniciada
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}
//URL da The Trivia API
$randomQueryParam = 'nocache=' . rand();
$url = "https://the-trivia-api.com/v2/questions/?&limit=1&$randomQueryParam";
// URL da API Open Trivia Database $url = "https://opentdb.com/api.php?amount=1&type=multiple";

// Faz a requisição à API e obtém a resposta usando cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Decodifica a resposta JSON para um array associativo
$data = json_decode($response, true);

// Verifique se a resposta da API foi bem-sucedida
if ($data['response_code'] === 0 && isset($data['results'][0])) {
    // Armazene a pergunta, respostas erradas e resposta certa em variáveis de sessão
    $_SESSION['question'] = $data['results'][0]['question'];
    $_SESSION['incorrect_answers'] = $data['results'][0]['incorrect_answers'];
    $_SESSION['correct_answer'] = $data['results'][0]['correct_answer'];
}
?>