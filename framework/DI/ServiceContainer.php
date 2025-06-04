<?php
namespace AlphaPit\DI;

use ReflectionClass;
use ReflectionNamedType;

class ServiceContainer
{
    private array $entries = [];

    public function set(string $id, mixed $concrete = null): void
    {
        $this->entries[$id] = $concrete ?? $id;
    }

    public function get(string $id): mixed
    {
        if (!array_key_exists($id, $this->entries)) {
            return $this->build($id);
        }

        $concrete = $this->entries[$id];

        if (is_callable($concrete)) {
            $concrete = $concrete($this);
            $this->entries[$id] = $concrete;
        } elseif (is_string($concrete) && class_exists($concrete)) {
            $concrete = $this->build($concrete);
            $this->entries[$id] = $concrete;
        }

        return $concrete;
    }

    private function build(string $class): object
    {
        $ref = new ReflectionClass($class);
        $ctor = $ref->getConstructor();
        if (!$ctor) {
            return new $class();
        }

        $params = [];
        foreach ($ctor->getParameters() as $param) {
            $type = $param->getType();
            if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                $params[] = $this->get($type->getName());
            } elseif ($param->isDefaultValueAvailable()) {
                $params[] = $param->getDefaultValue();
            } else {
                $params[] = null;
            }
        }
        return $ref->newInstanceArgs($params);
    }
}
