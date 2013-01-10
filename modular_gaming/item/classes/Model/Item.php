<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Item extends ORM {

	protected $_belongs_to = array(
		'type' => array(
			'model' => 'Item_type',
			'foreign_key' => 'type_id'
		),
	);

	protected $_load_with = array('type');

	public function rules()
	{
		//@todo validate the command property
		return array(
			'name' => array(
				array('not_empty'),
				array('max_length', array(':value', 50)),
			),
			'description' => array(
				array('not_empty'),
			),
			'image' => array(
				array('not_empty'),
				array('max_length', array(':value', 200)),
			),
			'status' => array(
				array('not_empty'),
				array('in_array', array(':value', array('draft', 'released', 'retired'))),
			),
		);
	}
	
	/**
	 * Create the url to the item's image
	 * @return string
	 */
	public function img(){
		return 'assets/img/items/'.$this->type->img_dir.$this->img;
	}
	
	/**
	 * Check if the item isn't a draft or retired.
	 * @return boolean
	 */
	public function in_circulation(){
		return ($this->status == 'released');
	}

} // End Item Model
