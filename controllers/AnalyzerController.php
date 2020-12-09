<?php

namespace app\controllers;

use app\models\AnalyzeTemporariesForm;
use app\models\ContactForm;
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

    private function getBooks() {
        $books = Tick::find()
            ->select('book')
            ->distinct()
            ->orderBy(['book' => SORT_DESC])
            ->asArray()
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

        $result = [];

        $i = 0;
        foreach ($rows as $row) {
            if ($i % $model->temporary === 0) {
                $result[] = $row;
            }
            $i++;
        }

        return $result;
    }

}
