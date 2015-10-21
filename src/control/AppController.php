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
        //'Enheter' on menu is pressed
        if($appV->didUserChooseDeviceOnMenu())
        {
            $list = $this->device->listDevices();
            $appV->renderDeviceList($list);
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


            //FUNKAR INTE
            /*if(isset($_GET))
            {
                header("Location: " . $_SERVER['PHP_SELF'] . "?device");
            }*/

        }

        if($appV->didUserChooseSensorOnMenu())
        {
            $list = $this->sensor->listSensors();
            $appV->renderSensorList($list);

        }

        //After successful login, render HTML for menu and content
        $layoutV->renderMenu();
        return $appV->renderAppContent();
    }
}