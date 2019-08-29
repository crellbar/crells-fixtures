<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

class BuilderFactory
{
    private $dataStoreProvider;
    private $defaults;

    public function __construct(DataStoreProvider $dataStoreProvider, DataDefaults $defaults)
    {
        $this->dataStoreProvider = $dataStoreProvider;
        $this->defaults = $defaults;
    }

    public function builder(string $entityType)
    {
        $builder = new Builder(
            $this->createModificationQueue($entityType),
            $this->createObjectGraphNode($entityType)
        );

        return $builder;
    }

    protected function createModificationQueue(string $entityType): ModificationQueue
    {
        return new SimpleModificationQueue();
    }

    protected function createObjectGraphNode(string $entityType): ObjectGraphNode
    {
        return new ObjectGraphNode(
            $entityType,
            $this->dataStoreProvider->provideStore($entityType),
            $this->defaults
        );
    }
}
