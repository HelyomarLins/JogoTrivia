//Verifica se escolheu a resposta
document.getElementById('trivia-form').addEventListener('submit', function (e) {
    const selectedAnswer = document.querySelector('input[name="answer"]:checked');
    if (!selectedAnswer) {
        e.preventDefault(); // Impede o envio do formulário se nenhuma resposta estiver selecionada
        document.getElementById('feedback').textContent = "Escolha uma resposta...";
    }
});

document.addEventListener('DOMContentLoaded', function() {
    //O código será executado após o DOM estar completamente carregado

    document.getElementById('iniciarJogoBtn').addEventListener('click', function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário

        const category = document.getElementById('category').value;
        const difficulty = document.getElementById('difficulty').value;
        const type = document.getElementById('type').value;

        // Validar se todos os campos foram selecionados
        if (!category || !difficulty || !type) {
            alert('Por favor, selecione todas as opções antes de iniciar o jogo.');
            return;
        }

        // Construir a URL com base nas opções escolhidas
        const url = `triviaJogo.php?category=${category}&difficulty=${difficulty}&type=${type}`;

        // Exibir a URL no console para verificação
        console.log(url);

        // Redirecionar para a URL gerada
        window.location.href = url;
    });
});


