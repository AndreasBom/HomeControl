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

    public function changeState(AppView $appV, LayoutView $layoutV, ILoginModel $loginM)
    {

    }


    public function runApp(AppView $appV, LayoutView $layoutV, ILoginModel $loginM)
    {
        //Render Menu if user is logged in
        $layoutV->renderMenu();

        $list = '';
        $bodyContent = '';


        //Changing state
        if($appV->didUserChangeStateOnDevice())
        {
            if($appV->getStateToPreform() == 1)
            {

                $this->device->turnOn($appV->getIdOnSelectedDevice());
            }
            if($appV->getStateToPreform() == 2)
            {
                $this->device->turnOff($appV->getIdOnSelectedDevice());
            }
        }


        //collecting list of objects AFTER state is changed
        if($appV->didUserChooseDeviceOnMenu())
        {
            $list = $this->device->getListOfDevices();
            //HTMLifies list
            $bodyContent = $appV->renderListOfDevices($list);
        }

        if($appV->didUserChooseSensorOnMenu())
        {
            $list = $this->sensor->getListOfSensors();
            //HTMLifies list
            $bodyContent = $appV->renderSensorList($list);
        }

        if($appV->didUserTryToLogOut())
        {
            $loginM->logout();
        }


        //Returning content, that will go into layoutView as HTML
        return $bodyContent;



    }



}