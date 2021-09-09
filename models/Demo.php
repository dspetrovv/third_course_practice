<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $companyname
 */
class Demo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'demo';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'demoname' => 'Demoname',
            'demophoto' => 'Demophoto',
            'demodescription' => 'Demodescription',
            'demorequirements' => 'Demorequirements',
            'demolatcoord' => 'Demolatcoord',
            'demolongcoord' => 'Demolongcoord',
            'demoplace' => 'Demoplace'
        ];
    }
}
