<?php
declare(strict_types=1);

#!/usr/bin/env php
// bin/doctrine

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

// Adjust this path to your actual bootstrap.php
require_once __DIR__ . "/../bootstrap-doctrine.php";

ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);