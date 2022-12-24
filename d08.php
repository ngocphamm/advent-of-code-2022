<?php

/**
 * Day 8: Treetop Tree House
 */

include_once 'helpers.php';

$forest = [];
$row = 0;
foreach (getDayInputByLine(8) as $line) {
    $forest[$row] = [];

    array_push($forest[$row], ...str_split($line));

    $row++;
}

// count($forest) -> for vertical size (rows)
// count($forest[0]) -> for horizontal size (columns)

// All the trees at the edges are visible, so start with that number.
$visibleTreeCount = ((count($forest[0]) - 1) + (count($forest)  - 1)) * 2;
$maxScenicScore = 0;

for ($i = 1; $i < (count($forest) - 1); $i++) {
    for ($j = 1; $j < (count($forest[0]) - 1); $j++) {
        if (isTreeVisible($i, $j)) $visibleTreeCount++;

        $maxScenicScore = max($maxScenicScore, calculateTreeScenicScore($i, $j));
    }
}

echo "Part 1: {$visibleTreeCount}." . PHP_EOL;
echo "Part 2: {$maxScenicScore}." . PHP_EOL;

function isTreeVisible(int $row, int $col): bool
{
    global $forest;

    $visibleLeft = true;
    $visibleRight = true;
    $visibleTop = true;
    $visibleBottom = true;

    // Check all the trees to the left
    for ($left = 0; $left < $col; $left++) {
        if ($forest[$row][$left] >= $forest[$row][$col]) {
            $visibleLeft = false;
            break;
        }
    }

    if ($visibleLeft) return true;

    // Check all the trees to the right
    for ($right = ($col + 1); $right < count($forest[0]); $right++) {
        if ($forest[$row][$right] >= $forest[$row][$col]) {
            $visibleRight = false;
            break;
        }
    }

    if ($visibleRight) return true;

    // Check all the trees to the top
    for ($top = 0; $top < $row; $top++) {
        if ($forest[$top][$col] >= $forest[$row][$col]) {
            $visibleTop = false;
            break;
        }
    }

    if ($visibleTop) return true;

    // Check all the trees to the bottom
    for ($bottom = ($row + 1); $bottom < count($forest); $bottom++) {
        if ($forest[$bottom][$col] >= $forest[$row][$col]) {
            $visibleBottom = false;
            break;
        }
    }

    return $visibleBottom;
}

function calculateTreeScenicScore(int $row, int $col): int
{
    global $forest;

    $leftDistance = 0;
    $rightDistance = 0;
    $topDistance = 0;
    $bottomDistance = 0;

    // For this, we are checking from the middle out.

    // Check the trees to the left
    for ($left = ($col - 1); $left >= 0; $left--) {
        $leftDistance++;

        if ($forest[$row][$left] < $forest[$row][$col]) {
            continue;
        }

        break;
    }

    // Check the trees to the right
    for ($right = ($col + 1); $right < count($forest[0]); $right++) {
        $rightDistance++;

        if ($forest[$row][$right] < $forest[$row][$col]) {
            continue;
        }

        break;
    }

    // Check the trees to the top
    for ($top = ($row - 1); $top >= 0; $top--) {
        $topDistance++;

        if ($forest[$top][$col] < $forest[$row][$col]) {
            continue;
        }

        break;
    }

    // Check the trees to the bottom
    for ($bottom = ($row + 1); $bottom < count($forest); $bottom++) {
        $bottomDistance++;

        if ($forest[$bottom][$col] < $forest[$row][$col]) {
            continue;
        }

        break;
    }

    return $leftDistance * $rightDistance * $topDistance * $bottomDistance;
}