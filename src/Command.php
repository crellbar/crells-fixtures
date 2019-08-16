<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

interface Command
{
    public function exec(): void;
}
