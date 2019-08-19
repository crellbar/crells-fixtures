<?php

namespace spec\Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\ModificationQueue;
use Crellbar\CrellsFixtures\DataCommand;
use Crellbar\CrellsFixtures\ObjectGraphNode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimpleModificationQueueSpec extends ObjectBehavior
{
    function it_is_a_modification_queue()
    {
        $this->shouldHaveType(ModificationQueue::class);
    }

    function it_should_process_a_command(DataCommand $command, ObjectGraphNode $objectGraphNode)
    {
        $this->enqueue($command);
        $this->processAll($objectGraphNode);
        $command->exec($objectGraphNode)->shouldHaveBeenCalled();
    }

    function it_should_process_multiple_commands(DataCommand $command1, DataCommand $command2, ObjectGraphNode $objectGraphNode)
    {
        $this->enqueue($command1);
        $this->enqueue($command2);

        $this->processAll($objectGraphNode);

        $command1->exec($objectGraphNode)->shouldHaveBeenCalled();
        $command2->exec($objectGraphNode)->shouldHaveBeenCalled();
    }

    function it_should_only_process_each_command_once(DataCommand $command1, DataCommand $command2, ObjectGraphNode $objectGraphNode)
    {
        $this->enqueue($command1);
        $this->processAll($objectGraphNode);
        $this->enqueue($command2);
        $this->processAll($objectGraphNode);
        $this->processAll($objectGraphNode);

        $command1->exec($objectGraphNode)->shouldHaveBeenCalledOnce();
        $command2->exec($objectGraphNode)->shouldHaveBeenCalledOnce();
    }
}
