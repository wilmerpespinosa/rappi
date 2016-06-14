<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $T;
	public $N;
	public $M;
	public $W;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('T', 'numerical','integerOnly'=>true,'min'=>1,'max'=>50),
			array('N', 'numerical','integerOnly'=>true,'min'=>1,'max'=>100),
			array('M', 'numerical','integerOnly'=>true,'min'=>1,'max'=>1000),
			array('W', 'numerical','integerOnly'=>true),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			/*nombres de variables a mostrar*/
		);
	}
}