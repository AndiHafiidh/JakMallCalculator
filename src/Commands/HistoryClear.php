<?php
namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\History\Infrastructure\Database;
use Jakmall\Recruitment\Calculator\History\Infrastructure\File;

class HistoryClear extends Command
{    
    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description;

    private $db, $file;

    public function __construct()
    {        

        $this->signature = 'history:clear';
        $this->description = 'Clear saved history';
        $this->db = new Database();
        $this->file = new File();
        parent::__construct();
    }   
    
    public function handle(): void
    {
        $this->db->clearAll();
        $this->file->clearAll();
        $this->comment("\e[0;32mHistory cleared!\e[0m");
    }
}
