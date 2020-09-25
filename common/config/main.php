<?php

use common\components\plot\PlotSync;
use common\models\Plot;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'plotSync' => function () {
            return new PlotSync(Plot::class);
        }
    ],
];
