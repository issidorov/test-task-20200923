<?php

namespace frontend\modules\api\controllers\test;

use frontend\modules\api\models\Plot;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class PlotsController extends ActiveController
{
    public $modelClass = Plot::class;
}
