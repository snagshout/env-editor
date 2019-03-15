<?php

if (!function_exists('normalize_key_value_array')) {
    function normalize_key_value_array($array)
    {
        $normal = [];

        foreach ($array as $i => $a) {
            if (isset($a['key']) == false) {
                continue;
            }

            $normal[$a['key']] = $a['value'];
        }

        return $normal;
    }
}
