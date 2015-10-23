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
    private $stateFlag;

    public function getListOfDevices()
    {
        $params = array('supportedMethods' => 1023);
        $response = $this->getResponse('/devices/list', $params);
        return $response;


    }

/*
    private function changeState($id)
    {
        $list = $this->getListOfDevices();

        foreach($list as $l)
        {
            var_dump($l);
            if($l->id == $id)
            {
                var_dump("hejjj");
                die();
            }
        }

        return $list;
    }*/

    public function turnOn($id)
    {
        $params = array('id'=>$id);
        $this->sendResponse('/device/turnOn', $params);


        return $list;
    }

    public function turnOff($id)
    {
        $params = array('id'=>$id);
        $this->sendResponse('/device/turnOff', $params);
        $list = $this->getListOfDevices();
        return $list;


    }

    public function dim($id, $dimValue)
    {
        $params = array('id'=>$id, 'level'=>$dimValue);
        $response = $this->sendResponse('device/dim', $params);

    }





}