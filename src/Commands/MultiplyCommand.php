<?php

namespace Jakmall\Recruitment\Calculator\Commands;

class MultiplyCommand extends Base
{    
    public function __construct()
    {        
        parent::__construct('*', 'multiply', 'multiplied');
    }    
}
