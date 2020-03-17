<?php
namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

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

    public function __construct()
    {        

        $this->signature = 'history:clear';
        $this->description = 'Clear saved history';
        parent::__construct();
    }   
    
    public function handle(): void
    {
        require_once "./config/database.php";
        require_once "./config/file.php";

        file_put_contents($filePath, "[]");

        $connection = $entityManager->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();

        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        $truncateSql = $dbPlatform->getTruncateTableSql('history');
        $connection->executeUpdate($truncateSql);
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');

        $this->comment("\e[0;32mHistory cleared!\e[0m");
    }
}
