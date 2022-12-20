<?php

/**
 * Day 4: Camp Cleanup
 */

 include_once 'helpers.php';

 $fullOverlapCount = 0;
 $partialOverlapCount = 0;

foreach (getDayInputByLine(4) as $line) {
    $pairAssignments = explode(',', $line);

    $elf1Sections = explode('-', $pairAssignments[0]);
    $elf2Sections = explode('-', $pairAssignments[1]);

    // When one Elf's section either contains the other Elf' section,
    // or is contained by the other Elf's section, it's a full overlap.
    if (($elf1Sections[0] <= $elf2Sections[0] && $elf1Sections[1] >= $elf2Sections[1])
        || ($elf1Sections[0] >= $elf2Sections[0] && $elf1Sections[1] <= $elf2Sections[1])
    ) {
        $fullOverlapCount++;
        continue;
    }

    // First Elf's sections are "in front" of the second Elf's, or vice versa -> no overlap.
    if ($elf1Sections[1] < $elf2Sections[0]) continue;
    if ($elf1Sections[0] > $elf2Sections[1]) continue;

    $partialOverlapCount++;
}

echo 'Fully overlap assignment counts: ' . $fullOverlapCount . PHP_EOL;
echo 'Total overlap assignment counts: ' . ($fullOverlapCount + $partialOverlapCount) . PHP_EOL;