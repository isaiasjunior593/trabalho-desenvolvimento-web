<?php
// Inclui o arquivo de configuração
require_once 'config.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitiza os dados do formulário (importante para segurança)
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash da senha para segurança

    // Insere o usuário no MongoDB
    $result = $collection->insertOne([
        'nome' => $nome,
        'email' => $email,
        'senha' => $senha
    ]);

    if ($result->getInsertedCount() > 0) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro ao cadastrar usuário.";
    }
}
?>