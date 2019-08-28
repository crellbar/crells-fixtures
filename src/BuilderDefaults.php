<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

interface BuilderDefaults
{
    public function apply(Builder $builder): void;
}
