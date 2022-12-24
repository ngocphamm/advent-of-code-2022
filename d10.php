<?php

/**
 * Day 9: Cathode-Ray Tube
 */

include_once 'helpers.php';

class Day10
{
    public int $x = 1;
    public int $cycle = 0;
    public int $sumSignalStrengths = 0;
    public int $nextCheckCycle = 20;
    public array $pixels = [];

    public function execute()
    {
        foreach (getDayInputByLine(10) as $instruction) {
            $this->nextCycle();

            $parts = explode(' ', $instruction);

            $this->checkPeriodicCycle();

            if ($parts[0] === 'addx') {
                $this->nextCycle();
                $this->checkPeriodicCycle();

                $this->x += intval($parts[1]);
            }
        }

        echo "Part 1 Signal Strengths Sum: {$this->sumSignalStrengths}" . PHP_EOL;

        echo 'Part 2 CRT:' . PHP_EOL;

        for ($i = 0; $i < 240; $i++) {
            if ($i % 40 === 0) echo PHP_EOL;
            echo $this->pixels[$i];
        }

        echo PHP_EOL;
    }

    public function checkPeriodicCycle()
    {
        if ($this->cycle === $this->nextCheckCycle) {
            $this->nextCheckCycle += 40;
            $this->sumSignalStrengths += $this->x * $this->cycle;
        }
    }

    public function nextCycle()
    {
        $this->cycle++;
        $pixelPos = $this->cycle % 40 - 1;

        if (
            $pixelPos === ($this->x - 1)
            || $pixelPos === $this->x
            || $pixelPos === ($this->x + 1)
        ) {
            array_push($this->pixels, '#');
        } else {
            array_push($this->pixels, '.');
        }
    }
}

(new Day10())->execute();