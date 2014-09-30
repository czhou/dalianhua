<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define path to public directory
defined('PUBLIC_PATH')
    || define('PUBLIC_PATH', realpath(dirname(__FILE__) ));

    // Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/forms'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);



$application->bootstrap();

$voteNum = 583;
$error_count = 0;

for($i = 1; $i <= $voteNum; $i++){
    $zan_rand = "";
    $ip1 = rand(1,254);
    $ip2 = rand(1,254);
    $ip3 = rand(1,254);
    $ip4 = rand(1,254);
    $ip = $ip1 . "." . $ip2 . "." . $ip3 . "." . $ip4;


    try{
        $start = time();

        echo "================ vote $i ===================\n";
        // fetch zan rand char
        $referClient = new Zend_Http_Client();
        $referClient->resetParameters(true);
        $referClient->setConfig(array('timeout'=>30));
        $referClient->setCookieJar(true);
        $referClient->setHeaders(
            array(
                "User-Agent" => "Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko",
                "X-FORWARDED-FOR" => $ip,
                "CLIENT-IP" => $ip,
                "REFERER" => "http://vote.runsky.com/2014/09/yifangdl/index.php"

            ));
        $referClient->setUri("http://vote.runsky.com/2014/09/yifangdl/index.php?app=index");
        $referResponse = $referClient->request("GET");
        if($referResponse->getStatus() == 200){
//            echo $referResponse->getBody();
//            continue;
            $zan_rand = getRandChar($referResponse->getBody());
            echo "Rand: " . $zan_rand . "\n";
        }else{
            echo "Failed: " . $referResponse->getStatus() . "\n";
        }



        //vote!!
//        $httpClient = new Zend_Http_Client();
//        $httpClient->resetParameters(true);
//        $httpClient->setConfig(array('timeout'=>30));
//        $httpClient->setHeaders(
//            array(
//                "User-Agent" => "Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko",
//                "X-FORWARDED-FOR" => $ip,
//                "CLIENT-IP" => $ip,
//
//            ));
        $referClient->setUri("http://vote.runsky.com/2014/09/yifangdl/index.php?app=index&act=zan");
        $referClient->setParameterPost(
            "id", "034");
        $referClient->setParameterPost(
            "zan_rand", $zan_rand
        );
        $response = $referClient->request("POST");
        if($response->getStatus() == "200"){
            $message = $response->getBody() . "\n";
            var_dump($referClient->getHeader("CLIENT-IP"));
            $message .= "===========================================================\n";
            echo $message . "\n";
        }else{
            $error_count++;
            $message .= "vote failed. Message:\n" . $response->getBody() . "\n";
            echo $message . "=========================================================\n";
        }
    }catch (Exception $e){
        echo $message . "\tEXCEPTION: " . $e->getMessage();
        continue;
    }

    sleep(rand(50, 200));
}
echo "failed $error_count \n";

function getRandChar($body){
    preg_match("/zan_rand=(.+)'/", $body, $matches);
    return $matches[1];

}


