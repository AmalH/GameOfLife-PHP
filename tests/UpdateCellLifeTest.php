<?php

namespace GameOfLife;

use GameOfLife\Entity\Cell;
use PHPUnit\Framework\TestCase;

class UpdateCellLifeTest extends TestCase
{
     public function updateCellLifeDataProvider()
     {
         return [
             'make live cell - 3 cells life' => [
                 [['x', 'x', 'x'],['.', '.', '.'],['.', '.', '.']], 1, 1, 'x', '.'
             ],
             'make stil life cell: 2' => [
                 [['x', 'x', '.'],['.', 'x', '.'],['.', '.', '.']], 1, 1, 'x', 'x'
             ],
             'make stil life cell: 3' => [
                 [['x', 'x', 'x'],['.', 'x', '.'],['.', '.', '.']], 1, 1, 'x', 'x'
             ],
             'make dead cell when only 1 live' => [
                 [['.', '.', 'x'],['.', 'x', '.'],['.', '.', '.']], 1, 1, '.', 'x'
             ],
             'make dead cell when only to many live' => [
                 [['x', 'x', 'x'],['x', 'x', '.'],['.', '.', '.']], 1, 1, '.', 'x'
             ]
         ];
     }

    /**
     * @dataProvider updateCellLifeDataProvider
     * @param $gameGrid
     * @param $cellRowIndex
     * @param $cellColIndex
     * @param $expectedStatus
     * @param $initialStatus
     */
     public function testReturnCellStatusFromDataToMakeDecision($gameGrid, $cellRowIndex, $cellColIndex, $expectedStatus, $initialStatus)
     {
         $cell = new Cell($gameGrid, $cellRowIndex, $cellColIndex);
         $this->assertEquals($initialStatus, $cell->getState());
         $this->assertCount(8, $cell->getCellNeighbours($gameGrid, $cellRowIndex, $cellColIndex));
         $this->assertEquals($expectedStatus, $cell->updateLife());
     }
}