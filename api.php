<?php
use shumenxc as xc;
require_once('config.inc.php');

header("Content-type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');

try {


    //multple requests
    $aRequests = json_decode($_REQUEST['requests'], 1);
    $aResponse = array();

    foreach($aRequests as $k => $aRequest) {
        try{

            list($sClassName, $sMethodName) = explode('.',$aRequest['target']);

            $sClassName = 'shumenxc\\'.$sClassName;
            if(empty($sClassName) || !class_exists($sClassName, true)) {
                throw new xc\XCException(sprintf("Клас \"%s\" не е намерен.", $sClassName));
            }

            $oClass = new $sClassName;

            if(!is_callable(array($oClass, $sMethodName))) throw new xc\XCException(sprintf("Метод \"%s\" не може да бъде извикан", $sMethodName));

            $aResponse[$k]['response'] = call_user_func_array(array($oClass, $sMethodName), $aRequest['params']);

        } catch( xc\XCException $e ) {
            $aResponse[$k]['error'] = $e->getJSObject();
        }
    }

    die(json_encode($aResponse, JSON_NUMERIC_CHECK));


} catch (Exception $e) {
    echo json_encode($e->getMessage());
}