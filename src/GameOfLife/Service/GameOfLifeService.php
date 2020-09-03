<?php

declare(strict_types=1);

namespace GameOfLife\Service;

use GameOfLife\Entity\Cell;

class GameOfLifeService
{

    private $gameGrid;

    /**
     * set initial game grid from input
     */
    public function setGameGrid(string $input) : self
    {
        $this->gameGrid = $this->toArray($input);
        return $this;
    }

    /**
     * create next life generation
     */
    public function createNextGeneration()
    {
        foreach ($this->gameGrid as $rowIndex => $row) {
            $newRow = [];
            foreach (str_split($row) as $colIndex => $status) {
                $cell = new Cell($this->gameGrid, $rowIndex, $colIndex);
                $newRow[$colIndex] = $this->updateLife($cell);
            }
            $this->gameGrid[$rowIndex] = join("", $newRow);
        }
        return $this->toString();
    }

    /**
     * change cell life status
     */
    public function updateLife(Cell $cell) : string
    {
        $cellNeighbours = array_count_values($this->getCellNeighbours($cell));
        switch ($cell->getState()) {
            case Cell::DEAD_CELL:
                if (isset($cellNeighbours[Cell::LIVE_CELL]) && $cellNeighbours[Cell::LIVE_CELL] === 3) {
                    $cell->setState(Cell::LIVE_CELL);
                }
                break;
            case Cell::LIVE_CELL:
                if (isset($cellNeighbours[Cell::LIVE_CELL]) && ($cellNeighbours[Cell::LIVE_CELL] < 2
                        || $cellNeighbours[Cell::LIVE_CELL] > 3)) {
                    $cell->setState(Cell::DEAD_CELL);
                }
                break;
        }
        return $cell->getState();
    }

    /**
     * helpers
     */
    public function getCellNeighbours(Cell $cell) : array
    {
        $neighbourhoodOfCell = [];
        $rowsPositions = [$cell->getRowIndex() - 1, $cell->getRowIndex(), $cell->getRowIndex() + 1];
        foreach ($rowsPositions as $rowPosition) {
            if ((($rowPosition >= 0) && ($rowPosition < count($cell->getCurrentGameGrid())))) {
                $neighbourhoodOfCell = array_merge($neighbourhoodOfCell, $this->getCellNeighboursPerRow($cell,$cell->getCurrentGameGrid(),$rowPosition,$cell->getColIndex()));
            }
        }
        return $neighbourhoodOfCell;
    }

    private function getCellNeighboursPerRow(Cell $cell, $gameGrid,int $rowIndex, int $colIndex) : array
    {
        $neighbourhoodOfCellFromRow = [];
        $row = $gameGrid[$rowIndex];
        array_push($neighbourhoodOfCellFromRow, $row[$colIndex - 1] ?? '.');
        if ($cell->getRowIndex() !== $rowIndex) {
            array_push($neighbourhoodOfCellFromRow, $row[$colIndex] ?? '.');
        }
        array_push($neighbourhoodOfCellFromRow, $row[$colIndex + 1] ?? '.');
        return $neighbourhoodOfCellFromRow;
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

    public function getGameGrid()
    {
        return $this->gameGrid;
    }
}
