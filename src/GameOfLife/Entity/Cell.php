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

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }



    /**
     * @return array
     */
    public function getCurrentGameGrid(): array
    {
        return $this->currentGameGrid;
    }

    /**
     * @param array $currentGameGrid
     */
    public function setCurrentGameGrid(array $currentGameGrid): void
    {
        $this->currentGameGrid = $currentGameGrid;
    }

    /**
     * @return int
     */
    public function getRowIndex(): int
    {
        return $this->rowIndex;
    }

    /**
     * @param int $rowIndex
     */
    public function setRowIndex(int $rowIndex): void
    {
        $this->rowIndex = $rowIndex;
    }

    /**
     * @return int
     */
    public function getColIndex(): int
    {
        return $this->colIndex;
    }

    /**
     * @param int $colIndex
     */
    public function setColIndex(int $colIndex): void
    {
        $this->colIndex = $colIndex;
    }


}
