<?php

namespace spec\Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\Builder;
use Crellbar\CrellsFixtures\FluidBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FluidBuilderSpec extends ObjectBehavior
{
    function let(Builder $builder)
    {
        $this->beConstructedWith($builder);
    }

    function it_proxies_data_to_builder(Builder $builder)
    {
        $this->beConstructedWith($builder);
        $this->withData(['foo' => 'bar']);
        $this->withData(['raz' => 'van']);
        $builder->withData(['foo' => 'bar'])->shouldHaveBeenCalled();
        $builder->withData(['raz' => 'van'])->shouldHaveBeenCalled();
    }

    function it_proxies_state_to_builder(Builder $builder)
    {
        $this->beConstructedWith($builder);
        $this->is('state1');
        $this->with('state2');
        $builder->is('state1')->shouldHaveBeenCalled();
        $builder->with('state2')->shouldHaveBeenCalled();
    }

    function it_proxies_flush_to_builder(Builder $builder)
    {
        $this->beConstructedWith($builder);
        $this->flush();
        $builder->flush()->shouldHaveBeenCalled();
    }

    function it_should_provide_a_fluid_interface_from_all_methods()
    {
        $this->withData(['foo' => 'bar'])
            ->withData(['raz', 'van'])
            ->is('a_state')
            ->with('other_state')
            ->flush()
            ->shouldBe($this);
    }
}
