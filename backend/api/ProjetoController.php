<?php
require_once '../models/Projeto.php';

class ProjetoController {
    private $projeto;

    public function __construct($pdo) {
        $this->projeto = new Projeto($pdo);
    }

    public function criarProjeto($nome, $descricao) {
        $this->projeto->criarProjeto($nome, $descricao);
        echo json_encode(["message" => "Projeto criado com sucesso!"]);
    }
}
?>
