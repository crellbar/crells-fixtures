<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures\AdaptorExample;

use Crellbar\CrellsFixtures\DataDefaults;

class ArrayDrivenDataDefaults implements DataDefaults
{
    private $defaults;

    /**
     * @param array $defaultsData In form ['entityType' => ['property' => 'value']]
     */
    public function __construct(array $defaultsData)
    {
        $this->defaults = $defaultsData;
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
}