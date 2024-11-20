<?php
// Configurações de conexão com o MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017/");
$database = $mongoClient->mydatabase; // Substitua 'mydatabase' pelo nome do seu banco de dados
$collection = $database->users; // Coleção para armazenar os usuários
?>