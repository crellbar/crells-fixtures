<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

interface DataStoreProvider
{
    public function provideStore($entityType): DataStore;
}
