<?php


namespace common\plot;


/**
 * @property $id
 * @property $number
 * @property $address
 * @property $price
 * @property $area
 */
class DbRecord extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'plot';
    }
}