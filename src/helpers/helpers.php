<?php

/**
 * @param string $number
 *
 * @return string
 */
function encode(string $number): string
{
    return strtr(rtrim(base64_encode(pack('i', $number)), '='), '+/', '-_');
}

/**
 * @param string $base64
 *
 * @return string
 */
function decode(string $base64): string
{
    $number = unpack('i', base64_decode(str_pad(strtr($base64, '-_', '+/'), strlen($base64) % 4, '=')));
    return $number[1];
}