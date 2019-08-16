<?php

namespace Crellbar\CrellsFixtures;

class FluidBuilder
{
    private $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function withData(array $data)
    {
        $this->builder->withData($data);
        return $this;
    }

    public function flush()
    {
        $this->builder->flush();
        return $this;
    }
}
