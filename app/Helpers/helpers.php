<?php

if (!function_exists('normalizeCount')) {
    function normalizeCount(string $value): int
    {
        $value = strtoupper(trim($value));

        if (str_ends_with($value, 'K')) {
            return (int) (floatval($value) * 1000);
        }

        if (str_ends_with($value, 'M')) {
            return (int) (floatval($value) * 1000000);
        }

        return (int) $value;
    }
}

if (!function_exists('generateNineDigitNumber')) {
    function generateNineDigitNumber(int $maxFirstNumber = 9): int
    {
        $first = rand(1, 5);

        $rest = '';
        for ($i = 0; $i < 8; $i++) {
            $rest .= rand(0, 9);
        }

        return (int) ($first . $rest);
    }
}
