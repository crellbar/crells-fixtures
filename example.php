<?php

$builder = new \Crellbar\CrellsFixtures\Builder(
    new \Crellbar\CrellsFixtures\SimpleModificationQueue(),
    new \Crellbar\CrellsFixtures\ObjectGraphNode(
        'user',
        new \Crellbar\CrellsFixtures\AdaptorExample\ArrayStore()
    )
);

$builder->withData(['username' => 'razzie']);
$builder->withData(['email' => 'razzie@example.com', 'nationality' => 'Russian']);
