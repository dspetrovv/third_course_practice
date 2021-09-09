<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $companyname
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'companyname' => 'Companyname',
            'companyphoto' => 'Companyphoto',
            'companydescription' => 'Companydescription',
            'companyrequirements' => 'Companyrequirements',
            'latcoord' => 'Latcoord',
            'longcoord' => 'Longcoord',
            'place' => 'Place'
        ];
    }
}
