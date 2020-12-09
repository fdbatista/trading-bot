<?php

namespace app\controllers;

use app\models\AnalyzeTemporariesForm;
use app\models\Tick;
use Yii;
use yii\web\Controller;

class AnalyzerController extends Controller
{

    private $COLUMNS = ['CREATED_AT', 'LAST', 'ASK', 'BID'];

    public function actionAnalyzeTemporaries()
    {
        $model = new AnalyzeTemporariesForm(['temporary' => 1]);
        $result = [];
        $books = $this->getBooks();

        if ($model->load(Yii::$app->request->post())) {
            $result = $this->analyzeTemporaries($model);
        }

        return $this->render('analyze-temporaries', [
                'model' => $model,
                'books' => $books,
                'columns' => $this->COLUMNS,
                'result' => $result,
            ]
        );
    }

    private function getBooks()
    {
        $books = Tick::find()
            ->select('book')
            ->distinct()
            ->orderBy(['book' => SORT_DESC])
            ->all();

        $res = [];
        foreach ($books as $index => $item) {
            $value = $item['book'];
            $res[$value] = strtoupper($value);
        }

        return $res;
    }

    private function analyzeTemporaries(AnalyzeTemporariesForm $model)
    {
        $rows = Tick::find()
            ->where(['book' => $model->book])
            ->select($this->COLUMNS)
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        $chunks = array_chunk($rows, $model->temporary);

        $results = array_map(function ($chunk) {
            return $this->extractChunkData($chunk);
        }, $chunks);

        return $results;
    }

    private function extractChunkData($chunk)
    {
        $mostRecentDate = $chunk[0]['CREATED_AT'];
        $mostRecentLast = $chunk[0]['LAST'];
        $maxAsk = $chunk[0]['ASK'];
        $minBid = $chunk[0]['BID'];

        $elemCount = count($chunk);
        for ($i = 1; $i < $elemCount; $i++) {
            if ($chunk[$i]['ASK'] > $maxAsk) {
                $maxAsk = $chunk[$i]['ASK'];
            }
            if ($chunk[$i]['BID'] < $minBid) {
                $minBid = $chunk[$i]['BID'];
            }
        }

        return [
            'CREATED_AT' => $mostRecentDate,
            'LAST' => $mostRecentLast,
            'ASK' => $maxAsk,
            'BID' => $minBid,
        ];
    }

}
