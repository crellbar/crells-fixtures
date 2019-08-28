<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures\AdaptorExample;

use Crellbar\CrellsFixtures\Builder;
use Crellbar\CrellsFixtures\BuilderDefaults;

class ArrayDrivenBuilderDefaults implements BuilderDefaults
{
    private $defaults;

    /**
     * @note this implementation is truly shit as you can't have uniques but there'll be a real impl for this in time driven by config allowing uniques, late bound values, possibly default states if the concept works, etc
     * @param array $defaultsData In form ['entityType' => ['property' => 'value']]
     */
    public function __construct(array $defaultsData)
    {
        $this->defaults = $defaultsData;
    }

    public function apply(Builder $builder): void
    {
        // TODO: Review, this is one of the things making me think this approach is a bit shit, tda
        $entityType = $builder->entityType();

        if (!array_key_exists($entityType, $this->defaults)) {
            throw new \Exception('No default values found for type');
        }

        $defaultValuesForType = $this->defaults[$entityType];

        if (!is_array($defaultValuesForType)) {
            throw new \Exception('Defaults for ' . $entityType . ' were not provided as an array');
        }

        $builder->withData($defaultValuesForType);
    }
}