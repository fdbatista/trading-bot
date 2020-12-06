<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tick".
 *
 * @property int $id
 * @property string|null $high
 * @property string|null $low
 * @property string|null $last
 * @property string|null $created_at
 * @property string|null $book
 * @property string|null $volume
 * @property string|null $vwap
 * @property string|null $ask
 * @property string|null $bid
 * @property string|null $change_24
 */
class Tick extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tick';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['high', 'low', 'last', 'created_at', 'book', 'volume', 'vwap', 'ask', 'bid', 'change_24'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'high' => Yii::t('app', 'High'),
            'low' => Yii::t('app', 'Low'),
            'last' => Yii::t('app', 'Last'),
            'created_at' => Yii::t('app', 'Created At'),
            'book' => Yii::t('app', 'Book'),
            'volume' => Yii::t('app', 'Volume'),
            'vwap' => Yii::t('app', 'Vwap'),
            'ask' => Yii::t('app', 'Ask'),
            'bid' => Yii::t('app', 'Bid'),
            'change_24' => Yii::t('app', 'Change 24'),
        ];
    }
}
