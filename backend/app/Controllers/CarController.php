<?php

require_once __DIR__ . '/../../config/database.php';

class CarController {
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    private function getCars(): array
    {
        $stmt = $this->db->query("SELECT * FROM cars");
        return $stmt->fetchAll();
    }

    private function getCar($id): array
    {
        $stmt = $this->db->prepare("SELECT * FROM cars WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $car = $stmt->fetch();

        if (!$car) {
            throw new Exception("Carro não encontrado.", 404);
        }
        
        return $car;
    }

    public function index(): array
    {
        return $this->getCars();
    }

    public function show($id): array
    {
        return $this->getCar($id);
    }

    public function store($data): array
    {
        $requiredFields = [
            'placa', 'marca', 'modelo', 'ano_fabricacao', 'ano_modelo',
            'cor', 'combustivel', 'quilometragem', 'chassi', 'renavam', 'data_cadastro'
        ];
        
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || (empty($data[$field]) && $data[$field] !== '0' && $data[$field] !== 0)) {
                throw new Exception("O campo {$field} é obrigatório.", 400);
            }
        }

        $stmt = $this->db->prepare("
            INSERT INTO cars (
                placa, marca, modelo, ano_fabricacao, ano_modelo,
                cor, combustivel, quilometragem, chassi, renavam, data_cadastro, observacoes
            ) VALUES (
                :placa, :marca, :modelo, :ano_fabricacao, :ano_modelo,
                :cor, :combustivel, :quilometragem, :chassi, :renavam, :data_cadastro, :observacoes
            )
        ");
        
        $stmt->execute([
            'placa' => $data['placa'],
            'marca' => $data['marca'],
            'modelo' => $data['modelo'],
            'ano_fabricacao' => $data['ano_fabricacao'],
            'ano_modelo' => $data['ano_modelo'],
            'cor' => $data['cor'],
            'combustivel' => $data['combustivel'],
            'quilometragem' => $data['quilometragem'],
            'chassi' => $data['chassi'],
            'renavam' => $data['renavam'],
            'data_cadastro' => $data['data_cadastro'],
            'observacoes' => $data['observacoes'] ?? null
        ]);
        
        $id = $this->db->lastInsertId();
        
        return $this->show($id);
    }
    
    public function update($id, $data): array
    {
        $this->getCar($id);
        
        $requiredFields = [
            'placa', 'marca', 'modelo', 'ano_fabricacao', 'ano_modelo',
            'cor', 'combustivel', 'quilometragem', 'chassi', 'renavam', 'data_cadastro'
        ];
        
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || (empty($data[$field]) && $data[$field] !== '0' && $data[$field] !== 0)) {
                throw new Exception("O campo {$field} é obrigatório.", 400);
            }
        }

        $stmt = $this->db->prepare("
            UPDATE cars SET 
                placa = :placa,
                marca = :marca,
                modelo = :modelo,
                ano_fabricacao = :ano_fabricacao,
                ano_modelo = :ano_modelo,
                cor = :cor,
                combustivel = :combustivel,
                quilometragem = :quilometragem,
                chassi = :chassi,
                renavam = :renavam,
                data_cadastro = :data_cadastro,
                observacoes = :observacoes
            WHERE id = :id
        ");
        
        $stmt->execute([
            'placa' => $data['placa'],
            'marca' => $data['marca'],
            'modelo' => $data['modelo'],
            'ano_fabricacao' => $data['ano_fabricacao'],
            'ano_modelo' => $data['ano_modelo'],
            'cor' => $data['cor'],
            'combustivel' => $data['combustivel'],
            'quilometragem' => $data['quilometragem'],
            'chassi' => $data['chassi'],
            'renavam' => $data['renavam'],
            'data_cadastro' => $data['data_cadastro'],
            'observacoes' => $data['observacoes'] ?? null,
            'id' => $id
        ]);
        
        return $this->show($id);
    }
    
    public function destroy($id): array
    {
        $this->getCar($id);
        
        $stmt = $this->db->prepare("DELETE FROM cars WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        return ["message" => "Carro deletado com sucesso."];
    }
}