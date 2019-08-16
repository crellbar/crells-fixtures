<?php

require_once 'vendor/autoload.php';

use Crellbar\CrellsFixtures as CF;

$builder = new CF\FluidBuilder(
    new CF\Builder(
        new CF\SimpleModificationQueue(),
        new CF\ObjectGraphNode(
            'user',
            new CF\AdaptorExample\EchoingStore()
        )
    )
);

$builder
    ->withData(['username' => 'razzie'])
    ->withData(['email' => 'razzie@example.com', 'nationality' => 'Russian'])
    ->flush();
