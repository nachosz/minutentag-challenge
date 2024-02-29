<?php
class LetterCounter{
    public static function CountLettersAsString(string $word) : string
    {
        $arrayCount = self::getArrayOfCharCount($word);
        return self::transformToAsteriskString($arrayCount);
    }

    private static function getArrayOfCharCount(string $word)
    {
        return array_count_values(array_map(fn($item) => strtolower($item),str_split($word)));
    }

    private static function transformToAsteriskString(array $arrayCount)
    {
        return json_encode(array_map(fn($item) => str_repeat('*', $item), $arrayCount));
    }
}

$word = "Interview";

$count = LetterCounter::CountLettersAsString($word);
echo $count;

