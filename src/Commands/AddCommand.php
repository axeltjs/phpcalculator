<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Interfaces\CommandHistory;
use Symfony\Component\Console\Helper\Table;

class AddCommand extends Command
{
    use \Jakmall\Recruitment\Calculator\Traits\CalculatorTrait;

    /**
     * @var string
     */
    protected $signature = "add {numbers* : The numbers to be add}";

    /**
     * @var string
     */
    protected $description = "Add all given Numbers";

    /**
     * @var object
     */
    protected $commandHistory;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $numbers = $this->getInput();
        $operator = $this->getOperator();
        $description = $this->generateCalculationDescription($numbers, $operator);
        $result = $this->calculateAll($numbers, $operator);

        $this->comment(sprintf('%s = %s', $description, $result));

        $this->commandHistory = new CommandHistory();
        
        if (!empty($this->commandHistory)) {
            $this->commandHistory->saveHistory($this->getName(), $description, $result, sprintf('%s = %s', $description, $result));
        }
       
    }

    protected function getOperator(): String 
    {
        return '+';
    }

    protected function getInput(): array
    {
        return $this->argument('numbers');
    }
}
