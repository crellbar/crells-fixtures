<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

interface DataDefaults
{
    public function getDefaultsForType(string $type): array;
}
