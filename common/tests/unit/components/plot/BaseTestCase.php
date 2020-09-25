<?php


namespace common\tests\unit\components\plot;

use common\components\plot\models\Plot;
use common\components\plot\PlotSync;
use PHPUnit\Framework\MockObject\MockObject;
use common\components\plot\RemoteRequest;

class BaseTestCase extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    /**
     * @var string[] Кадастровые номера, запрашиваемые с удаленного сервера
     */
    private $_remoteRequestNumbers = [];

    protected function _before()
    {
        Plot::deleteAll();
    }

    protected function _after()
    {
        Plot::deleteAll();
    }

    protected function createPlotSync(): PlotSync
    {
        $remoteRequest = $this->createRemoteRequestMock();
        return new PlotSync($remoteRequest);
    }

    /**
     * @return RemoteRequest|MockObject
     */
    protected function createRemoteRequestMock()
    {
        return $this->makeEmpty(RemoteRequest::class, [
            'run' => function (array $numbers) {
                $this->_remoteRequestNumbers = array_merge($this->_remoteRequestNumbers, $numbers);
                $res = [];
                foreach ($numbers as $number) {
                    $filename = __DIR__ . '/' . str_replace(':', '_', $number) .'.json';
                    $res[] = json_decode(file_get_contents($filename));
                }
                return $res;
            }
        ]);
    }

    protected function havePlotRecord($number)
    {
        $data = require __DIR__ . '/plot_data.php';
        $this->tester->haveRecord(Plot::class, $data[$number]);
    }

    protected function seePlotRecord($number)
    {
        $data = require __DIR__ . '/plot_data.php';
        $this->tester->seeRecord(Plot::class, $data[$number]);
    }

    protected function seePlotRecordCount($count)
    {
        $this->assertCount($count, Plot::find()->all());
    }

    protected function seeRemoteRequestCount(int $expectedCount)
    {
        $this->assertCount($expectedCount, $this->_remoteRequestNumbers);
    }

    protected function seeRemoteRequest(string $number)
    {
        $this->assertContainsEquals($number, $this->_remoteRequestNumbers);
    }
}