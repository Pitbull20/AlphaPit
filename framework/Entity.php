<?php
namespace AlphaPit;

use PDO;

class Entity extends Model
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, $this->table);
    }
}
