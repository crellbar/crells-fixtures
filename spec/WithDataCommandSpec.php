<?php

namespace spec\Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\DataCommand;
use Crellbar\CrellsFixtures\ObjectGraphNode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WithDataCommandSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([]);
    }

    function it_is_a_command()
    {
        $this->shouldHaveType(DataCommand::class);
    }

    public function it_should_write_datum_to_object_graph_node(ObjectGraphNode $objectGraphNode)
    {
        $this->beConstructedWith(['some_string' => 'some_value']);
        $this->exec($objectGraphNode);
        $objectGraphNode->offsetSet('some_string', 'some_value')->shouldHaveBeenCalled();
    }

    public function it_should_write_data_to_object_graph_node(ObjectGraphNode $objectGraphNode)
    {
        $this->beConstructedWith([
            'some_string' => 'some_value',
            'some_int' => 32
        ]);
        $this->exec($objectGraphNode);
        $objectGraphNode->offsetSet('some_string', 'some_value')->shouldHaveBeenCalled();
        $objectGraphNode->offsetSet('some_int', 32)->shouldHaveBeenCalled();
    }
}
