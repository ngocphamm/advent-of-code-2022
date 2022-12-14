<?php

include_once 'helpers.php';

$elfCal1 = 0;
$elfCal2 = 0;
$elfCal3 = 0;
$currentElfCal = 0;

foreach (getDayInputByLine(1) as $cal) {
    if ($cal === PHP_EOL) {
        if ($currentElfCal >= $elfCal1) {
            $elfCal3 = $elfCal2;
            $elfCal2 = $elfCal1;
            $elfCal1 = $currentElfCal;
        } else if ($currentElfCal >= $elfCal2) {
            $elfCal3 = $elfCal2;
            $elfCal2 = $currentElfCal;
        }  else if ($currentElfCal >= $elfCal3) {
            $elfCal3 = $currentElfCal;
        }

        // Reset to count calories for the next Elf.
        $currentElfCal = 0;
    }

    $currentElfCal += intval($cal);
}

// To take care of the last elf.
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

echo 'Elf carrying the most calories of: ' . $elfCal1 . PHP_EOL;
echo '3 Elves carrying the most calories of: ' . ($elfCal1 + $elfCal2 + $elfCal3) . PHP_EOL;