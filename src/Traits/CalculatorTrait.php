<?php
namespace Jakmall\Recruitment\Calculator\Traits;

trait CalculatorTrait
{
    /**
     * @param array $numbers
     * @param string $operator
     * 
     * @return string
     */

    public function generateCalculationDescription(array $numbers, string $operator): string
    {
        $glue = sprintf(' %s ',$operator);

        return implode($glue, $numbers);
    }

    /**
     * @param array $numbers
     * @param string $operator
     * 
     * @return float|int
     */
    public function calculateAll(array $numbers, string $operator)
    {
        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }

        return $this->calculate($this->calculateAll($numbers, $operator), $number, $operator);
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     * @param string $operator
     *
     * @return int|float
     */
    public function calculate($number1, $number2, $operator)
    {
        switch ($operator) {
            case '-':
                return $number1 - $number2;
                break;

            case '*':
                return $number1 * $number2;
                break;

            case '/':
                return $number1 / $number2;
                break;

            case '^':
                return $number1 ** $number2;
                break;
            
            default:
                return $number1 + $number2;
                break;
        }
    }
}
