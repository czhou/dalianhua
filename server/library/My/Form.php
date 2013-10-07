<?php
class My_Form extends Zend_Form
{
    public $elementDecorators = array(
        'ViewHelper',
        'Errors',
        array('HtmlTag', array('tag' => 'div', 'class' => 'controls')),
        array('Label', array('class' => 'control-label')),
    	array(array('row' => 'HtmlTag'), array('class' => 'control-group')),

    );

    public $buttonDecorators = array(
        array('ViewHelper', array('class' => 'btn')),
    	array('HtmlTag', array('tag' => 'div', 'class' => 'controls'))
    );

    public $fileElementDecorators = array(
    		//'ViewHelper',
    		'File',
    		'Errors',
    		array('HtmlTag', array('tag' => 'div', 'class' => 'controls')),
    		array('Label', array('class' => 'control-label')),
    );

    public $radioElementDecorators = array(
    		'ViewHelper',
    		'Errors',
    		array('HtmlTag', array('tag' => 'div', 'class' => 'controls')),
    		array('Label', array('class' => 'control-label', 'disableFor' => true)),
    		array(array('row' => 'HtmlTag'), array('class' => 'control-group'))
    );


    public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            array('FormElements', $this->elementDecorators),
        	'Form'
        ));
    }
}