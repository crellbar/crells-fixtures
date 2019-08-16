<?php

namespace spec\Crellbar\CrellsFixtures;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Crellbar\CrellsFixtures\DataStore;

class ObjectGraphNodeSpec extends ObjectBehavior
{
    function let(DataStore $dataStore)
    {
        $this->beConstructedWith('bucket', $dataStore);
    }

    function it_allows_array_access()
    {
        $this->beAnInstanceOf(\ArrayAccess::class);
    }

    function it_allows_setting_and_getting_of_data()
    {
        $this['foo'] = 'bar';
        $this->offsetSet('raz', 'van');

        $this->shouldHaveKeyWithValue('raz', 'van');
        $this->shouldHaveKeyWithValue('foo', 'bar');
    }

    function it_allows_checking_if_data_is_set()
    {
        $this['foo'] = 'bar';

        $this->shouldHaveKey('foo');
    }

    function it_returns_null_when_getting_datum_that_is_not_set()
    {
        $this['foo']->shouldBe(null);
    }

    function it_prevents_unsetting_of_data()
    {
        $expectedException = new \BadMethodCallException("unsetting of object graph node data is not supported");

        $this['foo'] = 'bar';

        $this->shouldThrow($expectedException)->duringOffsetUnset('foo');
        $this->shouldThrow($expectedException)->duringOffsetUnset('other');
    }

    function it_should_send_data_to_persistence(DataStore $dataStore)
    {
        $this->beConstructedWith('bucket_table_etc', $dataStore);

        $this['foo'] = 'bar';
        $this['raz'] = 'van';
        $this->write();

        $dataStore->store('bucket_table_etc', [
            'foo' => 'bar',
            'raz' => 'van',
        ])->shouldBeCalled();
    }
}
