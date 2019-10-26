<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

class BuilderFactory
{
    private $dataStoreProvider;
    private $defaults;
    private $stateData;

    public function __construct(DataStoreProvider $dataStoreProvider, DataDefaults $defaults, StateData $stateData)
    {
        $this->dataStoreProvider = $dataStoreProvider;
        $this->defaults = $defaults;
        $this->stateData = $stateData;
    }

    public function builder(string $entityType)
    {
        $builder = new Builder(
            $this->createModificationQueue($entityType),
            $this->createObjectGraphNode($entityType),
            $this->stateData
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
