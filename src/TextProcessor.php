<?php

class TextProcessor
{
    private const ENCODING = 'UTF-8';

    public static function processFile(string $inputFileName = 'input.txt', string $outputFileName = 'output.txt'): void
    {
        $text = file_get_contents($inputFileName);

        $lines = explode(PHP_EOL, $text);
        foreach ($lines as &$line) {
            $words = preg_split('/(\p{L}+)/u', $line, null, PREG_SPLIT_DELIM_CAPTURE);
            foreach ($words as &$word) {
                $word = self::shuffleWord($word);
            }
            $line = implode('', $words);
        }
        $outputText = implode(PHP_EOL, $lines);

        file_put_contents(
            $outputFileName,
            mb_convert_encoding($outputText, self::ENCODING),
        );
    }

    private static function shuffleWord(string $word): string
    {
        if (mb_strlen($word, self::ENCODING) > 3) {

            $firstLetter = mb_substr($word, 0, 1, self::ENCODING);
            $lastLetter = mb_substr($word, -1, 1, self::ENCODING);
            $middleLetters = mb_substr($word, 1, -1, self::ENCODING);

            return $firstLetter.self::shuffleMiddleLetters($middleLetters).$lastLetter;
        }

        return $word;
    }

    private static function shuffleMiddleLetters($letters): string
    {
        $shuffledMiddle = '';
        if (mb_strlen($letters, self::ENCODING) > 1) {
            do {
                $shuffledMiddle = str_shuffle($letters);
            } while ($letters === $shuffledMiddle);
        }

        return $shuffledMiddle;
    }
}