<?php
namespace Jakmall\Recruitment\Calculator\History\Infrastructure;


class File implements CommandHistoryManagerInterface
{    
    private $path;

    public function __construct()
    {        
        require "./config/file.php";            

        $this->path = $filePath . "/history.json";

        if (!file_exists($this->path)) {
            file_put_contents($this->path, "[]");
        }
    }

    public function find($params = null): array
    {
        $data = json_decode(file_get_contents($this->path));    
        if($params){
            $data = array_filter($data, function($dt) use ($params){
                return in_array($dt->command, $params);
            });
        }
        
        return $data;        
    }

    public function log($command)
    {
        $savedData = json_decode(file_get_contents($this->path));
        $savedData[] = json_decode($command->getJSON());
        file_put_contents($this->path, json_encode($savedData));     

        return $command->getId();        
    }

    public function clearAll():bool
    {
        $data = json_decode(file_get_contents($this->path));
        $data = array();

        file_put_contents($this->path, json_encode($data));

        return true;
    }
}


?>