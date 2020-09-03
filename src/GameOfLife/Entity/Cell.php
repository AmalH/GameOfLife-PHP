<?php

namespace GameOfLife\Entity;

class Cell
{
    const LIVE_CELL = 'x';
    const DEAD_CELL = '.';
    private $currentGameGrid;
    private $rowIndex;
    private $colIndex;
    private $state;

    public function __construct(array $currentGameGrid, int $rowIndex, int $colIndex)
    {
        $this->currentGameGrid = $currentGameGrid;
        $this->rowIndex = $rowIndex;
        $this->colIndex = $colIndex;
        $this->state = $currentGameGrid[$rowIndex][$colIndex];
    }

    public function getState(): string
    {
        return $this->state;
    }

    /** Change cell status  */
    public function updateLife() : string
    {
        $cellNeighbours = array_count_values($this->getCellNeighbours($this->currentGameGrid, $this->rowIndex, $this->colIndex));
        switch ($this->state) {
            case Cell::DEAD_CELL:
                if (isset($cellNeighbours[Cell::LIVE_CELL]) && $cellNeighbours[Cell::LIVE_CELL] === 3) {
                    $this->state = Cell::LIVE_CELL;
                }
                break;
            case Cell::LIVE_CELL:
                if (isset($cellNeighbours[Cell::LIVE_CELL]) && ($cellNeighbours[Cell::LIVE_CELL] < 2
                        || $cellNeighbours[Cell::LIVE_CELL] > 3)) {
                    $this->state = Cell::DEAD_CELL;
                }
                break;
        }
        return $this->state;
    }

    /**
     * helpers
     */
    public function getCellNeighbours(array $gameGrid, int $rowIndex, int $colIndex) : array
    {
        $neighbourhoodOfCell = [];
        $rowsPositions = [$rowIndex - 1, $rowIndex, $rowIndex + 1];
        foreach ($rowsPositions as $rowPosition) {
            if ((($rowPosition >= 0) && ($rowPosition < count($gameGrid)))) {
                $neighbourhoodOfCell = array_merge($neighbourhoodOfCell, $this->getCellNeighboursPerRow($gameGrid,$rowPosition,$colIndex));
            }
        }
        return $neighbourhoodOfCell;
    }
    private function getCellNeighboursPerRow($gameGrid,int $rowIndex, int $colIndex) : array
    {
        $neighbourhoodOfCellFromRow = [];
        $row = $gameGrid[$rowIndex];
        array_push($neighbourhoodOfCellFromRow, $row[$colIndex - 1] ?? '.');
        if ($this->rowIndex !== $rowIndex) {
            array_push($neighbourhoodOfCellFromRow, $row[$colIndex] ?? '.');
        }
        array_push($neighbourhoodOfCellFromRow, $row[$colIndex + 1] ?? '.');
        return $neighbourhoodOfCellFromRow;
    }
}
