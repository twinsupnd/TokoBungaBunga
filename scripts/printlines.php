<?php
$path = $argv[1] ?? null;
if (!$path || !file_exists($path)) { echo "Usage: php printlines.php <file>\n"; exit(1); }
$lines = file($path);
foreach ($lines as $i => $line) {
    printf("%4d: %s", $i+1, rtrim($line, "\n"));
    echo PHP_EOL;
}
