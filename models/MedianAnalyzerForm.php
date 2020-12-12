<?php

namespace app\models;

class MedianAnalyzerForm extends TemporaryAnalyzerForm
{
    public $period;

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['period', 'required'],
            ['period', 'integer'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'period' => 'Periodo',
        ]);
    }

}
