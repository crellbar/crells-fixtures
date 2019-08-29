<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\Exception\NonScalarTypeException;

class Builder
{
    private $modificationQueue;
    private $objectGraphNode;

    public function __construct(ModificationQueue $modificationQueue, ObjectGraphNode $objectGraphNode)
    {
        $this->modificationQueue = $modificationQueue;
        $this->objectGraphNode = $objectGraphNode;
    }

    public function withData($data): void
    {
        array_walk($data, function ($datum) {
            if ($datum !== null && is_scalar($datum) === false) {
                throw new NonScalarTypeException('withData only accepts scalars in the data array');
            }
        });

        $this->modificationQueue->enqueue(new WithDataCommand($data));
    }

    public function flush(): void
    {
        $this->modificationQueue->processAll($this->objectGraphNode);
        $this->objectGraphNode->write();
    }
}
