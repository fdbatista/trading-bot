<?php

namespace app\services;

use app\models\TemporaryAnalyzerForm;
use app\repositories\TickRepository;
use app\utils\MedianAnalyzerUtil;
use yii\base\Component;

class TemporaryAnalyzerService extends Component
{

    private $tickRepository;

    public function __construct(TickRepository $tickRepository)
    {
        $this->tickRepository = $tickRepository;
        parent::__construct();
    }

    public function analyzeTemporaries(TemporaryAnalyzerForm $model)
    {
        return $this->getTemporaries($model, SORT_DESC);
    }

    public function analyzeMedians(TemporaryAnalyzerForm $model)
    {
        $temporaries = $this->getTemporaries($model, SORT_ASC);

        return MedianAnalyzerUtil::extractMedianFromTemporaries($temporaries, 4);
    }

    private function getTemporaries(TemporaryAnalyzerForm $model, $sortMode)
    {
        $ticks = $this->tickRepository->getTicksByBook($model->book, $sortMode);
        $chunks = array_chunk($ticks, $model->temporary);

        return array_map(function ($chunk) {
            return $this->extractChunkData($chunk);
        }, $chunks);
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
