<?php

/* @var $this yii\web\View */
/* @var $search \frontend\models\PlotSearchForm */
/* @var $dataProvider \yii\data\ArrayDataProvider|null */

use common\models\Plot;
use \yii\bootstrap\ActiveForm;
use \yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = 'Получение кадастровых данных';
?>
<div class="site-index">
    <h1><?= $this->title ?></h1>

    <?php $form = ActiveForm::begin(['enableClientValidation' => false]) ?>
        <?= $form->field($search, 'numbers')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Получить данные', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end() ?>

    <?php if ($dataProvider !== null): ?>
        <hr>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'number',
                    'label' => 'Кадастровый номер',
                ], [
                    'attribute' => 'address',
                    'label' => 'Адрес',
                ], [
                    'attribute' => 'price',
                    'label' => 'Стоимость',
                    'content' => function (Plot $plot) {
                        $value = Yii::$app->formatter->asDecimal($plot->price, 2);
                        return $value . ' ₽';
                    }
                ], [
                    'attribute' => 'area',
                    'label' => '',
                    'content' => function (Plot $plot) {
                        $value = Yii::$app->formatter->asDecimal($plot->price, 2);
                        return $value . ' м<sup>2</sup>';
                    }
                ]
            ],
            'summary' => 'Всего <b>{totalCount, number}</b> {totalCount, plural, one{запись} few{записи} other{записей}}.',
        ]) ?>
    <?php endif; ?>
</div>
