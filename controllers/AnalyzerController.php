<?php

namespace app\controllers;

use app\models\AnalyzeTemporariesForm;
use app\repositories\TickRepository;
use app\services\BookAnalyzerService;
use Yii;
use yii\web\Controller;

class AnalyzerController extends Controller
{

    private $tickRepository;
    private $bookAnalyzerService;

    const TICK_COLUMNS = ['CREATED_AT', 'LAST', 'ASK', 'BID'];

    public function __construct($id, $module, TickRepository $tickRepository, BookAnalyzerService $bookAnalyzerService, $config = [])
    {
        $this->tickRepository = $tickRepository;
        $this->bookAnalyzerService = $bookAnalyzerService;

        parent::__construct($id, $module, $config);
    }

    public function actionAnalyzeTemporaries()
    {
        $model = new AnalyzeTemporariesForm(['temporary' => 1]);

        if ($model->load(Yii::$app->request->post())) {
            $result = $this->bookAnalyzerService->analyzeTemporaries($model);
        } else {
            $result = [];
        }

        $books = $this->tickRepository->getBooks();

        return $this->render('analyze-temporaries', [
                'model' => $model,
                'books' => $books,
                'columns' => self::TICK_COLUMNS,
                'result' => $result,
            ]
        );
    }

}
