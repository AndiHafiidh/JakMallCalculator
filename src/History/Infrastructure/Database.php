<?php
namespace Jakmall\Recruitment\Calculator\History\Infrastructure;

class Database implements CommandHistoryManagerInterface
{
    private $db;

    public function __construct()
    {        
        require "./config/database.php";
        
        $this->db = $entityManager;
    }

    public function find($params = null): array
    {   
        $data = array();
        $historyRepository = $entityManager->getRepository('Jakmall\Recruitment\Calculator\Models\History');
        if($commands){
            $histories = $historyRepository->createQueryBuilder('h')
                            ->where('LOWER(h.command) IN (:commands)')
                            ->setParameter('commands', $commands, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY)
                            ->getQuery()
                            ->getResult();
        }else{
            $histories = $historyRepository->findAll();
        }
        
        foreach ($histories as $history) {
            $data[] = json_decode($history->getJSON());
        }     

        return data;
    }

    public function log($command)
    {
        try {
            $this->db->persist($command);
            $this->db->flush();
            return $command->getId();
        } catch (Exception $e) {
            return false;
        }
    }

    public function clearAll():bool
    {
        $connection = $this->db->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();

        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        $truncateSql = $dbPlatform->getTruncateTableSql('history');
        $connection->executeUpdate($truncateSql);
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');

        return true;
    }    
}


?>