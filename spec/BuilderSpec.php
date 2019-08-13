<?php declare(strict_types=1);

namespace spec\Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\Builder;
use Crellbar\CrellsFixtures\Exception\NonScalarTypeException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuilderSpec extends ObjectBehavior
{
    function it_should_accept_scalar_data_fields()
    {
        $this->withData([
            'some_string' => 'some_value',
            'some_int' => 10,
            'some_float' => 21.17,
            'some_bool' => true,
        ]);
    }

    function it_should_accept_null_data_fields()
    {
        $this->withData([
            'some_null' => null,
        ]);
    }

    function it_should_throw_if_data_is_not_a_scalar()
    {
        $expectedException = new NonScalarTypeException('withData only accepts scalars in the data array');

        $this->shouldThrow($expectedException)->duringWithData([
            'some_array' => [],
        ]);

        $this->shouldThrow($expectedException)->duringWithData([
            'some_object' => new \stdClass(),
        ]);

        $resource = fopen('php://memory', 'r+');
        $this->shouldThrow($expectedException)->duringWithData([
            'some_resource' => $resource
        ]);
        fclose($resource);
    }
}
