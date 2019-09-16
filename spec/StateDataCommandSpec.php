<?php

namespace spec\Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\DataCommand;
use Crellbar\CrellsFixtures\ObjectGraphNode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Crellbar\CrellsFixtures\StateData;

class StateDataCommandSpec extends ObjectBehavior
{
    public function let(StateData $stateData)
    {
        $this->beConstructedWith('let_state', $stateData);
    }

    function it_is_a_command()
    {
        $this->shouldHaveType(DataCommand::class);
    }

    public function it_should_write_state_data_to_graph_node(ObjectGraphNode $objectGraphNode, StateData $stateData)
    {
        $stateData->stateData('the_state')->willReturn([
            'k' => 'v',
            'l' => 'm',
        ]);

        $this->beConstructedWith('the_state', $stateData);

        $this->exec($objectGraphNode);

        $objectGraphNode->offsetSet('k', 'v')->shouldHaveBeenCalled();
        $objectGraphNode->offsetSet('l', 'm')->shouldHaveBeenCalled();
    }
}
