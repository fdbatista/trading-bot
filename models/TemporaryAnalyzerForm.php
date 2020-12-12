<?php

namespace app\models;

use Yii;
use yii\base\Model;

class TemporaryAnalyzerForm extends Model
{
    public $temporary;
    public $book;

    public function rules()
    {
        return [
            [['temporary', 'book'], 'required'],
            ['temporary', 'integer'],
            ['book', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'temporary' => 'Temporalidad',
            'book' => 'Moneda',
        ];
    }

}
