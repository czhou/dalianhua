<?php

class ApiController extends My_Controller_Action
{

    public function init()
    {
    	parent::init();
    }


    public function indexAction()
    {
    	

    }
    
    public function getNextQuestionAction(){
    	Zend_Layout::getMvcInstance()->disableLayout();
    	$questionTable = new Model_DbTable_Questions();
    	$answerTable = new Model_DbTable_Answers();
    	$question = $questionTable->fetchRow("id = 2");
    	$answers = $answerTable->fetchAll("question_id = 2");
    	$data["question"] = $question->term . rand(10, 10000);
    	$data["question_id"] = $question->id;
    	$data["audio"] = "http://dalianhua.uiu.cc" . $question->audio;
    	foreach ($answers as $answer){
    		$theAnswer["content"] = $answer->option_content;
    		$theAnswer["correct"] = $answer->is_correct;
    		$data["answers"][] = $theAnswer;
    	}
    	
    	echo Zend_Json::encode($data);
    	
    }


}





















