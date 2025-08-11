<?php
namespace AlphaPit;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private ?PDO $pdo = null;

    private function __construct(array $config)
    {
        $this->connect($config);
    }

    private function connect(array $config): void
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $config['host'], $config['dbname'], $config['charset']);
        try {
            $this->pdo = new PDO($dsn, $config['user'], $config['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new \RuntimeException('Database connection failed: ' . $e->getMessage(), 0, $e);
        }
    }

    public static function getInstance(array $config): Database
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public static function reset(): void
    {
        self::$instance?->disconnect();
        self::$instance = null;
    }

    public function reconnect(array $config): void
    {
        $this->disconnect();
        $this->connect($config);
    }

    public function connection(): PDO
    {
        if ($this->pdo === null) {
            throw new \RuntimeException('No active database connection');
        }
        return $this->pdo;
    }

    public function disconnect(): void
    {
        $this->pdo = null;
    }
}
