<?php

namespace spec\Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\Builder;
use Crellbar\CrellsFixtures\DataDefaults;
use Crellbar\CrellsFixtures\DataStore;
use Crellbar\CrellsFixtures\DataStoreProvider;
use Crellbar\CrellsFixtures\StateData;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuilderFactorySpec extends ObjectBehavior
{

    function let(DataStoreProvider $dataStoreProvider, DataStore $dataStore, DataDefaults $defaults, StateData $stateData)
    {
        $dataStoreProvider->provideStore(Argument::cetera())->willReturn($dataStore);
        $this->beConstructedWith($dataStoreProvider, $defaults, $stateData);
    }

    function it_should_return_builder()
    {
        $this->builder('some_type')->shouldReturnAnInstanceOf(Builder::class);
    }

    function it_should_use_the_provider_to_satisfy_the_datastore(DataStoreProvider $dataStoreProvider, DataStore $dataStore, DataDefaults $defaults, StateData $stateData)
    {
        $dataStoreProvider->provideStore(Argument::cetera())->willReturn($dataStore);
        $this->beConstructedWith($dataStoreProvider, $defaults, $stateData);
        $type = 'this_type';

        $this->builder($type);

        $dataStoreProvider->provideStore($type)->shouldHaveBeenCalled();
    }
}
