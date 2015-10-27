<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-17
 * Time: 16:06
 */

namespace model;

use login\model\LoginModel;

require_once dirname(__DIR__) . '/common.php';

abstract class BaseREST
{
    protected $consumer;


    //REST request that gets a list of requested device/sensor
    public function getResponse($request, $params)
    {
        if($this->consumer == null)
        {
            $this->consumer = new \HTTP_OAuth_Consumer(constant('PUBLIC_KEY'), constant('PRIVATE_KEY'), LoginModel::getSessionAccessToken(), LoginModel::getSessionAccessTokenSecret());
        }

        $response = $this->consumer->sendRequest(constant('REQUEST_URI').$request,$params,'GET');


        $xmlResponse = $response->getBody();


        $asString = simplexml_load_string($xmlResponse);

        return $asString;
    }

    //REST request that changes state
    public function sendResponse($request, $params)
    {
        if($this->consumer == null)
        {
            $this->consumer = new \HTTP_OAuth_Consumer(constant('PUBLIC_KEY'), LoginModel::getSessionAccessToken(), LoginModel::getSessionAccessTokenSecret());
        }


        $this->consumer->sendRequest(constant('REQUEST_URI'). $request, $params, 'GET');
    }
}