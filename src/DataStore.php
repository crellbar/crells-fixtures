<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

interface DataStore
{
    public function store(string $dataType, $data): void;
}
