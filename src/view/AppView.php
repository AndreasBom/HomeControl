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
    private static $login = 'login';
    private static $logout = 'logout';
    private static $deviceMenu = 'device';
    private static $sensorMenu = 'sensor';
    private static $turnOn = 'turnOn';
    private static $turnOff = 'turnOff';
    private static $dim = 'dim';

    private $welcomeMessage = "<h2>Välkommen</h2><p>Du är inloggad<p/>";
    private $stateToPreform;
    private $content = '';

    public function __construct()
    {
        if(empty($this->content))
        {
            $this->content = $this->welcomeMessage;
        }
        iconv(mb_detect_encoding($this->content, mb_detect_order(), true), "UTF-8", $this->content);
    }


    //Turn on or turn off (returns 1 or 0)
    public function getStateToPreform()
    {
        return $this->stateToPreform;
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

    public function getDimValue()
    {
        if(isset($_GET['dimValue']))
        {
            return $_GET['dimValue'];
        }
    }


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

    public function didUserTryToLogOut()
    {
        return isset($_GET[self::$logout]);
    }
    /********* Menu end *************/

    public function renderAppContent()
    {
        return '<pre>
               '.   $this->content. '
                 </pre>';

    }

    public function reLoadPage()
    {
        header('Location: ' . $_SERVER['PHP_SELF']);
    }

    public function renderDeviceList($list)
    {
        $ret = "<div class='row'>";
        $ret .= "<ul class='ul_none_decoration'>";

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

            $ret .= "<p>Dimmervärde: <input type='text' class='". $cssTextBox ."' name='dimmer' size='3' maxlength='3' value='" . $dimValue. "'".$readonly."> <a class='btn btn-default btn-xs ". $cssTextBox ."' href='?device&dim=". $device["id"] ."&dimValue='>&#10004;</a></p>";
            $ret .= "</li>";
            $ret .= "<li>";
            $ret .= "<p><a class='btn btn-xs ".$this->buttonStatusCss($device["state"])[0] ."' href='?device&turnOff=".$device["id"]."' >AV</a>  <a class='btn btn-xs " .$this->buttonStatusCss($device["state"])[1] ."' href='?device&turnOn=".$device["id"]."'>PÅ</a> </p>";
            $ret .= "</li>";
            $ret .= "</ul>";
            $ret .= "</li>";

        }
        $ret .= "</ul>";
        $ret .= "</div>";



        $this->content = $ret;
    }

    public function renderSensorList($list)
    {
        $ret = "<div class='row'>";
        $ret .= "<ul class='ul_none_decoration'>";

        foreach($list->sensor as $sensor)
        {
            $ret .= "<li class='listStyle'>";
            if(empty($sensor['name']))
            {
                $name = "Namnlös";
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
            $ret .= "<p>Uppdaterad: " . $this->convertDate((int)$sensor['lastUpdated']) . "</p>";
            $ret .= "</li>";
            $ret .= "<li>";
            $ret .= "<p>Temperatur: ". $sensor['temp']  ."&#176</p>";
            $ret .= "</li>";
            $ret .= "<li>";
            $ret .= "<p>Luftfuktighet: ". $sensor['humidity'] ."%</p>";
            $ret .= "</li>";
            $ret .= "</ul>";
            $ret .= "</li>";

        }
        $ret .= "</ul>";
        $ret .= "</div>";



        $this->content = $ret;
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
            return "PÅ";
        }
        if($state == 2)
        {
            return "AV";
        }
        if($state == 16)
        {
            return "Dimmer aktiverad";
        }
    }

}