<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

interface ModificationQueue
{
    public function enqueue(DataCommand $command): void;

    public function processAll(ObjectGraphNode $objectGraphNode): void;
}
