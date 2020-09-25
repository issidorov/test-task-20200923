<?php


namespace common\components\plot;


use common\components\plot\models\Plot;
use yii\helpers\ArrayHelper;

class PlotSync
{
    /**
     * @var RemoteRequest
     */
    private $remoteRequest;

    public function __construct(RemoteRequest $remoteRequest = null)
    {
        $this->remoteRequest = $remoteRequest ?? new RemoteRequest();
    }

    public function run(array $numbers)
    {
        $records = Plot::findAll(['number' => $numbers]);

        $existsNumbers = ArrayHelper::getColumn($records, 'number');
        $notExistsNumbers = array_diff($numbers, $existsNumbers);

        $remoteItems = $this->remoteRequest->run($notExistsNumbers);
        foreach ($remoteItems as $item) {
            $record = new Plot([
                'number' => $item->number,
                'address' => $item->data->attrs->address,
                'price' => $item->data->attrs->cad_cost,
                'area' => $item->data->attrs->area_value,
            ]);
            if (!$record->save()) {
                throw new \Error('Invalid save Plot data');
            }
        }
    }
}