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

/**
 * @param int $length
 *
 * @return string
 */
function generateRandomString(int $length = 10) : string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}