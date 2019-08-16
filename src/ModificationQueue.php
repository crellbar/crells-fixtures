<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

interface ModificationQueue
{
    public function enqueue(Command $command): void;

    public function processAll(): void;
}
