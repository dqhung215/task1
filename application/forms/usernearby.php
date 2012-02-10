<?php

class Application_Form_usernearby extends Zend_Form
{

	public function init()
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
