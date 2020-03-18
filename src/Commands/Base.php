<?php
namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Models\History;
use Jakmall\Recruitment\Calculator\History\Infrastructure\Database;
use Jakmall\Recruitment\Calculator\History\Infrastructure\File;


class Base extends Command
{
    const ERR_NOT_NUMBER = "Input must be numeric";
    const ERR_MIN_NUMBERS = "Give at least 2 numbers";

    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description;

    /** 
     * @var string
     */
    private $operator, $commandVerb, $commandPassiveVerb;   

    /** 
     * @var string
     */
    private $db, $file;

    /**
     * @param string $inOperator
     * @param string $inCommandVerb
     * @param string $inCommandPassiveVerb
     * @param string $inSignature
     * @param string $inDescription         
     */
    public function __construct(
        $inOperator, 
        $inCommandVerb, 
        $inCommandPassiveVerb,
        $inSignature = null,
        $inDescription = null               
    ){
        $this->operator = $inOperator;
        $this->commandVerb = $inCommandVerb;
        $this->commandPassiveVerb = $inCommandPassiveVerb;

        if($inSignature){
            $this->signature = $inSignature;
        }else{            
            $this->signature = sprintf(
                '%s {numbers* : The numbers to be %s}',
                $this->getcommandVerb(),
                $this->getCommandPassiveVerb()
            );
        }

        if($inDescription){
            $this->description = $inDescription;
        }else{
            $this->description = sprintf('%s all given Numbers', ucfirst($this->getCommandVerb()));        
        }

        $this->db = new Database();
        $this->file = new File();

        parent::__construct();
    }

    /**     
     * @return string
     */
    protected function getCommandVerb(): string
    {
        return $this->commandVerb;
    }
  
    /**     
     * @return string
     */
    protected function getCommandPassiveVerb(): string
    {
        return $this->commandPassiveVerb;
    }

    /**     
     * @return array
     */
    protected function getInput(): array
    {
        return $this->argument('numbers');
    }

    /**     
     * @return string
     */
    protected function getOperator(): string
    {
        return $this->operator;
    }

    /**     
     * @return void
     */
    public function handle(): void
    {
        $numbers = $this->getInput();

        if (count($numbers) < 2) throw new \Exception(self::ERR_MIN_NUMBERS, 1);
        
        foreach ($numbers as $number) {
            if(!is_numeric($number)) throw new \Exception(self::ERR_NOT_NUMBER, 1);
        }

        $description = $this->generateCalculationDescription($numbers);
        $result = $this->calculateAll($numbers);
        $output = sprintf('%s = %s', $description, $result);        

        $history = new History(ucfirst($this->getCommandVerb()), $description, $result, $output);           
        $id = $this->db->log($history);

        if($id){            
            $this->file->log($history);
        }
        
        $this->comment($output);
    }

    /**
     * @param array $numbers
     *
     * @return string
     */
    protected function generateCalculationDescription(array $numbers): string
    {
        $operator = $this->getOperator();
        $glue = sprintf(' %s ', $operator);

        return implode($glue, $numbers);
    }

    /**
     * @param array $numbers
     *
     * @return float|int
     */
    protected function calculateAll(array $numbers)
    {
        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }

        return $this->calculate($this->calculateAll($numbers), $number);
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return int|float
     */
    protected function calculate($number1, $number2)
    {
        switch ($this->getOperator()) {    
            case '-':
                return $number1 - $number2;
            case '*':
                return $number1 * $number2;
            case '/':
                return $number1 / $number2;
            case '^':
                if($number1 == 0 && $number2 == 0){
                    return 'infinity';
                }elseif($number1 == 0 || $number2 == 0){
                    return '0';
                }else{
                    return pow($number1, $number2);
                }                
            default:
                return $number1 + $number2;
                break;
        }        
    }   
}