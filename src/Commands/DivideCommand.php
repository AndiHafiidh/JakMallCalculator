<?php

namespace Jakmall\Recruitment\Calculator\Commands;

class DivideCommand extends Base
{    
    public function __construct()
    {        
        parent::__construct('/', 'divide', 'divided');
    }    
}
