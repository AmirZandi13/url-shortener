<?php

namespace Src\services\UrlShortener;

use Exception;

class UrlShortener
{
    /**
     * @param string $url
     *
     * @return string
     * @throws Exception
     */
    public function urlToShortCode(string $url): string
    {

        $shortCode = $this->urlExistsInDB($url);

        if($shortCode == false){
            $shortCode = $this->createShortCode($url);
        }

        return $shortCode;
    }
}