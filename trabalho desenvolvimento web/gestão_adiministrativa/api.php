<?php
header('Content-Type: application/json');
require 'vendor/autoload.php'; // Use o Composer para instalar a biblioteca do MongoDB

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->gestao->usuarios;

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'load':
        loadUsuarios();
        break;
    
    case 'add':
        addUser();
        break;
    
    case 'edit':
        editUser();
        break;
    
    case 'update':
        updateUser();
        break;
    
    case 'delete':
        deleteUser();
        break;
    
    default:
        echo json_encode(['status' => 'error', 'message' => 'Ação não encontrada']);
}

function loadUsuarios() {
    global $collection;
    $usuarios = $collection->find()->toArray();
    echo json_encode($usuarios);
}

function addUser() {
    global $collection;
    $data = json_decode(file_get_contents('php://input'), true);
    
    $result = $collection->insertOne([
        'nome' => $data['nome'],
        'email' => $data['email'],
        'senha' => password_hash($data['senha'], PASSWORD_DEFAULT) // Armazenar a senha de forma segura
    ]);
    
    echo json_encode(['status' => 'success', 'message' => 'Usuário adicionado com sucesso']);
}

function editUser() {
    global $collection;
    $id = $_GET['id'] ?? '';
    
    $usuario = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    echo json_encode($usuario);
}

function updateUser() {
    global $collection;
    $data = json_decode(file_get_contents('php://input'), true);
    
    $result = $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($data['id'])],
        ['$set' => [
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha' => password_hash($data['senha'], PASSWORD_DEFAULT) // Atualizar a senha de forma segura
        ]]
    );
    
    echo json_encode(['status' => 'success', 'message' => 'Usuário atualizado com sucesso']);
}

function deleteUser() {
    global $collection;
    $data = json_decode(file_get_contents('php://input'), true);
    
    $result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($data['id'])]);
    echo json_encode(['status' => 'success', 'message' => 'Usuário excluído com sucesso']);
}
