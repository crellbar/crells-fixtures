<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\Exception\NonScalarTypeException;

class Builder
{
    public function __construct(ModificationQueue $modificationQueue)
    {
        $this->modificationQueue = $modificationQueue;
    }

    public function withData($data): void
    {
        array_walk($data, function ($datum) {
            if ($datum !== null && is_scalar($datum) === false) {
                throw new NonScalarTypeException('withData only accepts scalars in the data array');
            }
        });

        $this->modificationQueue->push(new WithDataCommand($data));
    }

    public function flush(): void
    {
        $this->modificationQueue->processAll();
    }
}
