<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Game extends ORM
{

	protected $_table_columns = array(
		'id'          => NULL,
		'game_id'     => NULL,
		'user_id'     => NULL,
		'plays'       => NULL,
		'last_play'   => NULL,
		'winnings'      => NULL
	);

	protected $_belongs_to = array(
		'user' => array(
			'model' => 'User',
		)
	);

	public function can_play()
	{
		if ($this->plays >= 5)
		{
			if ($this->last_play > time() - Date::DAY)
			{
				return FALSE;
			}
			else
			{
				$this->plays = 0;
				$this->save();
			}
		}
		return TRUE;
	}

	public function collect_winnings()
	{
		$points = Kohana::$config->load('items.points');
		$initial_points = $points['initial'];
		$this->user->set_property('points', $this->user->get_property('points', $initial_points) + $this->winnings);
		$this->user->save();
		$this->winnings = 0;
		$this->plays ++;
		$this->last_play = time();
		$this->save();
	}

	public function create_game($values, $expected)
	{
		return $this->values($values, $expected)
			->create();
	}



} // End Game Model
