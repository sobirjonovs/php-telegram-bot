<?php

if (!function_exists('getNested')) {
    function getNested(string $target, array $parameters, string $needle = ".")
    {
        $targetAsArray = explode($needle, $target);

        foreach ($targetAsArray as $target) {
            if (isset($parameters[$target])) {
                $parameters = $parameters[$target];
            }
        }

        return $parameters;
    }
}

if (!function_exists('config')) {
    function config(string $config)
    {
        $config = explode('.', $config);
        $file = require array_shift($config) . '.php';
        return getNested(join('.', $config), $file);
    }
}

if (!function_exists('snake_case')) {
    /**
     * @param string $needle
     * @param string $remove
     * @param string $to
     * @return string
     */
    function snake_case(string $needle, string $remove = "Handler", string $to = ""): string
    {
        $cleanedString = str_replace($remove, $to, $needle);
        $snakeCasedStringArray = preg_split(
            "/(?=[A-Z])/",
            $cleanedString,
            -1,
            PREG_SPLIT_NO_EMPTY);

        return strtolower(implode("_", $snakeCasedStringArray));
    }
}