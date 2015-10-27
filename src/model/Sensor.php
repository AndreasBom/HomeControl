<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-17
 * Time: 16:05
 */

namespace model;


class Sensor extends BaseREST
{

    public function getListOfSensors()
    {
        $params = array('includeValues' => 1);
        $response = $this->getResponse('/sensors/list', $params);

        return $response;
    }
}