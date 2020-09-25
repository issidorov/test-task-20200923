<?php


namespace console\controllers;


use common\components\plot\CadastralNumberValidator;
use common\components\plot\PlotSync;
use common\components\plot\models\Plot;
use yii\console\widgets\Table;
use yii\helpers\ArrayHelper;

class PlotController extends \yii\console\Controller
{
    public function actionParse(string $numbers)
    {
        $numbers = array_map('trim', explode(',', $numbers));

        if (empty($numbers)) {
            echo "Необходимо указать кадастровые номера\n";
            return 1;
        }
        $validator = new CadastralNumberValidator();
        foreach ($numbers as $number) {
            if (!$validator->validate($number, $error)) {
                echo $error . "\n";
                return 1;
            }
        }

        (new PlotSync())->run($numbers);
        $plots = Plot::findAll(['number' => $numbers]);

        if ($plots) {
            echo Table::widget([
                'headers' => ['CN', 'Addr', 'Price', 'Area'],
                'rows' => ArrayHelper::toArray($plots, [Plot::class => ['number', 'address', 'price', 'area']]),
            ]);
        } else {
            echo 'Not found';
        }

        return 0;
    }
}