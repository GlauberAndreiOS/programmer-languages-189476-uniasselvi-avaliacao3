<?php

require_once __DIR__ . '/../../config/database.php';

class UserController {
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function store($data): array
    {
        if (empty($data['nome']) || empty($data['email']) || empty($data['senha'])) {
            throw new Exception("Nome, email e senha são obrigatórios.", 400);
        }

        // Verifica se o email já existe
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute(['email' => $data['email']]);
        if ($stmt->fetch()) {
            throw new Exception("E-mail já cadastrado.", 409); // Conflict
        }

        // Cria o hash da senha de forma segura
        $senhaHash = password_hash($data['senha'], PASSWORD_DEFAULT);

        // Insere no banco de dados
        $stmt = $this->db->prepare("INSERT INTO users (nome, email, senha) VALUES (:nome, :email, :senha)");
        $stmt->execute([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha' => $senhaHash
        ]);
        
        $id = $this->db->lastInsertId();
        
        // Retorna os dados do usuário, exceto a senha
        return [
            "id" => $id,
            "nome" => $data['nome'],
            "email" => $data['email'],
            "message" => "Usuário cadastrado com sucesso!"
        ];
    }
}