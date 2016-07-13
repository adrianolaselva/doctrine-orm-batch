<?php
require __DIR__ . DIRECTORY_SEPARATOR . '../bootstrap.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($container['em']);