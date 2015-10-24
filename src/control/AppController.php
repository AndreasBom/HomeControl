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
use view\CookieStorage;
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
        $list = '';
        $bodyContent = '';


        if($appV->didUserChooseDeviceOnMenu())
        {
            $list = $this->device->getListOfDevices();

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

                if($state = 51)
                {
                    //Not in use
                    //$this->device->dim($id,$appV->getDimValue());
                }
            }

            $bodyContent = $appV->renderDeviceList($list);
        }

        if($appV->didUserChooseSensorOnMenu())
        {
            $list = $this->sensor->getListOfSensors();
            $bodyContent = $appV->renderSensorList($list);
        }

        if($appV->didUserTryToLogOut())
        {
            $s = new CookieStorage();
            //Saves Logout message
            $s->setMessage();
            //Kills session
            $loginM->logout();
            $appV->redirect();


        }


        $appV->renderDeviceList($list);

        $layoutV->renderMenu();

        return $appV->renderAppContent($bodyContent);
    }
}