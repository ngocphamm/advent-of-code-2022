<?php

/**
 * Day 6: Tuning Trouble
 */

include_once 'helpers.php';

$buffer = getDayInput(6);

function getMarkerStart(string $buffer, int $size): int
{
    // We will get a set of characters of size $size,
    // and move that window one character at a time.
    for ($i = 0; $i < (strlen($buffer) - $size); $i++) {
        // Then we want to check if the set contains all unique characters.
        $uniqueSet = count_chars(substr($buffer, $i, $size), 3);

        // If it's all unique then the length should be the same as $size.
        if (strlen($uniqueSet) === $size) {
            return $i + $size;
        }
    }
}

echo 'Characters processed before first start-of-package: ' . getMarkerStart($buffer, 4) . PHP_EOL;
echo 'Characters processed before first start-of-message: ' . getMarkerStart($buffer, 14) . PHP_EOL;