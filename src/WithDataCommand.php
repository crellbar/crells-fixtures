<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

class WithDataCommand implements Command
{
    /** @var array */
    private $data;
    /** @var ObjectGraphNode */
    private $node;

    public function __construct(array $data, ObjectGraphNode $node)
    {
        $this->data = $data;
        $this->node = $node;
    }

    public function exec()
    {
        foreach ($this->data as $key => $datum) {
            $this->node[$key] = $datum;
        }
    }
}
