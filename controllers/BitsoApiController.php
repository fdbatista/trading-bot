<?php

namespace app\controllers;

use app\models\Tick;
use Dotenv\Dotenv;
use yii\httpclient\Client;
use yii\web\Controller;

class BitsoApiController extends Controller
{

    private $BOOKS_ENDPOINT;
    private $TICKER_ENDPOINT;
    private $IGNORED_BOOKS;

    private $httpClient;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $dotEnv = Dotenv::createImmutable(__DIR__ . "/../");
        $dotEnv->load();

        $this->BOOKS_ENDPOINT = $_ENV['BITSO_BOOKS_ENDPOINT'];
        $this->TICKER_ENDPOINT = $_ENV['BITSO_TICKER_ENDPOINT'];
        $this->IGNORED_BOOKS = explode(',', $_ENV['BITSO_IGNORED_BOOKS']);

        $this->httpClient = new Client();
    }

    public function actionGetBooksStatus()
    {
        $books = $this->getBooksList();

        $transaction = \Yii::$app->db->beginTransaction();

        foreach ($books as $book) {
            $bookName = $book['book'];

            if (!in_array($bookName, $this->IGNORED_BOOKS)) {
                $ticker = $this->getTicker($bookName);
                $ticker['book'] = $bookName;
                $ticker['created_at'] = time();

                $model = new Tick($ticker);
                $model->save();
            }
        }

        $transaction->commit();

        return "OK";
    }

    private function getBooksList()
    {
        $response = $this->httpClient->createRequest()
            ->setMethod('GET')
            ->setUrl($this->BOOKS_ENDPOINT)
            ->send();

        return ($response->isOk) ? $response->data['payload'] : [];
    }

    private function getTicker($bookName)
    {
        $response = $this->httpClient->createRequest()
            ->setMethod('GET')
            ->setUrl($this->TICKER_ENDPOINT)
            ->setData(['book' => $bookName])
            ->send();

        return ($response->isOk) ? $response->data['payload'] : [];
    }

}
