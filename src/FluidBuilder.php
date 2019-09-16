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

    public function is(string $state)
    {
        $this->builder->is($state);
        return $this;
    }

    public function with(string $state)
    {
        $this->builder->with($state);
        return $this;
    }
}
