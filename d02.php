<?php

/**
 * Day 2: Rock Paper Scissors
 */

include_once 'helpers.php';

$totalPoint1 = 0;
$totalPoint2 = 0;

foreach (getDayInputByLine(2) as $round) {
    $chooses = explode(' ', $round);

    $totalPoint1 += compete1(...$chooses);
    $totalPoint2 += compete2(...$chooses);
}

echo "Total point 1: {$totalPoint1}." . PHP_EOL;
echo "Total point 2: {$totalPoint2}." . PHP_EOL;

function compete1(string $them, string $you): int
{
    // A = X = Rock -> 1 point.
    // B = Y = Paper -> 2 points.
    // C = Z = Scissors -> 3 points.
    $you = trim($you);
    $yourPoint = ($you === 'X' ? 1 : ($you === 'Y' ? 2 : 3));

    if (
        ($you === 'X' && $them === 'A')
        || ($you === 'Y' && $them === 'B')
        || ($you === 'Z' && $them === 'C')
    ) {
        // Draw.
        return $yourPoint + 3;
    }

    if (
        // Lose.
        ($you === 'X' && $them === 'B')
        || ($you === 'Y' && $them === 'C')
        || ($you === 'Z' && $them === 'A')
    ) {
        return $yourPoint;
    }

    if (
        // Win.
        ($you === 'X' && $them === 'C')
        || ($you === 'Y' && $them === 'A')
        || ($you === 'Z' && $them === 'B')
    ) {
        return $yourPoint + 6;
    }
}

function compete2(string $them, string $outcome): int
{
    // Same A B C meanings as before. Same points.
    $outcome = trim($outcome);

    // Now based on the planned outcome, we need to decide what shape to choose.
    if ($outcome === 'Y') {
        // Need to draw. Choose the same shape.
        return ($them === 'A' ? 1 : ($them === 'B' ? 2 : 3)) + 3;
    } else if ($outcome === 'X') {
        // Need to lose. Choose the shape to lose.
        return $them === 'A' ? 3 : ($them === 'B' ? 1 : 2);
    } else {
        // Need to win. Chose the shape to win.
        return ($them === 'A' ? 2 : ($them === 'B' ? 3 : 1)) + 6;
    }
}