<?php

/**
 * Day 7: No Space Left On Device
 */

include_once 'helpers.php';

class Node
{
    public string $name;
    public string $path;
    public int $level;
    public bool $isFile;
    public int $size;

    public function __construct(
        string $name,
        array $path,
        int $level,
        bool $isFile = false,
        int $size = 0
    ) {

        $this->name = $name;
        $this->path = implode('/', $path);
        $this->level = $level;
        $this->isFile = $isFile;
        $this->size = $size;

        // We want the directory to have path containing its name.
        if (!$isFile && $name !== '/') {
            $this->path .= "/{$name}";
        }
    }
}

class Day7
{
    const MAX_DIR_SIZE = 100000;
    const TOTAL_FILESYSTEM_SIZE = 70000000;
    const TOTAL_NEEDED_SPACE = 30000000;

    public int $maxLevel = 0;
    public array $nodes = [];

    public function __construct()
    {
        array_push($this->nodes, new Node('/', [], 0));

        $level = 0;
        $path = [ '' ];  // Current path.

        foreach (getDayInputByLine(7) as $line) {
            $parts = explode(' ', $line);

            if ($parts[0] === '$') {
                // List command. Just need to continue to the next line.
                if ($parts[1] === 'ls') continue;

                // Otherwise, change directory command.
                if ($parts[2] === '..') {
                    // Go up to parent directory.
                    $level--;
                    array_pop($path);
                    continue;
                } else if ($parts[2] === '/') {
                    // Go to root directory.
                    // We do not have to handle this as for the input, there's
                    // only one call like this at the very beginning.
                    $level = 1;
                } else {
                    // Change to a sub-directory. Put it to the path.
                    array_push($path, $parts[2]);
                    $level++;
                    $this->maxLevel = max($this->maxLevel, $level);
                }
            } else {
                // We are reading directory listing.
                if ($parts[0] === 'dir') {
                    array_push($this->nodes, new Node($parts[1], $path, $level));
                } else {
                    array_push(
                        $this->nodes,
                        new Node($parts[1], $path, $level, true, intval($parts[0]))
                    );
                }
            }
        }
    }

    function calculateDirSize($dir)
    {
        foreach ($this->nodes as $node) {
            // Not at child level.
            if ($node->level !== ($dir->level + 1)) continue;

            // Not belong to this dir's path.
            if (strpos($node->path, $dir->path) !== 0) continue;

            // Because we go backward from leaf directories first, at this point,
            // we should already have the size of the sub directory.
            $dir->size += $node->size;
        }
    }

    function execute()
    {
        $totalSmallDirsSize = 0;

        // Calculate the directory size level by level, starting with "leaf"
        // dirs first, then go up the tree.
        for ($i = $this->maxLevel; $i >= 0; $i--) {
            $levelDirs = array_filter($this->nodes, fn ($d) => !$d->isFile && $d->level === $i);

            foreach ($levelDirs as $dir) {
                $this->calculateDirSize($dir);

                if ($dir->size <= self::MAX_DIR_SIZE) {
                    $totalSmallDirsSize += $dir->size;
                }
            }
        }

        echo 'Part 1: ' . $totalSmallDirsSize . PHP_EOL;

        // Part 2. Need to calculate which directory, smallest possible, to
        // delete to get enough space.
        $needToDeleteSpace = self::TOTAL_NEEDED_SPACE - (self::TOTAL_FILESYSTEM_SIZE - $this->nodes[0]-> size);

        $toDeleteDirSize = self::TOTAL_NEEDED_SPACE;
        foreach ($this->nodes as $node) {
            if ($node->size > $needToDeleteSpace) {
                $toDeleteDirSize = min($node->size, $toDeleteDirSize);
            }
        }

        echo 'Part 2: ' . $toDeleteDirSize . PHP_EOL;
    }
}

$day7 = new Day7();
$day7->execute();