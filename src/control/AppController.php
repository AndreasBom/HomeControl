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

    //Will run if user is logged in
    public function runApp(AppView $appV, LayoutView $layoutV, ILoginModel $loginM)
    {
<<<<<<< HEAD
        $list = null;

        //'Enheter' on menu is pressed
        if($appV->didUserChooseDeviceOnMenu())
        {
            $list = $this->device->listDevices();
            //$appV->renderDeviceList($list);
            $appV->renderListOfDevices($list);
        }
=======
        $list = '';
        $bodyContent = '';

>>>>>>> third

        if($appV->didUserChooseDeviceOnMenu())
        {
            $list = $this->device->getListOfDevices();

            if($appV->didUserChangeStateOnDevice())
            {
<<<<<<< HEAD
                $this->device->turnOff($id);
            }
            if($state == 1)
            {
                $this->device->turnOn($id);
            }
=======
                $id= $appV->getIdOnSelectedDevice();
                $state = $appV->getStateToPreform();

                if($state == 2)
                {
                    $this->device->turnOff($id);
>>>>>>> third

                }
                if($state == 1)
                {
                    $this->device->turnOn($id);
                }

<<<<<<< HEAD
=======
                if($state = 51)
                {
                    //Not in use
                    //$this->device->dim($id,$appV->getDimValue());
                }
            }

            //HTMLifies the list
            $bodyContent = $appV->renderDeviceList($list);
>>>>>>> third
        }

        if($appV->didUserChooseSensorOnMenu())
        {
            $list = $this->sensor->getListOfSensors();
            //HTMLifies the list
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

<<<<<<< HEAD
        if($appV->didUserTryToLogOut()) {
            $loginM->logout();
            $appV->reLoadPage();
        }

        //After successful login, render HTML for menu and content
        
=======

>>>>>>> third
        $layoutV->renderMenu();

        //Returns HTML (either device or sensor list)
        return $appV->renderAppContent($bodyContent);
    }
}