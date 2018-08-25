<?php


class ChapterSplicer
{
    // ----------------------------------------------------------------
    // vars

    // string
    // holds the string read from the file name passed in at init
    public $fileText;

    // array
    // holds the chapter names to be searched for
    public $chapterNames;

    // array
    // holds the positions of the chapter names found
    public $positionsFound;

    // array
    // holds the substrings of the chapters
    public $chapterTexts;


    // ----------------------------------------------------------------
    // fn: constructor
    // takes a file location and list of chapter names
    public function __construct($fileName, $chptNames)
    {
        $this->fileText = $this->getTextFile($fileName);
        $this->chapterNames = $chptNames;
        $this->positionsFound = [];
        $this->chapterTexts = [];
    }


    // fn: get the text file
    // returns a string of the file text
    public function getTextFile($fileName)
    {
        return file_get_contents($fileName);
    }


    // fn: look for occurence of a keyword
    // returns an int
    public function hasChapterName($text, $chapterName)
    {
        return strpos($text, $chapterName);
    }


    // fn: look for occurence of each chapter name
    // sets this $positionsFound array
    public function hasChapters()
    {
        $chapterStrPositions = [];
        foreach ($this->chapterNames as $chptName)
        {
            $loc = $this->hasChapterName($this->fileText, $chptName);
            array_push($chapterStrPositions, $loc);
            $loc = 0;
        }
        $this->positionsFound = $chapterStrPositions;
    }


    // fn: get positions found
    public function getPositionsFound()
    {
        return $this->positionsFound;
    }

    // fn: get length of text file
    public function getLengthTextFile()
    {
        return strlen($this->fileText);
    }


    // fn: make a substring
    // returns a string
    public function makeSubString($start, $stop)
    {
        return substr($this->fileText, $start, $stop);
    }


    // report on start and stop positions of the chapters locations
    public function seeChapterResults()
    {
        $numChpts = count($this->positionsFound);

        for ($i = 0; $i < $numChpts; $i++)
        {
            if ( ($i + 1) < $numChpts )
            {
                echo "ready to make substring from pos " . $this->positionsFound[$i] . " of len " . ( $this->positionsFound[$i+1] - $this->positionsFound[$i]);
                echo ". i.e. chapter " . ($i + 1);
                echo "\n";
            }
            
            else 
            {
                // echo "working with the last chapter";
                echo "ready to make substring from pos " . $this->positionsFound[$numChpts - 1] . " of len " . ($this->getLengthTextFile() - $this->positionsFound[$numChpts - 1] );
                echo ". i.e. chapter " . ($i + 1);
                echo "\n";
            }
        }
    } // end seeChapterResults()


    // fn: make substrings from text and chapter positions
    // pushes substrings to this->chapterTexts
    public function makeChapterSubstrings()
    {
        $numChpts = count($this->positionsFound);

        for ($i = 0; $i < $numChpts; $i++)
        {
            if ( ($i + 1) < $numChpts )
            {
                // make a substring from the start of the chapter to the length of the chapter
                // make substring from pos $this->positionsFound[$i] to pos ( $this->positionsFound[$i+1] - 1 );
                $start = $this->positionsFound[$i];
                $lenSubStr = ( $this->positionsFound[$i+1] - $start);

                $chapter = substr($this->fileText, $start, $lenSubStr);
                array_push($this->chapterTexts, $chapter);
            }
            
            else 
            {
                // working with the last chapter
                // make substring from pos $this->positionsFound[$numChpts - 1] to pos $this->getLengthTextFile();
                $chapter = substr($this->fileText, $this->positionsFound[$numChpts - 1], ($this->getLengthTextFile() - $this->positionsFound[$numChpts - 1] ) );
                array_push($this->chapterTexts, $chapter);
            }
        }
    } // end makeChapterSubstrings()


    // fn: make chapter files from substrings collected
    public function makeChapterFiles($targetFileNames)
    {
        for($i = 0; $i < count($targetFileNames); $i++)
        {
            file_put_contents($targetFileNames[$i], $this->chapterTexts[$i]);
        }
    }


}