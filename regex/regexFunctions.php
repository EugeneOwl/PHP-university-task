<?php

require_once "regexConsts.php";

function getRawText(): string
{
    $rawText = "There is a text. 
    1999 SAS. And this text exists   23! Isn't it? Yes it is 999!   100 HTTP  and OOP. 
    9!";
    return $rawText;
}

function getStringReport(string $string): string
{
    preg_match_all(
        WHITESPACE_REGEX,
        $string,
        $matchArray,
        PREG_OFFSET_CAPTURE
    );
    return "<div class='info'><p>Length = " . strlen($string) .
        "</p><p>Whitespaces amount = " . count($matchArray[0]) .
        "</p></div>";
}

function excludeWhitespaces(string $text): string
{
    $text = preg_replace(
        MULTIPLE_WHITESPACE_REGEX,
        " ",
        $text
    );
    return $text;
}

function getEntranceArray(string $text, string $patternRegex): array
{
    $entranceArray = [];
    preg_match_all(
        $patternRegex,
        $text,
        $matchArray,
        PREG_OFFSET_CAPTURE
    );
    foreach ($matchArray[0] as $key => $secondLevelArray) {
        $entranceArray[$key]["length"] = strlen($secondLevelArray[0]);
        $entranceArray[$key]["position"] = $secondLevelArray[1];
    }
    return $entranceArray;
}

function insertPatternInString(string $string, string $pattern, int $position): string
{
    $string = substr_replace($string, $pattern, $position, 0);
    return $string;
}

function highlightEachSentence(string $text): string
{
    $text = "<p>" . $text;
    $sentenceEndPositions = getEntranceArray($text, EOS_REGEX);
    for ($entranceNumber = count($sentenceEndPositions) - 1; $entranceNumber > -1; $entranceNumber--) {
        $text = insertPatternInString(
            $text,
            "</p><p>",
            $sentenceEndPositions[$entranceNumber]["position"] + 1
        );
    }
    $text = $text . "</p>";
    return $text;
}

function wrapUpInSpan(string $text, string $regexPattern, string $style): string
{
    $positions = getEntranceArray($text, $regexPattern);
    for ($entranceNumber = count($positions) - 1; $entranceNumber > -1; $entranceNumber--) {
        $text = insertPatternInString(
            $text,
            "</span>",
            $positions[$entranceNumber]["position"] + $positions[$entranceNumber]["length"]
        );
        $text = insertPatternInString(
            $text,
            "<span style='$style'>",
            $positions[$entranceNumber]["position"]
        );
    }
    return $text;
}

function getProcessedText(string $rawText): string
{
    $processedText = $rawText;
    $processedText = excludeWhitespaces($processedText);
    $processedText = highlightEachSentence($processedText);
    $processedText = wrapUpInSpan(
        $processedText,
        ABBREVIATION_REGEX,
        "text-decoration: underline"
    );
    $processedText = wrapUpInSpan(
        $processedText,
        NUMBER_REGEX,
        "color: blue"
    );
    return $processedText;
}
