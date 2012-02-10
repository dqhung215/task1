<?php


class Application_Form_GPS extends Zend_Form
{
    public function init()
    {
        $this->setName('GPSUser');

        $id = new Zend_Form_Element_Text('id');
        $id->setLabel('ID')
           ->setRequired(true)
           ->addFilter('Int')              
               ->addValidator('NotEmpty');

        $nickname = new Zend_Form_Element_Text('nickname');
        $nickname->setLabel('Nickname')
               ->setRequired(true)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
               ->addValidator('NotEmpty');
        
        $age = new Zend_Form_Element_Text('age');
        $age->setLabel('Age')
        	->addFilter('Int')->addValidator('NotEmpty'); 
        
        $latitude = new Zend_Form_Element_Text('latitude');
        $latitude->setLabel('Latitude')
        		 ->addFilter('Int')->addValidator('NotEmpty'); 
        
        $longtitude = new Zend_Form_Element_Text('longtitude');
        $longtitude->setLabel('Longtitude')
        		 ->addFilter('Int')->addValidator('NotEmpty');;
    

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id, $nickname, $age, $latitude, $longtitude,$submit));
    }
    
    public function init2()
    {
    	$this->setName('GetUserNearby');
    
    	$max = new Zend_Form_Element_Text('max');
    	$max->setLabel('Max')
    	->setRequired(true)
    	->addFilter('Int')
    	->addValidator('NotEmpty');
    
    	$latitude = new Zend_Form_Element_Text('latitude');
    	$latitude->setLabel('Latitude')
    	->addFilter('Int')->addValidator('NotEmpty');
    
    	$longtitude = new Zend_Form_Element_Text('longtitude');
    	$longtitude->setLabel('Longtitude')
    	->addFilter('Int')->addValidator('NotEmpty');;
    
    
    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setAttrib('id', 'submitbutton');
    
    	$this->addElements(array($latitude, $longtitude,$max, $submit));
    }
}