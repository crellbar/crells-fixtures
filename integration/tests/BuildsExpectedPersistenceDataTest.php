<?php declare(strict_types=1);

namespace Crellbar\CrellsFixtures\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Crellbar\CrellsFixtures as CF;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class BuildsExpectedPersistenceDataTest extends TestCase
{
    /** @var CF\FluidBuilder */
    private $builder;

    /** @var CF\DataStore|ObjectProphecy */
    private $dataStore;
    private $fixedUserDefaults;

    public function setUp(): void
    {
        parent::setUp();

        $faker = \Faker\Factory::create();

        $this->dataStore = $this->prophesize(CF\DataStore::class);
        $dataStoreProvider = $this->prophesize(CF\DataStoreProvider::class);
        $dataStoreProvider->provideStore(Argument::any())->willReturn($this->dataStore->reveal());

        $builderFactory = null;

        $this->fixedUserDefaults = [
            'timezone' => null,
            'username' => $faker->userName,
            'email' => $faker->email,
            'nationality' => $faker->randomElement(['Russian', 'British', 'Aussie']),
            'account_confirmed' => $faker->boolean,
            'deleted' => $faker->boolean,
        ];

        /** @var ObjectProphecy|CF\DataDefaults $defaultData */
        $defaultData = $this->prophesize(CF\DataDefaults::class);
        /** @var ObjectProphecy|CF\StateData $stateData */
        $stateData = $this->prophesize(CF\StateData::class);

        $defaultData->getDefaultsForType('user')->willReturn($this->fixedUserDefaults);
        $stateData->stateData('valid')->willReturn([
            'account_confirmed' => true,
            'deleted' => false,
        ]);
        $stateData->stateData('deleted')->willReturn([
            'deleted' => true,
        ]);

        $dataDefaults = new CF\AdaptorExample\ArrayDrivenDataDefaults(
            [
                'user' => $this->fixedUserDefaults
            ],
            [
                'valid' => [
                    'account_confirmed' => true,
                    'deleted' => false,
                ],
                'deleted' => [
                    'deleted' => true,
                ],
            ]
        );

        $builderFactory = new CF\BuilderFactory(
            $dataStoreProvider->reveal(),
            $defaultData->reveal(),
            $stateData->reveal()
        );

        $fluidBuilderFactory = new CF\FluidBuilderFactory($builderFactory);
        $this->builder = $fluidBuilderFactory->builder('user');
    }

    /** @test */
    public function it_passes_default_values_to_store()
    {
        $this->builder->flush();

        $this->dataStore->store('user', $this->fixedUserDefaults)->shouldHaveBeenCalled();
    }

    /** @test */
    public function it_passes_data_values_to_store_when_provided()
    {
        $valuesForAllProperties = [
            'timezone' => null,
            'username' => 'SomeUser',
            'email' => 'SomeUser@example.org',
            'nationality' => 'British',
            'account_confirmed' => true,
            'deleted' => false,
        ];

        $this->builder->withData($valuesForAllProperties);
        $this->builder->flush();

        $this->dataStore->store('user', $valuesForAllProperties)->shouldHaveBeenCalled();
    }

    /** @test */
    public function it_passes_overriden_values_falling_back_to_defaults()
    {
        $valuesForAllProperties = $this->fixedUserDefaults;
        $dataOverrrides = [
            'email' => 'SomeUser@example.org',
            'nationality' => 'Aussie',
        ];
        $valuesForAllProperties['email'] = $dataOverrrides['email'];
        $valuesForAllProperties['nationality'] = $dataOverrrides['nationality'];

        $this->builder->withData($dataOverrrides);
        $this->builder->flush();

        $this->dataStore->store('user', $valuesForAllProperties)->shouldHaveBeenCalled();
    }

    /** @test */
    public function it_uses_the_latest_values()
    {
        $valuesForAllProperties = $this->fixedUserDefaults;
        $notSentForAllProperties = $this->fixedUserDefaults;
        $notSentForAllProperties['email'] = 'initial@example.org';
        $valuesForAllProperties['email'] = 'overridden@example.org';

        $this->builder->withData(['email' => 'initial@example.org']);
        $this->builder->withData(['email' => 'overridden@example.org']);
        $this->builder->flush();

        $this->dataStore->store('user', $valuesForAllProperties)->shouldHaveBeenCalled();
        $this->dataStore->store('user', $notSentForAllProperties)->shouldNotHaveBeenCalled();
    }

    /** @test */
    public function it_applies_state()
    {
        $expectedValues = $this->fixedUserDefaults;
        $expectedValues['account_confirmed'] = true;
        $expectedValues['deleted'] = false;

        $this->builder->is('valid');
        $this->builder->flush();

        $this->dataStore->store('user', $expectedValues)->shouldHaveBeenCalled();
    }

    /** @test */
    public function it_combines_states()
    {
        $expectedValues = $this->fixedUserDefaults;
        $expectedValues['account_confirmed'] = true;
        $expectedValues['deleted'] = true;

        $this->builder->is('valid');
        $this->builder->is('deleted');
        $this->builder->flush();

        $this->dataStore->store('user', $expectedValues)->shouldHaveBeenCalled();
    }

    /** @test */
    public function it_overrides_state_data_with_values_when_called_in_order()
    {
        $expectedValues = $this->fixedUserDefaults;
        $expectedValues['deleted'] = false;

        $this->builder->is('deleted');
        $this->builder->withData(['deleted' => false]);
        $this->builder->flush();

        $this->dataStore->store('user', $expectedValues)->shouldHaveBeenCalled();
    }

    /** @test */
    public function it_overrides_values_with_state_data_when_called_in_order()
    {
        $expectedValues = $this->fixedUserDefaults;
        $expectedValues['deleted'] = true;

        $this->builder->withData(['deleted' => false]);
        $this->builder->is('deleted');
        $this->builder->flush();

        $this->dataStore->store('user', $expectedValues)->shouldHaveBeenCalled();
    }
}
