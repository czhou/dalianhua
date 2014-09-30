<?php

class Form_Question extends My_Form
{

    public function init()
    {


    	$this->setAttrib("class", "form-horizontal");
        $id = new Zend_Form_Element_Hidden("id");
        //$id->setLabel("Id: ");
        $id->setValue(0);
        $id->setRequired(true);
        $idValidator = new Zend_Validate_Int();
        $id->addValidator($idValidator);
        $this->addElement($id, "id");


        $name = new Zend_Form_Element_Text("term");
        $name->setLabel("题面：");
        $name->addFilter(new Zend_Filter_StringTrim());
        $this->addElement($name, "term");


        $file = new Zend_Form_Element_File("audio");
        $file->setLabel("录音文件：")->setRequired(true);
        $file->setDestination(My_Music::getStoragePath());
        $mediaValidator = new Zend_Validate_File_Extension(array("mp3"));
        $file->setMaxFileSize(1024 * 1024 * 1);
        $file->addValidator($mediaValidator)->addValidator(new My_Validate_MusicMd5Exists());

        $this->addElement($file, "audio");


        $submit = new Zend_Form_Element_Submit("提交");
        $submit->setAttrib("class", "btn");
        $this->addElement($submit, "submit");

        $this->setElementDecorators($this->elementDecorators);
        $file->setDecorators($this->fileElementDecorators);
        $submit->setDecorators($this->buttonDecorators);


    }


}

