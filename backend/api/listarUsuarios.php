<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';

$query = "SELECT id, nome, email, tipo, criado_em FROM usuarios";
$stmt = $pdo->prepare($query);
$stmt->execute();

$usuarios = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $usuarios[] = [
        "id" => $row['id'],
        "nome" => $row['nome'],
        "email" => $row['email'],
        "tipo" => $row['tipo'],
        "criado_em" => $row['criado_em']
    ];
}

echo json_encode($usuarios);
?>
