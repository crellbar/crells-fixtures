<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

class SimpleModificationQueue implements ModificationQueue
{
    private $fifoQueue;

    public function __construct()
    {
        $this->fifoQueue = new \SplQueue();
    }

    public function enqueue(Command $command): void
    {
        $this->fifoQueue->enqueue($command);
    }

    public function processAll(): void
    {
        while (!$this->fifoQueue->isEmpty()) {
            $command = $this->fifoQueue->dequeue();
            $command->exec();
        }
    }
}
