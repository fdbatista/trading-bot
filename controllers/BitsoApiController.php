<?php

namespace app\controllers;

use Dotenv\Dotenv;
use yii\httpclient\Client;
use yii\web\Controller;

class BitsoApiController extends Controller
{

    private $BOOKS_ENDPOINT;
    private $TICKER_ENDPOINT;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $dotEnv = Dotenv::createImmutable(__DIR__ . "/../");
        $dotEnv->load();

        $this->BOOKS_ENDPOINT = $_ENV['BITSO_BOOKS_ENDPOINT'];
        $this->TICKER_ENDPOINT = $_ENV['BITSO_TICKER_ENDPOINT'];

    }

    public function actionGetBooks()
    {
        return $this->getBooksList();
    }

    private function getBooksList()
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($this->BOOKS_ENDPOINT)
            ->send();

        if ($response->isOk) {
            return $response;
        }
    }

}
