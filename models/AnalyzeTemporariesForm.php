<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * AnalyzeTemporariesForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class AnalyzeTemporariesForm extends Model
{
    public $temporary;

    public function rules()
    {
        return [
            [['temporary'], 'required'],
            ['temporary', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'temporary' => 'Temporalidad',
        ];
    }

}
