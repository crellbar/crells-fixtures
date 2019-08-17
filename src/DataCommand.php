<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

interface DataCommand
{
    public function exec(ObjectGraphNode $objectGraphNode): void;
}
