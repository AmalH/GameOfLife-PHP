<?php

namespace GameOfLife\Exception;

class InputNotFoundException extends \Exception
{

    public function errorMessage() {
        return 'Error on line '.$this->getLine().' in '.basename($this->getFile())
            .': Input file is empty !';
    }

}
