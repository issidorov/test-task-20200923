<?php


namespace common\components\plot;

use yii\validators\Validator;

class CadastralNumberValidator extends Validator
{
    public function validateValue($value)
    {
        if (!is_string($value) || !preg_match('/^\d{2}:\d{2}:\d{7}:\d{4}$/', $value)) {
            return ['Кадастровый номер указан в не верном формате', []];
        } else {
            return null;
        }
    }
}