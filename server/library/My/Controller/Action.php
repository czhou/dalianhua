<?php
class My_Controller_Action extends Zend_Controller_Action {

	/**
	 * @var Zend_Auth
	 *
	 *
	 *
	 */
	protected $auth = null;

	/**
	 * @var Zend_Auth
	 *
	 *
	 *
	 */
	protected $admin = null;

	/**
	 * @var Zend_Log
	 *
	 *
	 */
	protected $logger = null;

	protected $config = null;

	public function init() {
		$this->logger = Zend_Registry::get("logger");
		require_once 'My/Auth/Admin.php';
		$this->admin = My_Auth_Admin::getInstance();
		require_once 'My/Auth/Customer.php';
		$this->auth = My_Auth_Customer::getInstance();

		$this->view->currentUser = $this->auth->getIdentity ();
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

	public static function pager($currpage, $perpage, $nums, $q, $currPageStyle='', $othersPageStyle='')
	{
		$dp=10;
		$nums = intval($nums);
		$maxPages = ceil($nums/$perpage);
		$pageStart=1;
		if ($maxPages==0) {
			$maxPages = 1;
		}
		if ($currpage>$maxPages) {
			$currpage=$maxPages;
		}
		if ($currpage<=1) {
			$s = "<li class=\"{$currPageStyle}\" style=\"margin-right:10px;\">Prev</li>";
			$pageStart = 1;
			$currpage=1;
			$pageEnd=$dp;
		} else {
			$tmp = $currpage-1;
			$s = "<li><a href=\"".str_replace('{page}', $tmp, $q)."\" class=\"{$othersPageStyle}\">Prev</a></li>";
			$rangeOrder = floor(($currpage-2)/($dp-2));
			$pageStart = $rangeOrder*($dp-2)+1;
			$pageEnd=$pageStart+$dp-1;
		}

		for ($i=$pageStart; $i<=$pageEnd; $i++) {
			if ($i>$maxPages) {
				break;
			}
			if ($i!=$currpage) {
				$s.= '<li><a href="'.str_replace('{page}', $i, $q).'" class="'.$othersPageStyle.'">'.$i.'</a></li>';
			}
			else {
				$s.= '<li class="'.$currPageStyle.'">'.$i.'</li>';
			}
		}

		if ($currpage>=$maxPages) {
			$s.= "<li class=\"{$currPageStyle}\" style=\"margin-left:10px;\">Next</li>";
		} else {
			$tmp = $currpage+1;
			$s.= "<li><a href=\"".str_replace('{page}', $tmp, $q)."\" class=\"{$othersPageStyle}\">Next</a></li>";
		}
		if ($maxPages > 1) {
			$s.='<li><form method="post" action="'.str_replace('&page={page}', "", $q).'"><input value="" type="text" name="page" size="1" /><input type="submit" value="Go" /></form></a>';
		}

		return $s;
	}
}