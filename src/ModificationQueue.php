<?php

namespace Crellbar\CrellsFixtures;

interface ModificationQueue
{

    public function push($command);

    public function processAll();
}
