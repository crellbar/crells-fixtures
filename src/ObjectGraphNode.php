<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

class ObjectGraphNode implements \ArrayAccess
{
    private $data = [];

    public function __construct()
    {
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
//        $this->persistence->store('bucket/table/etc', $this->data);
    }
}
