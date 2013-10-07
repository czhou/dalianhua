<?php
class My_Redis
{
    public static function getInstance($newConnection = FALSE){
    	$redisConfig = Zend_Registry::get("config");
    	$redis = new Redis();
    	if ($newConnection === true) {
    		$redis->connect($redisConfig['redis']['host'], $redisConfig['redis']['port']);
    	}else{
    		$redis->pconnect($redisConfig['redis']['host'], $redisConfig['redis']['port']);
    	}
    	
    	return $redis;
    }
}