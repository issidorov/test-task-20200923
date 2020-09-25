<?php


namespace frontend\models;


use common\components\plot\CadastralNumberValidator;
use yii\base\Model;

class PlotSearchForm extends Model
{
    public $numbers;

    public function numbersToArray()
    {
        return array_map('trim', explode(',', $this->numbers));
    }

    public function rules()
    {
        return [
            ['numbers', 'required'],
            ['numbers', 'string'],
            ['numbers', 'validateNumbers'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'numbers' => 'Кадастровые номера'
        ];
    }

    public function attributeHints()
    {
        return [
            'numbers' => 'Введите кадастровые номера через запятую. Например, «69:27:0000022:1306, 69:27:0000022:1307»'
        ];
    }

    public function validateNumbers()
    {
        $validator = new CadastralNumberValidator();
        foreach ($this->numbersToArray() as $number) {
            if (!$validator->validate($number, $error)) {
                $this->addError('numbers', $error);
                break;
            }
        }
    }
}