<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-17
 * Time: 16:06
 */

namespace model;

require_once dirname(__DIR__) . '/common.php';

abstract class BaseREST
{
    protected $consumer;


    //Rest request
    public function getResponse($request, $params)
    {
        if($this->consumer == null)
        {
            $this->consumer = new \HTTP_OAuth_Consumer(constant('PUBLIC_KEY'), constant('PRIVATE_KEY'), constant('TOKEN'), constant('TOKENSECRET'));
        }

        $response = $this->consumer->sendRequest(constant('REQUEST_URI').$request,$params,'GET');


        $xmlResponse = $response->getBody();


        $asString = simplexml_load_string($xmlResponse);

        return $asString;
    }

    public function sendResponse($request, $params)
    {
        if($this->consumer == null)
        {
            $this->consumer = new \HTTP_OAuth_Consumer(constant('PUBLIC_KEY'), constant('PRIVATE_KEY'), constant('TOKEN'), constant('TOKENSECRET'));
        }


        $this->consumer->sendRequest(constant('REQUEST_URI'). $request, $params, 'GET');
    }
}