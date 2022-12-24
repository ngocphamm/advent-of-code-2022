<?php

/**
 * Day 9: Rope Bridge
 */

include_once 'helpers.php';

class Day9
{
    public array $ropeKnots = [];
    public array $knotsVisited = [];

    public function __construct()
    {
        for ($i = 0; $i < 10; $i++) {
            array_push($this->ropeKnots, [0, 0]);
            array_push($this->knotsVisited, [ '0-0' ]);
        }
    }

    function execute()
    {
        foreach (getDayInputByLine(9) as $move) {
            list($direction, $steps) = explode(' ', $move);

            $this->moveKnots($direction, intval($steps));
        }

        echo 'Part 1: Tail visited ' . count(array_unique($this->knotsVisited[1])) . PHP_EOL;
        echo 'Part 2: Tail visited ' . count(array_unique($this->knotsVisited[9])) . PHP_EOL;
    }

    function moveKnots(string $direction, int $steps)
    {
        for ($i = 0; $i < $steps; $i++) {
            // Move the first knot. Head.
            switch ($direction) {
                case 'U':
                    // Move up a row.
                    $this->ropeKnots[0][0]++;
                    break;
                case 'D':
                    // Move down a row.
                    $this->ropeKnots[0][0]--;
                    break;
                case 'R':
                    // Move right a column.
                    $this->ropeKnots[0][1]++;
                    break;
                case 'L':
                    // Move left a column.
                    $this->ropeKnots[0][1]--;
                    break;
            }

            // Move the next knot. One by one. This is like a game of snake.
            for ($j = 1; $j < count($this->ropeKnots); $j++) {
                if (abs($this->ropeKnots[$j-1][0] - $this->ropeKnots[$j][0]) <= 1
                    && abs($this->ropeKnots[$j-1][1] - $this->ropeKnots[$j][1]) <= 1
                ) {
                    // 2 knots are "touching". Nothing to do.
                    continue;
                }

                if ($this->ropeKnots[$j-1][0] > $this->ropeKnots[$j][0]) {
                    $this->ropeKnots[$j][0]++;
                } else if ($this->ropeKnots[$j-1][0] < $this->ropeKnots[$j][0]) {
                    $this->ropeKnots[$j][0]--;
                }

                if ($this->ropeKnots[$j-1][1] > $this->ropeKnots[$j][1]) {
                    $this->ropeKnots[$j][1]++;
                } else if ($this->ropeKnots[$j-1][1] < $this->ropeKnots[$j][1]) {
                    $this->ropeKnots[$j][1]--;
                }

                // We only care about the second and the last knot's histories.
                if ($j === 1 || $j === (count($this->ropeKnots) - 1)) {
                    array_push(
                        $this->knotsVisited[$j],
                        $this->ropeKnots[$j][0] . '-' . $this->ropeKnots[$j][1]
                    );
                }
            }
        }
    }
}

// I am sure there are much better solutions as this is running a little slow.
$day9 = new Day9();
$day9->execute();