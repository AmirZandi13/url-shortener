<?php

namespace Src\tests;

use PHPUnit\Framework\TestCase;
use Src\models\repositories\mysql\UrlRepository;
use Src\models\repositories\RepositoryInterface;

final class UrlTest extends TestCase
{
    /**
     * @var RepositoryInterface
     */
    protected $urlRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->urlRepository = new UrlRepository();
    }

    public function testInsertingInDatabase(): void
    {
        $number = mt_rand(0, PHP_INT_MAX);
        $code = encode($number);

        $websiteName = generateRandomString();
        $result = $this->urlRepository->insertUrlInDB('https://www.' . $websiteName . '.com', $code);

        $this->assertEquals(true, $result);
    }

    public function testIfUrlExistsInDatabaseShouldReturnAString(): void
    {
        $number = mt_rand(0, PHP_INT_MAX);
        $code = encode($number);

        $originalUrl = 'https://www.' . generateRandomString() . '.com';
        $this->urlRepository->insertUrlInDB($originalUrl, $code);

        $urlExist = $this->urlRepository->urlExistsInDB($originalUrl);

        $this->assertEquals('string', gettype($urlExist));
    }

    public function testIfUrlDoesNoExistInDatabaseShouldReturnFalse(): void
    {
        $originalUrl = 'https://www.' . generateRandomString() . '.com';

        $urlExist = $this->urlRepository->urlExistsInDB($originalUrl);

        $this->assertEquals(false, $urlExist);
    }

    public function testCheckAHashCodeExistInDatabase(): void
    {
        $number = mt_rand(0, PHP_INT_MAX);
        $code = encode($number);

        $originalUrl = 'https://www.' . generateRandomString() . '.com';
        $this->urlRepository->insertUrlInDB($originalUrl, $code);

        $hashExist = $this->urlRepository->getUrlFromDB($code);

        $this->assertEquals('array', gettype($hashExist));
    }
}