<?php
namespace AlphaPit;

use PDO;

class Model
{
    protected string $table;
    protected PDO $pdo;
    protected array $fillable = [];

    public function __construct(PDO $pdo, string $table)
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    protected function filterData(array $data): array
    {
        if ($this->fillable) {
            $data = array_intersect_key($data, array_flip($this->fillable));
        }
        return $data;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): int
    {
        $data = $this->filterData($data);
        if (!$data) {
            throw new \InvalidArgumentException('No data provided for insert');
        }
        $columns = implode(',', array_map(fn($c) => "`$c`", array_keys($data)));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
        $stmt->execute(array_values($data));
        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $data = $this->filterData($data);
        if (!$data) {
            throw new \InvalidArgumentException('No data provided for update');
        }
        $set = implode(',', array_map(fn($c) => "`$c` = ?", array_keys($data)));
        $values = array_values($data);
        $values[] = $id;
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET {$set} WHERE id = ?");
        return $stmt->execute($values);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
