<?php

namespace tests\unit\models;

use app\utils\MedianAnalyzerUtil;

class MedianAnalyzerUtilTest extends \Codeception\Test\Unit
{
    public function testExtractMedianFromTemporaries()
    {
        $temporaries = [
            [
                'CREATED_AT' => 160234324,
                'LAST' => 1022,
                'ASK' => 1025,
                'BID' => 1001,
            ],
            [
                'CREATED_AT' => 160234324,
                'LAST' => 1322,
                'ASK' => 1325,
                'BID' => 1301,
            ],
            [
                'CREATED_AT' => 160234324,
                'LAST' => 1232,
                'ASK' => 1235,
                'BID' => 1011,
            ],
            [
                'CREATED_AT' => 160234324,
                'LAST' => 1145,
                'ASK' => 1147,
                'BID' => 1135,
            ],
            [
                'CREATED_AT' => 160234324,
                'LAST' => 1022,
                'ASK' => 1025,
                'BID' => 1001,
            ],
            [
                'CREATED_AT' => 160234324,
                'LAST' => 1392,
                'ASK' => 1399,
                'BID' => 1388,
            ],

        ];

        $median = MedianAnalyzerUtil::extractSMAFromTemporaries($temporaries, 2);

        expect(count($median))->equals(6);
    }

}
