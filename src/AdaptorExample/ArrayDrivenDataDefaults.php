<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures\AdaptorExample;

use Crellbar\CrellsFixtures\DataDefaults;
use Crellbar\CrellsFixtures\StateData;

class ArrayDrivenDataDefaults implements DataDefaults, StateData
{
    private $defaults;
    private $states;

    /**
     * @param array $defaultsData In form ['entityType' => ['property' => 'value']]
     * @param array $states In form ['state' => ['property' => 'value']]
     */
    public function __construct(array $defaultsData, array $states)
    {
        $this->defaults = $defaultsData;
        $this->states = $states;
    }

    public function getDefaultsForType(string $type): array
    {
        if (!array_key_exists($type, $this->defaults)) {
            throw new \Exception('No default values found for type');
        }

        $defaultValuesForType = $this->defaults[$type];

        if (!is_array($defaultValuesForType)) {
            throw new \Exception('Defaults for ' . $type . ' were not provided as an array');
        }

        return $defaultValuesForType;
    }

    public function stateData($state): array
    {
        return $this->states[$state];
    }
}