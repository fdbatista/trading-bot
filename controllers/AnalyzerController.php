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

        if ($model->load(Yii::$app->request->post())) {
            $result = $this->analyzeTemporaries($model->temporary);
        }

        return $this->render('analyze-temporaries', [
                'model' => $model,
                'columns' => $this->COLUMNS,
                'result' => $result,
            ]
        );
    }

    private function analyzeTemporaries(int $temporary)
    {
        $rows = Tick::find()
            ->select($this->COLUMNS)
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        $result = [];

        $i = 0;
        foreach ($rows as $row) {
            if ($i % $temporary === 0) {
                $result[] = $row;
            }
            $i++;
        }

        return $result;
    }

}
