<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\Exception\NonScalarTypeException;

class Builder
{
    public function withData($data)
    {
        array_walk($data, function ($datum) {
            if (($datum instanceof self) === false && $datum !== null && is_scalar($datum) === false) {
                throw new NonScalarTypeException('withData only accepts scalars in the data array');
            }
        });
    }
}
