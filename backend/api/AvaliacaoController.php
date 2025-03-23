<?php
require_once '../config/database.php';
require_once '../controllers/UsuarioController.php';
require_once '../controllers/ProjetoController.php';
require_once '../controllers/CandidatoController.php';
require_once '../controllers/AvaliacaoController.php';

// Ação da requisição
$action = $_GET['action'] ?? '';

// Instanciar os controladores
$usuarioController = new UsuarioController($pdo);
$projetoController = new ProjetoController($pdo);
$candidatoController = new CandidatoController($pdo);
$avaliacaoController = new AvaliacaoController($pdo);

// Lógica de roteamento
switch ($action) {
    case 'criarUsuario':
        // Requisição para criar um usuário
        $usuarioController->criarUsuario($_POST['nome'], $_POST['email'], $_POST['senha']);
        break;
    case 'criarProjeto':
        // Requisição para criar um projeto
        $projetoController->criarProjeto($_POST['nome'], $_POST['descricao']);
        break;
    case 'candidatarProjeto':
        // Requisição para candidatar a um projeto
        $candidatoController->candidatarProjeto($_POST['usuario_id'], $_POST['projeto_id']);
        break;
    case 'avaliarCandidato':
        // Requisição para avaliar um candidato
        $avaliacaoController->avaliarCandidato($_POST['candidato_id'], $_POST['avaliacao']);
        break;
    default:
        echo json_encode(["message" => "Ação inválida"]);
        break;
}
?>
