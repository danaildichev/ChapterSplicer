<?php


// =======================================================
// make edits

// the file that will be read from
$fileName = "textFile.txt";

// the chapter names to be searched for
$chptNames = ["Chapter 1", "Chapter 2", "Chapter 3", "Chapter 4", "Chapter 5"];

// you may also want to edit the target text file on line 29.

// end edits
// =======================================================



// the chapter splicer
include_once("ChapterSplicer.php");

// fn: write to console
function pen($words) { echo $words . "\n"; }


// the target text file
$dirName = dirname(__FILE__);
$txtFile = $dirName . "\\" . $fileName;


// --------------------------------------------------------------------
// intro

pen("Welcome to the chapter splicer.");
pen("Working with file \"" . $fileName . "\" ");
pen("and looking for " . count($chptNames) . " chapters" );
pen("");



// init the chapter splicer
$splicer = new ChapterSplicer($txtFile, $chptNames);
// if (!$splicer) echo "splicer not created\n"; else echo "yes on splicer\n";

// search the file text for the chapter names
$splicer->hasChapters();

$splicer->seeChapterResults();

$splicer->makeChapterSubstrings();


// make chapter files from substrings collected
$targetFolder = $dirName . "\\" . "target";
$targetFileNames = [];
for ($i = 0; $i < count($chptNames); $i++)
{
    // the name of the file that will be created
    $targetFileNames[$i] = $targetFolder . "\\" . "chapter" . ($i + 1) . ".txt";
}


// make chapter files
$splicer->makeChapterFiles($targetFileNames);







?>