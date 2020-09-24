<?php


namespace frontend\models;


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
        foreach ($this->numbersToArray() as $number) {
            if (!preg_match('/^\d{2}:\d{2}:\d{7}:\d{4}$/', $number)) {
                $this->addError('numbers', 'Поле заполнено не верно');
                return;
            }
        }
    }
}