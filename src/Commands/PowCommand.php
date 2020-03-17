<?php

namespace Jakmall\Recruitment\Calculator\Commands;

class PowCommand extends Base
{    
    public function __construct()
    {        
        $signature = sprintf(
            '%s {base : The base number} {exp : The exponent number}',
            'pow'
        );

        $description = sprintf('%s the given number', 'Exponent');
        parent::__construct('^', 'pow', 'exponent', $signature, $description);        
    }    

    protected function getInput(): array
    {
        $numbers = array($this->argument("base"), $this->argument("exp"));
        return $numbers;
    }
}
