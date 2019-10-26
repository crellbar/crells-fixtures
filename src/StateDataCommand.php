<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

class StateDataCommand implements DataCommand
{
    /** @var string */
    private $state;
    /** @var StateData */
    private $stateData;

    public function __construct(string $state, StateData $stateData)
    {
        $this->state = $state;
        $this->stateData = $stateData;
    }

    public function exec(ObjectGraphNode $objectGraphNode): void
    {
        $data = $this->stateData->stateData($this->state);
        foreach ($data as $key => $value) {
            $objectGraphNode[$key] = $value;
        }
    }
}
