<?php


namespace common\plot;


use yii\helpers\ArrayHelper;

class Finder
{
    /**
     * @var RemoteRequest
     */
    private $remoteRequest;

    public function __construct(RemoteRequest $remoteRequest)
    {
        $this->remoteRequest = $remoteRequest;
    }

    public function run($numbers)
    {
        $plots = [];

        $dbRecords = $this->findByDb($numbers);
        foreach ($dbRecords as $dbRecord) {
            $plot = $this->createPlotByDbRecord($dbRecord);
            $plots[$plot->number] = $plot;
        }

        $dbRecordNumbers = ArrayHelper::getColumn($dbRecords, 'number');
        $notExistsNumbers = array_diff($numbers, $dbRecordNumbers);
        $remoteItems = $this->remoteRequest->run($notExistsNumbers);
        foreach ($remoteItems as $item) {
            $plot = $this->createPlotByRemoteItem($item);
            $this->saveEntityToDb($plot);
            $plots[$plot->number] = $plot;
        }

        return $plots;
    }

    /**
     * @param $numbers
     * @return DbRecord[]
     */
    private function findByDb($numbers): array
    {
        return DbRecord::findAll(['number' => $numbers]);
    }

    private function createPlotByRemoteItem($item)
    {
        return new PlotEntity(
            $item->number,
            $item->data->attrs->address,
            $item->data->attrs->cad_cost,
            $item->data->attrs->area_value
        );
    }

    private function createPlotByDbRecord($dbRecord)
    {
        return new PlotEntity(
            $dbRecord->number,
            $dbRecord->address,
            $dbRecord->price,
            $dbRecord->area
        );
    }

    private function saveEntityToDb(PlotEntity $plot)
    {
        $dbRecord = new DbRecord([
            'number' => $plot->number,
            'address' => $plot->address,
            'price' => $plot->price,
            'area' => $plot->area,
        ]);
        if (!$dbRecord->save()) {
            throw new \Error('Invalid save Plot data');
        }
    }
}