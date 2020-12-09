<?php

namespace app\repositories;

use app\models\Tick;
use yii\base\Component;

class TickRepository extends Component
{

    const TICK_COLUMNS = ['CREATED_AT', 'LAST', 'ASK', 'BID'];

    public function getBooks() {
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

    public function getTicksByBook($book) {
        return Tick::find()
            ->where(['book' => $book])
            ->select(self::TICK_COLUMNS)
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();
    }

}
