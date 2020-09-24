<?php


namespace common\tests\unit\plot;


use common\plot\DbRecord;
use common\plot\Finder;
use common\plot\RemoteRequest;
use PHPUnit\Framework\MockObject\MockObject;

trait HelperTrait
{
    private $remoteRequestedNumbers = [];

    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    /**
     * @return Finder
     */
    private function createFinder()
    {
        $remoteRequest = $this->createRemoteRequestMock();
        return new Finder($remoteRequest);
    }

    /**
     * @return RemoteRequest|MockObject
     */
    private function createRemoteRequestMock()
    {
        return $this->makeEmpty(RemoteRequest::class, [
            'run' => function (array $numbers) {
                $this->remoteRequestedNumbers = array_merge($this->remoteRequestedNumbers, $numbers);
                $res = [];
                foreach ($numbers as $number) {
                    $filename = __DIR__ . '/' . str_replace(':', '_', $number) .'.json';
                    $res[] = json_decode(file_get_contents($filename));
                }
                return $res;
            }
        ]);
    }

    private function haveDbRecord($number)
    {
        $data = require __DIR__ . '/plot_data.php';
        $this->tester->haveRecord(DbRecord::class, $data[$number]);
    }

    private function seeDbRecord($number)
    {
        $data = require __DIR__ . '/plot_data.php';
        $this->tester->seeRecord(DbRecord::class, $data[$number]);
    }

    private function seeDbRecordsCount($count)
    {
        $this->assertCount($count, DbRecord::find()->all());
    }
}