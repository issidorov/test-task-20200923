<?php

use common\components\plot\PlotSync;
use yii\BaseYii;
use yii\console\Application as ConsoleApplication;
use yii\web\Application as WebApplication;

/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 * @see https://github.com/samdark/yii2-cookbook/blob/master/book/ide-autocompletion.md
 */
class Yii extends BaseYii
{
    /**
     * @var BaseApplication|ConsoleApplication|WebApplication the application instance
     */
    public static $app;
}

/**
 * @property PlotSync $plotSync
 */
abstract class BaseApplication extends yii\base\Application
{

}
