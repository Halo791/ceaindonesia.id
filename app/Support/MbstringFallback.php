<?php

namespace Illuminate\Support {
    if (! function_exists(__NAMESPACE__.'\\mb_split')) {
        function mb_split(string $pattern, string $string, int $limit = -1): array|false
        {
            $delimiter = '~';
            $escapedPattern = str_replace($delimiter, '\\'.$delimiter, $pattern);

            return preg_split($delimiter.$escapedPattern.$delimiter.'u', $string, $limit);
        }
    }
}
