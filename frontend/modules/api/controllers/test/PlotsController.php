<?php

namespace frontend\modules\api\controllers\test;

use frontend\modules\api\models\Plot;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class PlotsController extends Controller
{
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Plot::find()
        ]);
    }

    public function actionView($number)
    {
        Yii::$app->plotSync->run([$number]);
        return Plot::findOne(['number' => $number]);
    }
}
