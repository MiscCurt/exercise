<?php

switch($argc) {
    case 1:
        /* No parameter provided with file. */
        echo "Please enter a single integer as the parameter." . PHP_EOL;
        break;
    case 2:
        /* Parameter provided greater than one which will allow prime calculation. */
        if ((int)$argv[1] > 1) {
            $test = new Exercise;
            /* Generate list of prime numbers to be evaluated. */
            $primes = $test->generatePrimes(
                (int)$argv[1],
                $test->generateNumberList((int)$argv[1])
            );
            $flag = true;
            $test->random = rand(0,2);
            /* Loop through combinations of prime numbers to be evaluated by secret function. */
            foreach ($primes as $x) {
                foreach ($primes as $y) {
                    $testA = $test->secret($x+$y);
                    $testB = $test->secret($x) + $test->secret($y);
                    if ($testA != $testB) {
                        $flag = false;
                    }
                }
            }
            /* Advise whether or not function is additive. */
            if ($flag) {
                echo "The secret function is additive." . PHP_EOL;
            } else {
                echo "The secret function is not additive." . PHP_EOL;
            }
        } else {
            /* Parameter provided that evaluates to one or less, doesn't allow for prime calculation. */
            echo "The parameter must be an integer of at least 2." . PHP_EOL;
        }
        break;
    default:
        /* Too many parameters provided */
        echo "There are too many parameters, please enter a single integer as the parameter." . PHP_EOL;
        break;
}

class Exercise
{
    /*
     * Variable that hold the assigned random number.
     */
    public $random;

    /**
     * Calls the function randomizer.
     *
     * @param int $int The integer being passed to the secret function.
     *
     * @return int The results of the evaluation of the secret function.
     */
    public function secret($int)
    {
        return $this->randomizeFunction($int);
    }

    /**
     * Generates the initial list of numbers from 2 to the integer provided.
     *
     * @param int $int The integer provided by the user, is the max of the list.
     *
     * @return array The full array of numbers between two and the provided integer.
     */
    public function generateNumberList($int)
    {
        $numberList = [];
        foreach (range(2, $int) as $i) {
            $numberList[] = $i;
        }
        return $numberList;
    }

    /**
     * Converts the list of all numbers into a list of prime numbers.
     *
     * @param int   $max     The integer provided by the user, is the max of the list.
     * @param array $numbers The full array of numbers.
     *
     * @return array The array of numbers culled to only primes.
     */
    public function generatePrimes($max, $numbers)
    {
        $i = 2;

        while ($i <= $max) {
            foreach ($numbers as $key => $number) {
                if ($number > $i && $number%$i == 0) {
                    unset($numbers[$key]);
                }
            }
            $i++;
        }
        return $numbers;
    }

    /**
     * Provides a random function that the array of primes will be tested against.
     *
     * @param int $int The integer provided by secret that is being tested.
     *
     * @return int The evaluation of the integer based on the selected function.
     */
    public function randomizeFunction($int)
    {
        $functions[] = (pow($int, 2) + 1);
        $functions[] = (1 - $int + pow($int, 2));
        $functions[] = (3 * $int);

        return $functions[$this->random];
    }
}
?>
