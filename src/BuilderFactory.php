<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

class BuilderFactory
{
    private $dataStoreProvider;

    public function __construct(DataStoreProvider $dataStoreProvider)
    {
        $this->dataStoreProvider = $dataStoreProvider;
    }

    public function builder(string $entityType)
    {
        return new Builder(
            $this->createModificationQueue($entityType),
            $this->createObjectGraphNode($entityType)
        );
    }

    protected function createModificationQueue(string $entityType): ModificationQueue
    {
        return new SimpleModificationQueue();
    }

    protected function createObjectGraphNode(string $entityType): ObjectGraphNode
    {
        return new ObjectGraphNode(
            $entityType,
            $this->dataStoreProvider->provideStore($entityType)
        );
    }
}
