<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

class ObjectGraphNode implements \ArrayAccess
{
    private $data = [];

    private $dataType;
    private $store;

    public function __construct(string $dataType, DataStore $store)
    {
        $this->store = $store;
        $this->dataType = $dataType;
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
        throw new \BadMethodCallException("unsetting of object graph node data is not supported");
    }

    public function write(): void
    {
        $this->store->store($this->dataType, $this->data);
    }
}
