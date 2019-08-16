<?php

namespace spec\Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\ModificationQueue;
use Crellbar\CrellsFixtures\Command;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimpleModificationQueueSpec extends ObjectBehavior
{
    function it_is_a_modification_queue()
    {
        $this->shouldHaveType(ModificationQueue::class);
    }

    function it_should_process_a_command(Command $command)
    {
        $this->enqueue($command);
        $this->processAll();
        $command->exec()->shouldHaveBeenCalled();
    }

    function it_should_process_multiple_commands(Command $command1, Command $command2)
    {
        $this->enqueue($command1);
        $this->enqueue($command2);

        $this->processAll();

        $command1->exec()->shouldHaveBeenCalled();
        $command2->exec()->shouldHaveBeenCalled();
    }

    function it_should_only_process_each_command_once(Command $command1, Command $command2)
    {
        $this->enqueue($command1);
        $this->processAll();
        $this->enqueue($command2);
        $this->processAll();
        $this->processAll();

        $command1->exec()->shouldHaveBeenCalledOnce();
        $command2->exec()->shouldHaveBeenCalledOnce();
    }
}
