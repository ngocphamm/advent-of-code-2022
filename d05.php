<?php

/**
 * Day 5: Supply Stacks
 */

include_once 'helpers.php';

$sample = false;

/**
 * This PHP file contains an array of arrays to represent the stacks of crates.
 * Looks like this:
 * $stacks = [
 *     '1' => [ 'Z', 'N' ],
 *     '2' => [ 'M', 'C', 'D' ],
 *     '3' => [ 'P' ]
 * ];
 */
include_once 'input/05' . ($sample ? '_sample' : '') . '.php';

// For part 1. Poor man's array cloning.
// Because array_push and array_splice used below will modify the arrays.
$stacks1 = (array)json_decode(json_encode($stacks));

foreach (getDayInputByLine(5, $sample) as $instruction) {
    /**
     * Parse the instruction line using RegEx.
     * So first match (index 0) is the matched string itself.
     * Second match is "how many crates to move".
     * Third match is "move from" stack.
     * Last match is "move to" stack.
     */
    preg_match('/move (\d+) from (\d+) to (\d+)/', $instruction, $matches);

    // For part 1.
    array_push(
        $stacks1[$matches[3]], // Move to this stack.
        // Reverse because the crates can be moved one by one only.
        ...array_reverse(
            // Take "how many crates" from the "move from" stack.
            array_splice($stacks1[$matches[2]], -1 * intval($matches[1]))
        )
    );

    // For part 2. Don't need reverse because crates can be moved all at once.
    array_push(
        $stacks[$matches[3]],
        ...array_splice($stacks[$matches[2]], -1 * intval($matches[1]))
    );
}

// Part 1.
echo 'Part 1 Message: ';

foreach ($stacks1 as $stack) {
    // Get the last crate in the stack.
    echo $stack[count($stack) - 1];
}

echo PHP_EOL;

// Part 2.
echo 'Part 2 Message: ';

foreach ($stacks as $stack) {
    // Get the last crate in the stack.
    echo $stack[count($stack) - 1];
}

echo PHP_EOL;