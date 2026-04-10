<?php
$files = [
    'media__1775671584041.png' => 'albarid.png',
    'media__1775671584457.png' => 'wafacash.png',
    'media__1775671584561.png' => 'cih_official.png',
    'media__1775671584617.png' => 'bmce_official.png',
    'media__1775671584663.png' => 'attijari_official.png',
];

$sourceDir = 'C:/Users/ayoub/.gemini/antigravity/brain/5ddcdb95-4d16-4954-af14-36a395af9980/';
$destDir = __DIR__ . '/public/banks/';

if (!is_dir($destDir)) {
    mkdir($destDir, 0755, true);
}

foreach ($files as $source => $dest) {
    $fullSource = $sourceDir . $source;
    $fullDest = $destDir . $dest;
    if (file_exists($fullSource)) {
        if (copy($fullSource, $fullDest)) {
            echo "Copied: $source to $dest\n";
        } else {
            echo "Failed to copy: $source\n";
        }
    } else {
        echo "Source not found: $fullSource\n";
    }
}
