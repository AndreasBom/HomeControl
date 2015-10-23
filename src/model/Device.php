<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-12
 * Time: 16:56
 */

namespace model;

require_once dirname(__DIR__) . '/common.php';
require_once'BaseREST.php';
require_once'DeviceModel.php';

class Device extends BaseREST
{
    private $arrayWithObjects;
    private $stateHasChangedFlag = false;

    public function getListOfDevices()
    {
        $params = array('supportedMethods' => 1023);
        $response = $this->getResponse('/devices/list', $params);

        foreach($response as $item)
        {
            $obj = new DeviceModel($item['name'], $item['id'], $item['state'], $item['statevalue'], $item['method']);
            $this->arrayWithObjects[] = $obj;
        }


        return $this->arrayWithObjects;
    }

    public function stateHasChanged()
    {
        return $this->stateHasChangedFlag;
    }

    public function turnOn($id)
    {
        $params = array('id'=>$id);
        $this->sendResponse('/device/turnOn', $params);
        $this->stateHasChangedFlag = true;

    }


    public function turnOff($id)
    {
        $params = array('id'=>$id);
        $this->sendResponse('/device/turnOff', $params);
        $this->stateHasChangedFlag = true;

    }

    public function dim($id, $dimValue)
    {
        $params = array('id'=>$id, 'level'=>$dimValue);
        $this->sendResponse('device/dim', $params);
        $this->stateHasChangedFlag = true;


    }





}