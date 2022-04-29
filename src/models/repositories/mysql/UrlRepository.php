<?php

namespace Src\models\repositories\mysql;

use Src\models\repositories\RepositoryInterface;
use Src\models\Url;

class UrlRepository extends BaseRepository implements RepositoryInterface
{
    /**
     * UrlRepository Constructor
     */
    public function __construct()
    {
        $this->model = new Url();
    }

    /**
     * @param string $url
     *
     * @return mixed
     */
    public function urlExistsInDB(string $url)
    {
        $query = "SELECT short_url FROM ". $this->model->getTable() ." WHERE original_url = :original_url LIMIT 1";
        $stmt = $this->model->getDb()->prepare($query);
        $params = array(
            "original_url" => $url
        );
        $stmt->execute($params);

        $result = $stmt->fetch();

        return (empty($result)) ? false : $result["short_url"];
    }

    /**
     * @param string $url
     * @param string $code
     *
     * @return mixed
     */
    public function insertUrlInDB(string $url, string $code){
        $query = "INSERT INTO ". $this->model->getTable() ." (original_url, short_url, user_id) VALUES (:original_url, :short_url, :user_id)";
        $stmnt = $this->model->getDb()->prepare($query);
        $params = array(
            "original_url" => $url,
            "short_url" => $code,
            "user_id" => 1,
        );
        $stmnt->execute($params);

        return $this->model->getDb()->lastInsertId();
    }

    /**
     * @param string $code
     *
     * @return mixed
     */
    public function getUrlFromDB(string $code){
        $query = "SELECT id, original_url FROM ". $this->model->getTable() ." WHERE short_url = :short_url LIMIT 1";
        $stmt = $this->model->getDb()->prepare($query);
        $params=array(
            "short_url" => $code
        );
        $stmt->execute($params);

        $result = $stmt->fetch();
        return (empty($result)) ? false : $result;
    }
}