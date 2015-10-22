<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-16
 * Time: 21:58
 */

namespace control;

require_once'./src/model/Device.php';
require_once'./src/model/Sensor.php';
require_once'./src/common.php';

use login\ILoginModel;
use model\Sensor;
use view\AppView;
use view\LayoutView;
use view\Menu;
use \model\Device;

class AppController
{
    private $device;
    private $sensor;

    public function __construct()
    {
        $this->device = new Device();
        $this->sensor = new Sensor();
    }

    public function runApp(AppView $appV, LayoutView $layoutV, ILoginModel $loginM)
    {
        $list = null;
        $content = '';
        //'Enheter' on menu is pressed
        if($appV->didUserChooseDeviceOnMenu())
        {
            $list = $this->device->listDevices();
            $content = $appV->renderListOfDevices($list);
        }

        if($appV->didUserChangeStateOnDevice())
        {
            $id= $appV->getIdOnSelectedDevice();
            $state = $appV->getStateToPreform();

            if($state == 2)
            {
                $this->device->turnOff($id);
            }
            if($state == 1)
            {
                $this->device->turnOn($id);
            }
        }

        if($appV->didUserChooseSensorOnMenu())
        {
            $list = $this->sensor->listSensors();
            $content = $appV->renderSensorList($list);

        }


        if($appV->didUserTryToLogOut()) {
            $loginM->logout();
            $appV->reLoadPage();
        }

        //After successful login, render HTML for menu and return content to <body> in Layout
        $layoutV->renderMenu();
        return $content;

    }



}