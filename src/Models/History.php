<?php
namespace Jakmall\Recruitment\Calculator\Models;

use Doctrine\ORM\Mapping as ORM;
use Carbon\Carbon;
/**
 * @ORM\Entity
 * @ORM\Table(name="history")
 */
class History
{
     /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(type="string") 
     */
    protected $command;
    /** 
     * @ORM\Column(type="string") 
     */
    protected $description;
    /** 
     * @ORM\Column(type="string") 
     */
    protected $result;
    /** 
     * @ORM\Column(type="string") 
     */
    protected $output;
    /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     */
    protected $createdAt;
    
    public function __construct($inCommand, $inDescription, $inResult, $inOutput, $inCreatedAt = null)
    {
        $this->command = $inCommand;
        $this->description = $inDescription;
        $this->result = $inResult;
        $this->output = $inOutput;
        if($inCreatedAt){
            $this->createdAt = $inCreatedAt;
        }else{            
            $this->createdAt = Carbon::now();
        }        
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function setCommand($command)
    {
        $this->command = $command;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result)
    {
        $this->result = $result;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setOutput($output)
    {
        $this->output = $output;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    public function getJSON()
    {
        $res = (object)[
            "id" => $this->id,
            "command" => $this->command,
            "description" => $this->description,
            "result" => $this->result,
            "output" => $this->output,
            "createdAt" => $this->createdAt
        ];
              
        return json_encode($res, true);
    }
}