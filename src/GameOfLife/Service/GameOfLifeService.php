<?php

declare(strict_types=1);

namespace GameOfLife\Service;

use GameOfLife\Entity\Cell;

class GameOfLifeService
{

    private $gameGrid;


    /** sets initial grid from inputs string
     * @param string $input
     * @return GameOfLifeService
     */
    public function setGameGrid(string $input) : self
    {
        $this->gameGrid = $this->toArray($input); // strings array (of lines)
        return $this;
    }
    /**
     * @return mixed
     */
    public function getGameGrid()
    {
        return $this->gameGrid;
    }


    public function createNextGeneration()
    {
        foreach ($this->gameGrid as $rowIndex => $row) {
            $newRow = [];
            foreach (str_split($row) as $colIndex => $status) { // each string (line) to an array to access its iems
                $cell = new Cell($this->gameGrid, $rowIndex, $colIndex);
                $newRow[$colIndex] = $cell->updateLife(); // change row's content applying the gameOfLife rule
            }
            $this->gameGrid[$rowIndex] = join("", $newRow); // switch surrent row with the new one
        }
        return $this->toString();
    }

    private function toArray($inputString)
    {
        $inputString = explode("\n", $inputString); /** split inputs string by backspace */
        foreach ($inputString as $index => $row) {          /** dont include empty lines in the returned array */
            if (empty($row)) {
                 unset($inputString[$index]);
            }
        }
        return $inputString;
    }

    private function toString()
    {
        $string = '';
        foreach ($this->gameGrid as $x => $row) {
            $string .= $row . "\n";
        }
        return $string;
    }
}
