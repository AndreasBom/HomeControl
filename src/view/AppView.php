<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-12
 * Time: 08:07
 */

namespace view;




class AppView //implements IView
{
    private static $logout = 'logout';
    private static $deviceMenu = 'device';
    private static $sensorMenu = 'sensor';
    private static $turnOn = 'turnOn';
    private static $turnOff = 'turnOff';
    private static $dim = 'dim';
    public static $logoutMessage = "logOutMessage";

    private $stateToPreform;
    private $content = '';

    public function redirect()
    {
        header('Location: ' . $_SERVER['PHP_SELF']);
    }

    //is used in index.php for doing a header location to ?device after a state on a device has changed
    public function getDeviceMenuQuery()
    {
        return self::$deviceMenu;
    }

    //Turn on or turn off (returns 1 or 0)
    public function getStateToPreform()
    {
        return $this->stateToPreform;
    }

    public function didUserTryToLogOut()
    {
        return isset($_GET[self::$logout]);
    }

    public function didUserChangeStateOnDevice()
    {
        if(isset($_GET[self::$turnOn]))
        {
            $this->stateToPreform = constant('TURNON');
            return true;
        }
        if(isset($_GET[self::$turnOff]))
        {
            $this->stateToPreform = constant('TURNOFF');
            return true;
        }
        if(isset($_GET[self::$dim]))
        {
            $this->stateToPreform =constant('DIM');
            return true;
        }

        return false;
    }

    //Not in use
    public function getDimValue()
    {
        if(isset($_GET['dimValue']))
        {
            return $_GET['dimValue'];
        }
    }

    //gets the id from the query string and returns it. Example: url . ?device&turnOn=54323   || returns null
    public function getIdOnSelectedDevice()
    {
        if(isset($_GET['turnOn']))
        {
            return $_GET['turnOn'];
        }
        if(isset($_GET['turnOff']))
        {
            return $_GET['turnOff'];
        }
        return null;
    }



    /********** MENU *****************/

    public function didUserChooseDeviceOnMenu()
    {
        return isset($_GET[self::$deviceMenu]);

    }

    public function didUserChooseSensorOnMenu()
    {
        return isset($_GET[self::$sensorMenu]);
    }

    /********* Menu end *************/

    public function renderAppContent($content)
    {
        if($content == '')
        {
            $content = '<h4>Welcome!</h4> <p> You are logged in</p>';
        }
        return '<pre>
               '. $content .'
                </pre>';

    }


    public function renderDeviceList($list)
    {
        if($list == null)
        {
            return "Something went wrong. Please try again";
        }

        $ret = "<div class='row'>";

        $ret .= "<ul class='ul_none_decoration'>";
        $ret .= "<h2>List of devices</h2>";

        foreach($list->device as $device)
        {

            $ret .= "<li class='listStyle'>";
            $ret .= "<h3>" . $device['name'] . "</h3>";
            $ret .= "<ul class='ul_none_decoration'>";
            $ret .= "<li>";
            $ret .= "<p>ID: " . $device['id'] . "</p>";
            $ret .= "</li>";
            $ret .= "<li>";
            $ret .= "<p>Status: " . $this->castState($device['state']) . "</p>";
            $ret .= "</li>";
            $ret .= "<li>";

            //Changes 'dimvärde' to 0 if device is either 100% on or  100% off
            if($this->castState($device['state'] == 1) || $this->castState($device['state'] == 2))
            {
                $dimValue = 0;
            }
            else
            {
                $dimValue = $device['statevalue'];
            }
            if($device['methods'] == 35)
            {
                $readonly = 'readonly';
                $cssTextBox = 'readonly';
            }
            else
            {
                $readonly = "";
                $cssTextBox = '';

            }

            $ret .= "<p>Dim Value: <form method='get'><input type='text' class='". $cssTextBox ."' name='dimmer' size='3' maxlength='3' value='" . $dimValue. "'".$readonly."> <a class='btn btn-default btn-xs ". $cssTextBox ."' href='#". $device["id"] ."&dimValue='>&#10004;</a></p></form> ";
            $ret .= "</li>";
            $ret .= "<li>";
            $ret .= "<p><a class='btn btn-xs ".$this->buttonStatusCss($device["state"])[0] ."' href='?device&turnOff=".$device["id"]."' >OFF</a>  <a class='btn btn-xs " .$this->buttonStatusCss($device["state"])[1] ."' href='?device&turnOn=".$device["id"]."'>ON</a> </p>";
            $ret .= "</li>";
            $ret .= "</ul>";
            $ret .= "</li>";

        }
        $ret .= "</ul>";
        $ret .= "</div>";



        return $ret;
    }

    public function renderSensorList($list)
    {
        $ret = "<div class='row'>";
        $ret .= "<ul class='ul_none_decoration'>";
        $ret .= "<h2>List of sensors</h2>";

        foreach($list->sensor as $sensor)
        {
            $ret .= "<li class='listStyle'>";
            if(empty($sensor['name']))
            {
                $name = "No Name";
            }
            else
            {
                $name = utf8_decode($sensor['name']);
            }
            $ret .= "<h3>" . $name . "</h3>";
            $ret .= "<ul class='ul_none_decoration diminishedTab'>";
            $ret .= "<li>";
            $ret .= "<p>ID: " . $sensor['id'] . "</p>";
            $ret .= "</li>";
            $ret .= "<li>";
            $ret .= "<p>Updated: " . $this->convertDate((int)$sensor['lastUpdated']) . "</p>";
            $ret .= "</li>";
            $ret .= "<li>";
            $ret .= "<p>Temperature: ". $sensor['temp']  ."&#176</p>";
            $ret .= "</li>";
            $ret .= "<li>";
            $ret .= "<p>Humidity: ". $sensor['humidity'] ."%</p>";
            $ret .= "</li>";
            $ret .= "</ul>";
            $ret .= "</li>";

        }
        $ret .= "</ul>";
        $ret .= "</div>";



        return $ret;
    }


    private function convertDate($unixTimeStamp)
    {
        $date = new \DateTime();
        date_timestamp_set($date, $unixTimeStamp);
        return $date->format('Y-m-d H:i:s');
    }


    private function buttonStatusCss($deviceStatus)
    {
        if($deviceStatus == 1)
        {
            $cssArray = array("btn-default", "btn-success");
            return $cssArray;
        }
        if($deviceStatus == 2)
        {
            $cssArray = array("btn-success","btn-default");
            return $cssArray;


        }
        if($deviceStatus == 16)
        {
            $cssArray = array("btn-info", "btn-info");
            return $cssArray;
        }
    }

    private function castState($state)
    {
        if($state == 1)
        {
            return "ON";
        }
        if($state == 2)
        {
            return "OFF";
        }
        if($state == 16)
        {
            return "Dimmer aktivated";
        }
    }

}