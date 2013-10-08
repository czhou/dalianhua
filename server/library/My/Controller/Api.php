<?php
class My_Controller_Api extends Zend_Controller_Action {

	/**
	 * @var Zend_Auth
	 *
	 *
	 *
	 */
	protected $auth = null;


	/**
	 * @var Zend_Log
	 *
	 *
	 */
	protected $logger = null;

	protected $config = null;

	public function init() {
		$this->logger = Zend_Registry::get("logger");
		

		$this->view->logger = $this->logger;

		$this->config = Zend_Registry::get("config");
		$this->view->siteInfo = $this->config["site"];

		$this->view->isAppleDevice = $this->isRequestFromAppleDevice();
	}

	public function isRequestFromAppleDevice(){
		$Apple = array();
		$Apple['UA'] = $_SERVER['HTTP_USER_AGENT'];
		$Apple['Device'] = false;
		$Apple['Types'] = array('iPhone', 'iPod', 'iPad');
		foreach ($Apple['Types'] as $d => $t) {
			$Apple[$t] = (strpos($Apple['UA'], $t) !== false);
			$Apple['Device'] |= $Apple[$t];
		}
		return $Apple['Device'];
	}

	public function error($msg) {
		Zend_Layout::getMvcInstance ()->setLayout ( "layout" );
		$this->view->title = "出错啦！";
		$this->view->message = $msg;
		if (isset($msg["http_response_code"]) && is_int($msg["http_response_code"])){
			$this->_response->setHttpResponseCode($msg["http_response_code"]);
		}

		$this->renderScript('error/message.phtml');
		return ;
	}

	public function succeed($msg) {
		Zend_Layout::getMvcInstance ()->setLayout ( "index.layout" );
		$this->view->title = "成功啦！";
		$this->view->message = $msg;
		$this->renderScript('error/message.phtml');
		return ;
	}

}