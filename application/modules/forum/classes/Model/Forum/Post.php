<?php defined('SYSPATH') OR die('No direct script access.');

class Model_Forum_Post extends ORM {

	protected $_created_column = array(
		'column' => 'created',
		'format' => TRUE
	);

	protected $_belongs_to = array(
		'topic' => array(
			'model' => 'Forum_Topic',
		)
	);

	public function rules()
	{
		return array(
			'content' => array(
				array('not_empty'),
				array('max_length', array(':value', 1024)),
				array(array($this, 'unique'), array('name', ':value')),
			),
		);
	}

	public function create_post($values, $expected)
	{
		// Validation for topic
		$extra_validation = Validation::Factory($values)
			->rule('topic_id', 'Model_Forum_Category::topic_exists');

		return $this->values($values, $expected)
			->create($extra_validation);
	}

	static public function post_exists($id)
	{
		$post = ORM::factory('Forum_Post', $id);

		return $post->loaded();
	}

}
