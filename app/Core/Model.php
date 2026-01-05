<?php

declare(strict_types=1);

namespace Mini\Core;

use PDO;

/**
 * Classe Model - Classe de base pour tous les modèles
 * Fournit les méthodes CRUD de base
 */
abstract class Model
{
    /** @var string Nom de la table */
    protected string $table = '';

    /** @var PDO */
    protected PDO $db;

    /**
     * Constructeur - Initialise la connexion PDO
     */
    public function __construct()
    {
        $this->db = Database::getPDO();
    }

    /**
     * Récupère tous les enregistrements
     * @return array
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Récupère un enregistrement par ID
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    /**
     * Récupère les enregistrements avec une condition
     * @param string $where Clause WHERE
     * @param array $params Paramètres de la requête
     * @return array
     */
    public function findWhere(string $where, array $params = []): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$where}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Récupère un seul enregistrement avec une condition
     * @param string $where Clause WHERE
     * @param array $params Paramètres de la requête
     * @return array|null
     */
    public function findOneWhere(string $where, array $params = []): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$where}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    /**
     * Crée un nouvel enregistrement
     * @param array $data Données à insérer
     * @return int ID de l'enregistrement créé
     */
    public function create(array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));
        
        return (int)$this->db->lastInsertId();
    }

    /**
     * Met à jour un enregistrement
     * @param int $id ID de l'enregistrement
     * @param array $data Données à mettre à jour
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $setClause = implode(', ', array_map(fn($key) => "$key = ?", array_keys($data)));
        $values = array_values($data);
        $values[] = $id;
        
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Supprime un enregistrement
     * @param int $id ID de l'enregistrement
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Compte les enregistrements
     * @param string $where Clause WHERE optionnelle
     * @param array $params Paramètres optionnels
     * @return int
     */
    public function count(string $where = '', array $params = []): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        if ($where) {
            $sql .= " WHERE {$where}";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        
        return (int)($result['count'] ?? 0);
    }
}