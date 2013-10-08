<?php

class ApiController extends My_Controller_Api
{

    public function init(){
    	parent::init();
    	$bootstrap = $this->getInvokeArg('bootstrap');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(TRUE);
    }
    
    private function sendResponse($content){
    	$this->getResponse()
    	->setHeader('Content-Type', 'text/json')
    	->setBody($content)
    	->sendResponse();
    	exit;
    }


    public function indexAction(){
    	

    }
    
    public function getNextQuestionAction(){
    	$questionTable = new Model_DbTable_Questions();
    	$answerTable = new Model_DbTable_Answers();
    	$question = $questionTable->fetchRow("id = 2");
    	$answers = $answerTable->fetchAll("question_id = 2");
    	$data["question"] = $question->term . rand(10, 10000);
    	$data["question_id"] = $question->id;
    	$data["audio"] = "http://dalianhua.uiu.cc" . $question->audio;
    	foreach ($answers as $answer){
    		$theAnswer["content"] = $answer->option_content;
    		$theAnswer["correct"] = $answer->is_correct?true:false;
    		$data["answers"][] = $theAnswer;
    	}
    	$this->sendResponse(Zend_Json::encode($data));
    	
    }
    
    public function answerAction(){
    	$this->sendResponse();
    	 
    }


}





















