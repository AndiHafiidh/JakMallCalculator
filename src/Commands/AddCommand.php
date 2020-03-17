<?php

namespace Jakmall\Recruitment\Calculator\Commands;

class AddCommand extends Base
{    
    public function __construct()
    {        
        parent::__construct('+', 'add', 'added');
    }    
}
