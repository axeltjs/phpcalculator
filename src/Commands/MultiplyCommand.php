<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class MultiplyCommand extends Command
{
    use \Jakmall\Recruitment\Calculator\Traits\CalculatorTrait;

    /**
     * @var string
     */
    protected $signature = "multiply {numbers* : The numbers to be multiply}";

    /**
     * @var string
     */
    protected $description = "Multiply all given Numbers";

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
    }

    protected function getOperator(): String 
    {
        return '*';
    }

    protected function getInput(): array
    {
        return $this->argument('numbers');
    }
}
