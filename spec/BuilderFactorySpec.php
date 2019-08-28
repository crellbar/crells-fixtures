<?php

namespace spec\Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\Builder;
use Crellbar\CrellsFixtures\BuilderDefaults;
use Crellbar\CrellsFixtures\DataStore;
use Crellbar\CrellsFixtures\DataStoreProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuilderFactorySpec extends ObjectBehavior
{

    function let(DataStoreProvider $dataStoreProvider, DataStore $dataStore, BuilderDefaults $defaults)
    {
        $dataStoreProvider->provideStore(Argument::cetera())->willReturn($dataStore);
        $this->beConstructedWith($dataStoreProvider, $defaults);
    }

    function it_should_return_builder()
    {
        $this->builder('some_type')->shouldReturnAnInstanceOf(Builder::class);
    }

    function it_should_use_the_provider_to_satisfy_the_datastore(DataStoreProvider $dataStoreProvider, DataStore $dataStore, BuilderDefaults $defaults)
    {
        $dataStoreProvider->provideStore(Argument::cetera())->willReturn($dataStore);
        $this->beConstructedWith($dataStoreProvider, $defaults);
        $type = 'this_type';

        $this->builder($type);

        $dataStoreProvider->provideStore($type)->shouldHaveBeenCalled();
    }

    function it_should_apply_defaults_to_the_builder(DataStoreProvider $dataStoreProvider, DataStore $dataStore, BuilderDefaults $defaults)
    {
        $this->beConstructedWith($dataStoreProvider, $defaults);

        $builder = $this->builder('some_type');

        $defaults->apply($builder)->shouldHaveBeenCalled();
    }
}
