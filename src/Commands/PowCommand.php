<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class PowCommand extends Command
{
    use \Jakmall\Recruitment\Calculator\Traits\CalculatorTrait;
    
    /**
     * @var string
     */
    protected $signature = "pow {base : The base number}, {exp : The exponent number}";

    /**
     * @var string
     */
    protected $description = "Exponent the given Numbers";

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
        return '^';
    }

    protected function getInput(): array
    {
        $base = $this->argument('base');
        $exp = $this->argument('exp');
        $exponentArray = [$base, $exp];
        
        return $exponentArray;
    }
}