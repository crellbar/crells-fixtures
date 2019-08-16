<?php

namespace Crellbar\CrellsFixtures;

class ObjectGraphNode implements \ArrayAccess
{
    private $data = [];

    public function __construct()
    {
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        throw new \BadMethodCallException("unsetting of object graph node data is not supported");
    }

    public function write()
    {
//        $this->persistence->store('bucket/table/etc', $this->data);
    }
}
