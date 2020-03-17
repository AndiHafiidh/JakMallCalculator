<?php

namespace Jakmall\Recruitment\Calculator\Commands;

class SubtractCommand extends Base
{    
    public function __construct()
    {        
        parent::__construct('-', 'subtract', 'subtracted');
    }    
}
