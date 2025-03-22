<?php

namespace Core;

use PDO;
use PDOException;
use PDOStatement;

class DB
{
    private PDO $pdo;
    private PDOStatement $stmt;

    public function __construct()
    {
        $config = config('database');

        $defaultOptions = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->pdo = new PDO(
                $config['driver'] . ':host=' . $config['host']. ';port=' . $config['port'] . ';dbname=' . $config['database'],
                $config['user'],
                $config['pass'],
                $config['options'] ?? $defaultOptions
            );
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }

    public function run(string $query, array $params = []): self
    {
        $this->stmt = $this->pdo->prepare($query);
        $this->stmt->execute($params);

        return $this;
    }

    public function find(): array|false
    {
        return $this->stmt->fetch();
    }

    public function all(): array
    {
        return $this->stmt->fetchAll();
    }

    public function delete(string $query, array $params = []): int
    {
        $this->stmt = $this->pdo->prepare($query);
        $this->stmt->execute($params);
        return $this->stmt->rowCount();
    }
}
