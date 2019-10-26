<?php declare(strict_types=1);

namespace spec\Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\Exception\NonScalarTypeException;
use Crellbar\CrellsFixtures\ObjectGraphNode;
use Crellbar\CrellsFixtures\StateData;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Crellbar\CrellsFixtures\ModificationQueue;
use Crellbar\CrellsFixtures\WithDataCommand;
use Crellbar\CrellsFixtures\StateDataCommand;

class BuilderSpec extends ObjectBehavior
{

    function let(ModificationQueue $modificationQueue, ObjectGraphNode $objectGraphNode, StateData $stateData)
    {
        $this->beConstructedWith($modificationQueue, $objectGraphNode, $stateData);
    }

    function it_should_accept_scalar_data_fields()
    {
        $this->withData([
            'some_string' => 'some_value',
            'some_int' => 10,
            'some_float' => 21.17,
            'some_bool' => true,
        ]);
    }

    function it_should_accept_null_data_fields()
    {
        $this->withData([
            'some_null' => null,
        ]);
    }

    function it_should_throw_if_data_is_not_a_scalar()
    {
        $expectedException = new NonScalarTypeException('withData only accepts scalars in the data array');

        $this->shouldThrow($expectedException)->duringWithData([
            'some_array' => [],
        ]);

        $this->shouldThrow($expectedException)->duringWithData([
            'some_object' => new \stdClass(),
        ]);

        $resource = fopen('php://memory', 'r+');
        $this->shouldThrow($expectedException)->duringWithData([
            'some_resource' => $resource
        ]);
        fclose($resource);
    }

    function it_should_push_the_data_to_the_modification_queue(ModificationQueue $modificationQueue, ObjectGraphNode $objectGraphNode, StateData $stateData)
    {
        $this->beConstructedWith($modificationQueue, $objectGraphNode, $stateData);
        $this->withData([
            'some_string' => 'some value'
        ]);
        $modificationQueue->enqueue(Argument::type(WithDataCommand::class))->shouldHaveBeenCalled();
    }

    function it_should_push_the_is_state_to_the_modification_queue(ModificationQueue $modificationQueue, ObjectGraphNode $objectGraphNode, StateData $stateData)
    {
        $this->beConstructedWith($modificationQueue, $objectGraphNode, $stateData);
        $this->is('some_state');
        $modificationQueue->enqueue(Argument::type(StateDataCommand::class))->shouldHaveBeenCalled();
    }

    function it_should_push_the_with_state_to_the_modification_queue(ModificationQueue $modificationQueue, ObjectGraphNode $objectGraphNode, StateData $stateData)
    {
        $this->beConstructedWith($modificationQueue, $objectGraphNode, $stateData);
        $this->with('some_state');
        $modificationQueue->enqueue(Argument::type(StateDataCommand::class))->shouldHaveBeenCalled();
    }

    function it_should_process_the_queue_on_flush(ModificationQueue $modificationQueue, ObjectGraphNode $objectGraphNode, StateData $stateData)
    {
        $this->beConstructedWith($modificationQueue, $objectGraphNode, $stateData);
        $this->flush();
        $modificationQueue->processAll($objectGraphNode)->shouldHaveBeenCalled();
    }

    function it_should_persist_the_processed_object_graph_node(ModificationQueue $modificationQueue, ObjectGraphNode $objectGraphNode, StateData $stateData)
    {
        $this->beConstructedWith($modificationQueue, $objectGraphNode, $stateData);
        $this->flush();
        $objectGraphNode->write()->shouldHaveBeenCalled();
    }
}
