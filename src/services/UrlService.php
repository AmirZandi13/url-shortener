<?php

namespace Src\services;

use Exception;
use Src\models\repositories\RepositoryFactory;
use Src\models\repositories\RepositoryInterface;
use Src\utls\CacheService\CacheClientInterface;
use Src\utls\CacheService\CacheService;

class UrlService
{
    /**
     * @var RepositoryInterface
     */
    protected $urlRepository;

    /**
     * @var CacheClientInterface
     */
    protected $cacheClient;

    public function __construct()
    {
        $this->urlRepository = $this->getRepository();
        $this->cacheClient = (new CacheService())->getCacheClient();
    }

    private function getRepository()
    {
        return RepositoryFactory::make('UrlRepository');
    }

    public function get()
    {
        $shortCode = $_GET["short_code"] ?? '';

        if ($this->cacheClient->has($shortCode)) {
            $url = $this->cacheClient->get($shortCode);
            header("Location: ".$url);
        }

        $urlDB = $this->urlRepository->getUrlFromDB($shortCode);

        if (isset($urlDB)) {
            $url = $urlDB['original_url'];
            header("Location: ".$url);
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function post(): array
    {
        $body = (array) json_decode(file_get_contents('php://input'), TRUE);

        $url = $body['url'] ?? '';

        if(empty($url)) {
            return $this->unprocessableEntityResponse();
        }

        if($this->validateUrlFormat($url) == false) {
            return $this->unprocessableEntityResponse();
        }

        $shortCode = $this->urlRepository->urlExistsInDB($url);

        if($shortCode == false) {
            $shortCode = $this->createShortCode($url);
        }

        if (! $this->cacheClient->has($shortCode)) {
            $this->cacheClient->put($shortCode, $url, (int) getenv('URL_SHORTENER_CACHE_LIFETIME'));
        }

        $response['status_code_header'] = '201';
        $response['body'] = [
            'short_code' => $shortCode,
            'short_url' => getenv('BASE_SHORT_URL') . '/' . $shortCode
        ];

        return $response;
    }

    /**
     * @param string $url
     *
     * @return mixed
     */
    private function validateUrlFormat(string $url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    private function createShortCode(string $url): string
    {
        $shortCode = $this->generateHash();
        $this->urlRepository->insertUrlInDB($url, $shortCode);

        return $shortCode;
    }

    /**
     * @return string
     */
    private function generateHash(): string
    {
        $number = mt_rand(0, PHP_INT_MAX);

        return encode($number);
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = '422';

        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);

        return $response;
    }


    /**
     * @param $name
     * @param $arguments
     *
     * @return array
     */
    public function __call($name, $arguments): array
    {
        return $this->notFoundResponse();
    }

    /**
     * @return array
     */
    private function notFoundResponse(): array
    {
        $response['status_code_header'] = '404';
        $response['body'] = null;
        return $response;
    }
}