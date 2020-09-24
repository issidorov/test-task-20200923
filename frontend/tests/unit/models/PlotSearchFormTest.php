<?php

namespace frontend\tests\unit\models;

use frontend\models\PlotSearchForm;

class PlotSearchFormTest extends \Codeception\Test\Unit
{
    /**
     * @param $expected
     * @param $numbers
     * @dataProvider dataNumbersToArray
     */
    public function testNumbersToArray($expected, $numbers)
    {
        $model = new PlotSearchForm(['numbers' => $numbers]);
        $actual = $model->numbersToArray();
        $this->assertEquals($expected, $actual);
    }

    public function dataNumbersToArray()
    {
        return [
            [["69:27:0000022:1306", "69:27:0000022:1307"], "69:27:0000022:1306, 69:27:0000022:1307"],
            [["69:27:0000022:1306", "69:27:0000022:1307"], "69:27:0000022:1306  ,  69:27:0000022:1307"],
            [["69:27:0000022:1306", "69:27:0000022:1307"], "  69:27:0000022:1306,69:27:0000022:1307   "],
            [["69:27:0000022:1306"], "69:27:0000022:1306"],
            [["69:27:0000022:1306"], "  69:27:0000022:1306  "],
        ];
    }

    /**
     * @param $expectHasError
     * @param $numbers
     * @dataProvider dataValidateNumbers
     */
    public function testValidateNumbers($expectHasError, $numbers)
    {
        $model = new PlotSearchForm(['numbers' => $numbers]);
        $model->validate();
        $this->assertEquals($expectHasError, $model->hasErrors());
    }

    public function dataValidateNumbers()
    {
        return [
            [false, "69:27:0000022:1306, 69:27:0000022:1307"],
            [false, "69:27:0000022:1306"],
            [true, "1234, 69:27:0000022:1307"],
            [true, "a9:27:0000022:1307"],
            [true, "_9:27:0000022:1307"],
            [true, "27:0000022:1307"],
            [true, "69:27:0000022:"],
            [true, "69:27:0000022:_"],
            [true, "69:27:0000022:1306,"],
            [true, "69:27:0000022:1306, "],
            [true, "69:27:0000022:1306 , "],
            [true, ",69:27:0000022:1306"],
            [true, ", 69:27:0000022:1306"],
            [true, " , 69:27:0000022:1306"],
        ];
    }
}
