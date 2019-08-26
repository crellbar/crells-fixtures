<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures\AdaptorExample;

use Crellbar\CrellsFixtures\DataStore;
use Crellbar\CrellsFixtures\DataStoreProvider;

class EchoingStoreProvider implements DataStoreProvider
{
    public function provideStore($entityType): DataStore
    {
        return new EchoingStore();
    }
}
