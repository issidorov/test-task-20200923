<?php

use common\components\plot\PlotSyncBuilder;

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
            return (new PlotSyncBuilder())->build();
        }
    ],
];
