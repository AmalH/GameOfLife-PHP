<?php

namespace GameOfLife\Main;

use GameOfLife\Exception\InputNotFoundException;
use GameOfLife\Service\GameOfLifeService;

class GameOfLife
{

    private $gameOfLifeService;

    public function __construct(GameOfLifeService $gameOfLifeService)
    {
        $this->gameOfLifeService = $gameOfLifeService;
    }

    public function run(string $input): void
    {

        $generationIndex = 1;
        $this->gameOfLifeService->setGameGrid($input);

        try {
            if (empty($this->gameOfLifeService->getGameGrid())) {
                throw new InputNotFoundException();
            }
            while (1) {
                sleep(2);
                system('cls');
                print "Generation " .$generationIndex.":\n";
                print $input;
                $input = $this->gameOfLifeService->createNextGeneration();
                $generationIndex++;
            }
        }catch (InputNotFoundException $exp){
            echo $exp->errorMessage();
        }
    }
}
