<?php
namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use LucidFrame\Console\ConsoleTable;
use Carbon\Carbon;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;
use Jakmall\Recruitment\Calculator\History\Infrastructure\Database;
use Jakmall\Recruitment\Calculator\History\Infrastructure\File;


class HistoryList extends Command
{    
    const ERR_DRIVER = "Choose beetwen 'database' or 'file'";
    const DRIVER_LIST = ['database', 'file'];
    
    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var CommandHistoryManagerInterface
     */
    private $connection;

    public function __construct()
    {        

        $this->signature = sprintf(
            '%s {commands?* : Filter the history by commands}
                {--D|driver=database : Driver for strage connection}',
            'history:list'
        );

        $this->description = 'Show calculator history';        
        parent::__construct($signature, $description);
    }    

    protected function getInput(): array
    {
        return $this->argument("commands");
    }

    protected function getDriver(): string
    {
        return $this->option("driver");
    }

    public function handle(): void
    {
        $commands = $this->getInput();
        $driver = $this->getDriver();

        if (!in_array($driver, self::DRIVER_LIST)) throw new \Exception(self::ERR_DRIVER, 1);
        
        $data = array();
        switch ($driver) {
            case 'file':                                
                $this->connection = new Database();
            default:
                $this->connection = new File();
                break;
        }

        $data = $this->connection->find($commands);

        if(count($data) > 0){
            $this->getTable($data);       
        }else{
            $this->comment("\e[0;32mHistory is empty.\e[0m");
        }
    }

    public function getTable($data)
    {        
        $table = new ConsoleTable();
        $table->setHeaders(array("\e[0;32mNo\e[0m", "\e[0;32mCommand\e[0m", "\e[0;32mDescription\e[0m", "\e[0;32mResult\e[0m", "\e[0;32mOutput\e[0m", "\e[0;32mTime\e[0m"));

        foreach ($data as $dt) {
            $time = new Carbon($dt->createdAt->date);
            $table ->addRow()
            ->addColumn($dt->id)
            ->addColumn($dt->command)
            ->addColumn($dt->description)
            ->addColumn($dt->result)
            ->addColumn($dt->output)
            ->addColumn($time->format('Y-m-d H:i:s'));
        }
        $table->display();
    }
}
