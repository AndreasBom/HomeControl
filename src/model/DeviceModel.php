<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-21
 * Time: 19:17
 */

namespace model;


class DeviceModel
{
    public $name;
    public $id;
    public $state;
    public $stateValue;
    public $method;

    public function __construct($name, $id, $state, $stateValue, $method)
    {
        $this->name = $name;
        $this->id = $id;
        $this->state = $state;
        $this->stateValue = $stateValue;
        $this->method = $method;
    }

}