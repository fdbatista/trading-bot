<?php

namespace app\utils;

class MedianAnalyzerUtil
{

    public static function extractSMAFromTemporaries(array $temporaries, $period)
    {
        $lastValues = self::extractLastFromTemporaries($temporaries);

        $lastStartingIndex = count($lastValues) - $period;
        $result = [];

        for ($i = 0; $i <= $lastStartingIndex; $i++) {
            $rangeOfLasts = array_slice($lastValues, $i, $period);
            $arrayMedian = self::calculateSMAFromRangeOfLasts($rangeOfLasts);

            if ($i == 0) {
                foreach ($rangeOfLasts as $rangeValue) {
                    $result[] = [
                        'LAST' => $rangeValue,
                        'SMA' => '',
                    ];
                }
                $result[$period - 1]['SMA'] = $arrayMedian;
            } else {
                $result[] = [
                    'LAST' => $rangeOfLasts[$period - 1],
                    'SMA' => $arrayMedian,
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

    private static function calculateSMAFromRangeOfLasts(array $lasts)
    {
        $valuesSum = array_reduce($lasts, function ($carry, $item) {
            $carry += $item;
            return $carry;
        }, 0);

        $lastsCount = count($lasts);

        return round($valuesSum / $lastsCount, 2);
    }

    public static function extractEMAFromTemporaries(array $temporaries, $period)
    {
        $sma = self::extractSMAFromTemporaries($temporaries, $period);

        for ($i = 0; $i < $period - 1; $i ++) {
            $sma[$i]['EMA'] = '';
        }

        $sma[$period - 1]['EMA'] = $sma[$period - 1]['SMA'];
        $previousEMA = $sma[$period - 1]['EMA'];

        $k = 2 / ($period + 1);
        $seriesCount = count($sma);

        for ($i = $period; $i < $seriesCount; $i ++) {
            $currentEMA = round($sma[$i]['LAST'] * $k + $previousEMA * ($k - 1), 2);
            $sma[$i]['EMA'] = $currentEMA;

            $previousEMA = $currentEMA;
        }

        return $sma;
    }

}
