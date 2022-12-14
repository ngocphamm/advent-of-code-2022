<?php

include_once 'helpers.php';

$elfCal1 = 0;
$elfCal2 = 0;
$elfCal3 = 0;
$currentElfCal = 0;

// This is input data, as PHP generators.
$input = getDayInputByLine(1);

while ($input->valid()) {
    $cal = $input->current();

    $currentElfCal += intval($cal);

    // Go to the next line.
    $input->next();

    if ($cal !== PHP_EOL && $input->valid()) continue;

    // If current line is a blank line, or it's the end of the input,
    // we will need to reset the count for the current Elf.
    if ($currentElfCal >= $elfCal1) {
        $elfCal3 = $elfCal2;
        $elfCal2 = $elfCal1;
        $elfCal1 = $currentElfCal;
    } else if ($currentElfCal >= $elfCal2) {
        $elfCal3 = $elfCal2;
        $elfCal2 = $currentElfCal;
    } else if ($currentElfCal >= $elfCal3) {
        $elfCal3 = $currentElfCal;
    }

    // Reset to count calories for the next Elf.
    $currentElfCal = 0;
}

echo 'Elf carrying the most calories of: ' . $elfCal1 . PHP_EOL;
echo '3 Elves carrying the most calories of: ' . ($elfCal1 + $elfCal2 + $elfCal3) . PHP_EOL;