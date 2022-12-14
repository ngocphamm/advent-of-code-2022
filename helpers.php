<?php

$startTime = microtime(true);

function getExecutionTime(bool $reset = false) {
    global $startTime;

    $now = microtime(true);

    $elapsed = $now - $startTime;

    if ($reset) $startTime = $now;

    return $elapsed;
}

function getDayInputByLine(int $day, $sample = false)
{
    $dayWithZero = str_pad($day, 2, '0', STR_PAD_LEFT);
    $daySample = $sample === true ? '_sample' : '';

    $file = fopen("input/{$dayWithZero}{$daySample}.txt", 'r');

    try {
        while ($line = fgets($file)) {
            yield $line;
        }
    } finally {
        fclose($file);
    }
}

function getDayInput(int $day, $sample = false)
{
    $dayWithZero = str_pad($day, 2, '0', STR_PAD_LEFT);
    $daySample = $sample === true ? '_sample' : '';

    return trim(file_get_contents("input/{$dayWithZero}{$daySample}.txt"));
}