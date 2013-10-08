<?php

class Form_Accompaniment extends My_Form
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


        $name = new Zend_Form_Element_Text("name");
        $name->setLabel("伴奏名字：");
        $name->addFilter(new Zend_Filter_StringTrim());
        $this->addElement($name, "name");

        $base_price = new Zend_Form_Element_Text("price");
        $base_price->setLabel("价格：");
        $basePriceValidator = new Zend_Validate_Int();
        $base_price->addValidator($basePriceValidator);
        $this->addElement($base_price, "price");

        $artist = new Zend_Form_Element_Text("artists");
        $artist->setLabel("艺术家：");
        //$artistValidator = new Zend_Validate_Alnum(true);
        //$artist->addValidator($artistValidator);
        $artist->addFilter(new Zend_Filter_StringTrim());
        $this->addElement($artist, "artists");

        $tags = new Zend_Form_Element_Text("tags");
        $tags->setLabel("标签：");
        //$tagValidator = new Zend_Validate_Alnum(true);
        //$tags->addValidator($tagValidator);
        $tags->addFilter(new Zend_Filter_StringTrim());
        $this->addElement($tags, "tags");


        $file = new Zend_Form_Element_File("accompaniment");
        $file->setLabel("伴奏文件：")->setRequired(true);
        $file->setDestination(My_Music::getStoragePath()."/".date("Ym"));
        $mediaValidator = new Zend_Validate_File_Extension(array("wav", "mp3"));
        $file->setMaxFileSize(1024 * 1024 * 20);
        $file->addValidator($mediaValidator)->addValidator(new My_Validate_MusicMd5Exists());

        $this->addElement($file, "accompaniment");

        $is_stereo = new My_Form_Element_Radio("is_stereo");
        $is_stereo->setLabel("是否立体声：");
        $is_stereo->addMultiOption(1, "是")->addMultiOption(0, "否");
        $is_stereo->addValidator(new Zend_Validate_Int());
        $is_stereo->setSeparator("&nbsp;");
        $this->addElement($is_stereo);

        $has_melody = new My_Form_Element_Radio("has_melody");
        $has_melody->setLabel("是否带主旋律：");
        $has_melody->addMultiOption(1, "是")->addMultiOption(0, "否");
        $has_melody->addValidator(new Zend_Validate_Int());
        $has_melody->setSeparator("&nbsp;");
        $this->addElement($has_melody);

        $has_harmony = new My_Form_Element_Radio("has_harmony");
        $has_harmony->setLabel("是否带和声伴唱：");
        $has_harmony->addMultiOption(1, "是")->addMultiOption(0, "否");
        $has_harmony->addValidator(new Zend_Validate_Int());
        $has_harmony->setSeparator("&nbsp;");
        $this->addElement($has_harmony);

        $edition = new My_Form_Element_Radio("edition");
        $edition->setLabel("伴奏版本：");
        $edition->addMultiOption(2, "改编版")->addMultiOption(1, "制作版")->addMultiOption(0, "原版");
        $edition->addValidator(new Zend_Validate_Int());
        $edition->setSeparator("&nbsp;");
        $this->addElement($edition);

        $status = new My_Form_Element_Radio("status");
        $status->setLabel("销售状态：");
        $status->addMultiOption(1, "销售中")->addMultiOption(0, "暂不销售");
        $status->addValidator(new Zend_Validate_Int());
        $status->setSeparator("&nbsp;");
        $this->addElement($status);

        $is_recommended = new My_Form_Element_Radio("is_recommended");
        $is_recommended->setLabel("是否推荐：");
        $is_recommended->addMultiOption(1, "是")->addMultiOption(0, "否");
        $is_recommended->addValidator(new Zend_Validate_Int());
        $is_recommended->setSeparator("&nbsp;");
        $this->addElement($is_recommended);


        $intro = new Zend_Form_Element_Textarea("intro");
        $intro->setLabel("介绍：");
        $intro->setAttrib("rows", "5");
        $this->addElement($intro, "intro");




        $submit = new Zend_Form_Element_Submit("提交");
        $submit->setAttrib("class", "btn");
        $this->addElement($submit, "submit");

        $this->setElementDecorators($this->elementDecorators);
        $file->setDecorators($this->fileElementDecorators);
        $submit->setDecorators($this->buttonDecorators);


    }


}

