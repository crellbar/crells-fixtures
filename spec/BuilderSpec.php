<?php declare(strict_types=1);

namespace spec\Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\Exception\NonScalarTypeException;
use Crellbar\CrellsFixtures\ObjectGraphNode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Crellbar\CrellsFixtures\ModificationQueue;
use Crellbar\CrellsFixtures\WithDataCommand;

class BuilderSpec extends ObjectBehavior
{

    function let(ModificationQueue $modificationQueue, ObjectGraphNode $objectGraphNode)
    {
        $this->beConstructedWith($modificationQueue, $objectGraphNode);
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

    function it_should_push_the_data_to_the_modification_queue(ModificationQueue $modificationQueue, ObjectGraphNode $objectGraphNode)
    {
        $this->beConstructedWith($modificationQueue, $objectGraphNode);
        $this->withData([
            'some_string' => 'some value'
        ]);
        $modificationQueue->enqueue(Argument::type(WithDataCommand::class))->shouldHaveBeenCalled();
    }

    function it_should_process_the_queue_on_flush(ModificationQueue $modificationQueue, ObjectGraphNode $objectGraphNode)
    {
        $this->beConstructedWith($modificationQueue, $objectGraphNode);
        $this->flush();
        $modificationQueue->processAll($objectGraphNode)->shouldHaveBeenCalled();
    }

    function it_should_persist_the_processed_object_graph_node(ModificationQueue $modificationQueue, ObjectGraphNode $objectGraphNode)
    {
        $this->beConstructedWith($modificationQueue, $objectGraphNode);
        $this->flush();
        $objectGraphNode->write()->shouldHaveBeenCalled();
    }

    // TODO: really though, should it? shut up
    function it_should_reveal_the_type_of_the_entity_being_built(ModificationQueue $modificationQueue, ObjectGraphNode $objectGraphNode)
    {
        $this->beConstructedWith($modificationQueue, $objectGraphNode);
        $objectGraphNode->entityType()->willReturn('tippytype');
        $this->entityType()->shouldBe('tippytype');
    }
}
