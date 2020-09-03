<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use GameOfLife\Main\GameOfLife;
use GameOfLife\Service\GameOfLifeService;

if (!isset($argv[1])) {
    exit("Please provide an input file !\n");
}
$filename = $argv[1];

(new GameOfLife(new GameOfLifeService()))->run(file_get_contents($filename));
