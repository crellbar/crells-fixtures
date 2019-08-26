<?php

namespace spec\Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\Builder;
use Crellbar\CrellsFixtures\BuilderFactory;
use Crellbar\CrellsFixtures\FluidBuilder;
use Crellbar\CrellsFixtures\FluidBuilderFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FluidBuilderFactorySpec extends ObjectBehavior
{
    function let(BuilderFactory $builderFactory, Builder $builder)
    {
        $this->beConstructedWith($builderFactory);
        $builderFactory->builder(Argument::cetera())->willReturn($builder);
    }

    function it_should_return_a_fluid_builder()
    {
        $this->builder('user')->shouldReturnAnInstanceOf(FluidBuilder::class);
    }

    function it_proxies_builder_request_on_to_builder_factory(BuilderFactory $builderFactory, Builder $builder)
    {
        $this->beConstructedWith($builderFactory);
        $builderFactory->builder(Argument::cetera())->willReturn($builder);

        $this->builder('user');

        $builderFactory->builder('user')->shouldHaveBeenCalled();
    }
}
