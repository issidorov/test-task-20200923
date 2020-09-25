<?php


namespace common\components\plot;


use Error;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class PlotSync
{
    /**
     * @var string|ActiveRecord
     */
    private $modelClass;
    /**
     * @var RemoteRequest
     */
    private $remoteRequest;

    public function __construct(string $modelClass, RemoteRequest $remoteRequest = null)
    {
        $this->modelClass = $modelClass;
        $this->remoteRequest = $remoteRequest ?? new RemoteRequest();
    }

    public function run(array $numbers)
    {
        $records = $this->modelClass::findAll(['number' => $numbers]);

        $existsNumbers = ArrayHelper::getColumn($records, 'number');
        $notExistsNumbers = array_diff($numbers, $existsNumbers);

        $remoteItems = $this->remoteRequest->run($notExistsNumbers);
        foreach ($remoteItems as $item) {
            $record = new $this->modelClass([
                'number' => $item->number,
                'address' => $item->data->attrs->address,
                'price' => $item->data->attrs->cad_cost,
                'area' => $item->data->attrs->area_value,
            ]);
            if (!$record->save()) {
                throw new Error('Invalid save Plot data');
            }
        }
    }
}