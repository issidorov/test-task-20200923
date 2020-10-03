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

    public function __construct(string $modelClass, RemoteRequest $remoteRequest)
    {
        $this->modelClass = $modelClass;
        $this->remoteRequest = $remoteRequest;
    }

    public function run(array $numbers)
    {
        $notExistsNumbers = $this->filterNotExistsNumbers($numbers);
        $remoteItems = $this->remoteRequest->run($notExistsNumbers);
        foreach ($remoteItems as $item) {
            $this->saveItem($item);
        }
    }

    private function filterNotExistsNumbers($numbers)
    {
        $existsModels = $this->findExistsModelsByNumbers($numbers);
        $existsNumbers = ArrayHelper::getColumn($existsModels, 'number');
        return array_diff($numbers, $existsNumbers);
    }

    private function findExistsModelsByNumbers($numbers)
    {
        return $this->modelClass::findAll(['number' => $numbers]);
    }

    private function saveItem($item)
    {
        $model = $this->createModelFromItem($item);
        $this->saveModel($model);
    }

    private function createModelFromItem($item)
    {
        $model = new $this->modelClass();
        $model->number = $item->number;
        $model->address = $item->data->attrs->address;
        $model->price = $item->data->attrs->cad_cost;
        $model->area = $item->data->attrs->area_value;
        return $model;
    }

    private function saveModel(ActiveRecord $model)
    {
        $res = $model->save();
        if (!$res) {
            throw new Error('Invalid save Plot data');
        }
    }
}