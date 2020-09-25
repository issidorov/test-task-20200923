<?php


namespace frontend\modules\api\models;


class Plot extends \common\models\Plot
{
    public function fields()
    {
        return [
            'cadastral_number' => function (Plot $model) {
                return $model->number;
            },
            'address',
            'price',
            'area',
        ];
    }
}