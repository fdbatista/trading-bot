<?php

namespace app\utils;

class MedianAnalyzerUtil
{

    public static function extractMedianFromTemporaries(array $temporaries, $period)
    {
        $lastValues = self::extractLastFromTemporaries($temporaries);
        $lastValues = array_splice($lastValues, 0, 8);

        $lastStartingIndex = count($lastValues) - $period;
        $result = [];

        for ($i = 0; $i <= $lastStartingIndex; $i++) {
            $arrayOfLastsFromRange = array_slice($lastValues, $i, $period);
            $arrayMedian = self::calculateMedianFromArrayOfLasts($arrayOfLastsFromRange);

            if ($i == 0) {
                foreach ($arrayOfLastsFromRange as $rangeValue) {
                    $result[] = [
                        'LAST' => $rangeValue,
                        'MEDIA' => '',
                    ];
                }
                $result[$period - 1]['MEDIA'] = $arrayMedian;
            } else {
                $result[] = [
                    'LAST' => $arrayOfLastsFromRange[$period - 1],
                    'MEDIA' => $arrayMedian,
                ];
            }
        }

        return $result;
    }

    private static function extractLastFromTemporaries(array $temporaries)
    {
        return array_map(function ($temporary) {
            return $temporary['LAST'];
        }, $temporaries);
    }

    private static function calculateMedianFromArrayOfLasts(array $lasts)
    {
        $valuesSum = array_reduce($lasts, function ($carry, $item) {
            $carry += $item;
            return $carry;
        }, 0);

        $lastsCount = count($lasts);

        return round($valuesSum / $lastsCount, 2);
    }

}
