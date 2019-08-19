<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

class WithDataCommand implements DataCommand
{
    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function exec(ObjectGraphNode $objectGraphNode): void
    {
        foreach ($this->data as $key => $datum) {
            $objectGraphNode[$key] = $datum;
        }
    }
}
