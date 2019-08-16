<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures\AdaptorExample;

use Crellbar\CrellsFixtures\DataStore;

class EchoingStore implements DataStore
{
    public function store(string $dataType, $data): void
    {
        echo 'Wrote to ' . $dataType . ' with ' . var_export($data, true);
    }

}