<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

class ObjectGraphNode implements \ArrayAccess
{
    private $data = [];

    private $dataType;
    private $store;
    private $defaults;

    public function __construct(string $dataType, DataStore $store, DataDefaults $defaults)
    {
        $this->store = $store;
        $this->dataType = $dataType;
        $this->defaults = $defaults;
    }

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        throw new \BadMethodCallException("Unsetting of object graph node data is not supported");
    }

    public function write(): void
    {
        $this->applyDefaults();
        $this->store->store($this->dataType, $this->data);
    }

    private function applyDefaults()
    {
        $availableDefaults = $this->defaults->getDefaultsForType($this->dataType);
        $this->data = array_merge($availableDefaults, $this->data);
    }
}
