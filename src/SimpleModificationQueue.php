<?php

namespace Crellbar\CrellsFixtures;

class SimpleModificationQueue implements ModificationQueue
{
    private $fifoQueue;

    public function __construct()
    {
        $this->fifoQueue = new \SplQueue();
    }

    public function enqueue($command)
    {
        $this->fifoQueue->enqueue($command);
    }

    public function processAll()
    {
        while (!$this->fifoQueue->isEmpty()) {
            $command = $this->fifoQueue->dequeue();
            $command->exec();
        }
    }
}
