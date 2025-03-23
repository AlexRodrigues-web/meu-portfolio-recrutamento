<?php
require_once '../models/Usuario.php';

class UsuarioController {
    private $usuario;

    public function __construct($pdo) {
        $this->usuario = new Usuario($pdo);
    }

    public function criarUsuario($nome, $email, $senha) {
        $this->usuario->criarUsuario($nome, $email, $senha);
        echo json_encode(["message" => "Usuário criado com sucesso!"]);
    }
}
?>
