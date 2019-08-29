<?php

namespace spec\Crellbar\CrellsFixtures;

use Crellbar\CrellsFixtures\DataDefaults;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Crellbar\CrellsFixtures\DataStore;
use Prophecy\Prophecy\ObjectProphecy;

class ObjectGraphNodeSpec extends ObjectBehavior
{
    /** @var DataStore|ObjectProphecy */
    private $dataStore;
    /** @var DataDefaults|ObjectProphecy */
    private $defaults;

    function let(DataStore $dataStore, DataDefaults $defaults)
    {
        $this->defaults = $defaults;
        $this->dataStore = $dataStore;

        $this->defaults->getDefaultsForType(Argument::type('string'))->willReturn([]);

        $this->beConstructedWith('bucket', $dataStore, $defaults);
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
        $expectedException = new \BadMethodCallException("Unsetting of object graph node data is not supported");

        $this['foo'] = 'bar';

        $this->shouldThrow($expectedException)->duringOffsetUnset('foo');
        $this->shouldThrow($expectedException)->duringOffsetUnset('other');
    }

    function it_should_send_data_to_persistence()
    {
        $this->beConstructedWith('bucket_table_etc', $this->dataStore, $this->defaults);

        $this['foo'] = 'bar';
        $this['raz'] = 'van';

        $this->write();

        $this->dataStore->store('bucket_table_etc', [
            'foo' => 'bar',
            'raz' => 'van',
        ])->shouldBeCalled();
    }

    function it_should_pass_defaults_to_the_datastore()
    {
        $this->defaults->getDefaultsForType('bucket')->willReturn(['k' => 'v']);

        $this->write();

        $this->dataStore->store('bucket', ['k' => 'v'])->shouldHaveBeenCalled();
    }

    function it_should_only_pass_default_where_no_value_has_previously_been_set()
    {
        $this->defaults->getDefaultsForType('bucket')->willReturn(['k' => 'v', 'l' => 'w']);

        $this['l'] = 'm';

        $this->write();

        $this->dataStore->store('bucket', ['k' => 'v', 'l' => 'm'])->shouldHaveBeenCalled();
    }

    function it_should_apply_defaults_to_the_node_data()
    {
        $this->defaults->getDefaultsForType('bucket')->willReturn(['k' => 'v']);

        $this->write();

        $this['k']->shouldBe('v');
    }

    function it_should_apply_defaults_to_the_node_data_only_where_values_have_not_previouisly_been_set()
    {
        $this->defaults->getDefaultsForType('bucket')->willReturn(['k' => 'v', 'l' => 'w']);
        $this['l'] = 'm';

        $this->write();

        $this['k']->shouldBe('v');
        $this['l']->shouldBe('m');
    }

    function it_should_also_respect_previously_set_falsy_values_when_loading_defaults(DataStore $dataStore, DataDefaults $defaults)
    {
        $this->beConstructedWith('bucket', $dataStore, $defaults);
        $this->defaults->getDefaultsForType('bucket')->willReturn([
            'a' => 'applied',
            'b' => 'applied',
            'c' => 'applied',
            'd' => 'applied',
            'e' => 'applied',
            'f' => 'applied',
        ]);

        $this['a'] = false;
        $this['b'] = 0;
        $this['c'] = "0";
        $this['d'] = null;
        $this['e'] = [];
        $this['f'] = "";

        $this->write();

        $this['a']->shouldBe(false);
        $this['b']->shouldBe(0);
        $this['c']->shouldBe("0");
        $this['d']->shouldBe(null);
        $this['e']->shouldBe([]);
        $this['f']->shouldBe("");
    }
}
