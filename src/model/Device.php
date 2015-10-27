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

class Device extends BaseREST
{

    //Feches and returns an xml-string with all devices
    public function getListOfDevices()
    {
        $params = array('supportedMethods' => 1023);
        $response = $this->getResponse('/devices/list', $params);
        return $response;
    }

    //Send resopnse that turns specific device on
    public function turnOn($id)
    {
        $params = array('id'=>$id);
        $this->sendResponse('/device/turnOn', $params);
    }

    //Send resopnse that turns specific device off
    public function turnOff($id)
    {
        $params = array('id'=>$id);
        $this->sendResponse('/device/turnOff', $params);
    }

    public function dim($id, $dimValue)
    {
        $params = array('id'=>$id, 'level'=>$dimValue);
        $this->sendResponse('device/dim', $params);
    }
}