<?php

/**
 * Day 3: Rucksack Reorganization
 */

include_once 'helpers.php';

$priorities = [];

// From the priority map between letters and integer values.
foreach (range('a', 'z') as $index => $item) {
    $priorities[$item] = $index + 1;
    $priorities[strtoupper($item)] = $index + 27;
}

$sumPriorityPart1 = 0;

$sumPriorityPart2 = 0;
$groupMem1Items = '';
$groupMem2Items = '';
$groupMem = 0;

foreach (getDayInputByLine(3) as $rucksackItems) {
    // For part 1.
    $compartmentItemCount = strlen($rucksackItems) / 2;
    $itemsInCompartment2 = substr($rucksackItems, -1 * $compartmentItemCount);

    for ($i = 0; $i < $compartmentItemCount; $i++) {
        if (strpos($itemsInCompartment2, $rucksackItems[$i]) === false) continue;

        $sumPriorityPart1 += $priorities[$rucksackItems[$i]];
        break;
    }

    // For part 2.
    $groupMem++;

    if ($groupMem === 1) {
        $groupMem1Items = $rucksackItems;
    } else if ($groupMem === 2) {
        $groupMem2Items = $rucksackItems;
    }

    if ($groupMem === 3) {
        // Get only the unique items in the rucksack.
        $items = count_chars($rucksackItems, 3);

        // Check each items againsts the rucksacks from the previous 2 members.
        for ($j = 0; $j < strlen($items); $j++) {
            if ((strpos($groupMem1Items, $items[$j]) === false)
                || (strpos($groupMem2Items, $items[$j]) === false)
            )  {
                continue;
            }

            $sumPriorityPart2 += $priorities[$items[$j]];
            break;
        }

        // Reset so we start from the next group of 3 members.
        $groupMem = 0;
    }
}

echo 'Sum priorities 1: ' . $sumPriorityPart1 . PHP_EOL;
echo 'Sum priorities 2: ' . $sumPriorityPart2 . PHP_EOL;