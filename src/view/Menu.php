<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-16
 * Time: 21:17
 */

namespace view;


class Menu
{
    public function getMenu()
    {
        $menu = '<nav class="navbar navbar-default ">
                    <div class="container-fluid ">
                        <ul class="nav navbar-nav ">
                            <li class=""><a href="?device">Device</a></li>
                            <li class=""><a href="?sensor">Sensor</a> </li>
                            <li class=""><a href="?logout">Logout</a> </li>
                        </ul>
                    </div>
                </nav>
        ';
        return $menu;
    }

}