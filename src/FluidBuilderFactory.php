<?php

namespace Crellbar\CrellsFixtures;

class FluidBuilderFactory
{
    private $builderFactory;

    public function __construct(BuilderFactory $builderFactory)
    {
        $this->builderFactory = $builderFactory;
    }

    public function builder(string $entityType): FluidBuilder
    {
        return new FluidBuilder(
            $this->builderFactory->builder($entityType)
        );
    }
}
