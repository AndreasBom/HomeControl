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


    /*private function changeState($id)
    {
        $list = $this->getListOfDevices();

        foreach($list as $l)
        {

            if($l[$id] == $id)
            {

                if($l['state'] == 1)
                {
                    $l['state'] == 2;
                }
                else
                {
                    $l['state'] == 1;
                }
            }
        }

        return $list;
    }*/

    public function turnOn($id)
    {
        $params = array('id'=>$id);
        $this->sendResponse('/device/turnOn', $params);
        //return $this->changeState($id);
    }

    public function turnOff($id)
    {
        $params = array('id'=>$id);
        $this->sendResponse('/device/turnOff', $params);
        //return $this->changeState($id);

    }

    public function dim($id, $dimValue)
    {
        $params = array('id'=>$id, 'level'=>$dimValue);
        $this->sendResponse('device/dim', $params);

        //return $this->changeState()
    }





}