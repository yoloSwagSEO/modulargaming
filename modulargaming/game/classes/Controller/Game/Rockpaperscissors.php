<?php defined('SYSPATH') OR die('No direct script access.');


class Controller_Game_Rockpaperscissors extends Abstract_Controller_Game {

	public function action_index()
	{
		$this->view = new View_Game_Rockpaperscissors;
		$game = ORM::factory('Game')
			->where('game_id', '=', 1)
			->where('user_id', '=', $this->user->id)
			->find();
		if ( ! $game->loaded())
		{
			$game = ORM::factory('Game')
				->create_game(
					array(
						'game_id' => 1,
						'user_id' => $this->user->id
					),
					array(
						'game_id',
						'user_id'
					)
				);
		}
		$can_play = $game->can_play();
		$this->view->can_play = $can_play;
		if ($this->request->method() == HTTP_Request::POST AND $can_play)
		{
			try
			{
				$post = $this->request->post();
				if (isset($post['collect']) AND $game->winnings)
				{
					$game->collect_winnings();
					Hint::success('You have collected your winnings');
					$this->redirect(Route::url('game', array('controller' => 'rockpaperscissors')));
				}
				$validation = Validation::factory($post)
   						 ->rule('move', 'not_empty')
   						 ->rule('move', 'in_array', array(':value', array('rock', 'paper', 'scissors')));

				if ($validation->check())
				{
					$play = $this->play_game($post['move'], $game);
					$this->view->play = $play;
				}
			}
			catch (ORM_Validation_Exception $e)
			{
				Hint::error($e->errors('models'));
			}
		}
		$this->view->game = $game;
	}

	private function play_game($choice, $game)
	{
		$win = 0;
    		$choices = array('rock', 'paper', 'scissors');
		$npc = $choices[mt_rand(0, 2)];
		if (($choice == 'rock' AND $npc == 'scissors') OR ($choice == 'paper' AND $npc == 'rock') OR ($choice == 'scissors' AND $npc == 'paper'))
		{
			$win = round($game->winnings * 0.25 + 10);
			$game->winnings = $game->winnings + $win;
		}
		else if ($choice != $npc)
		{
			$game->winnings = 0;
			$game->plays ++;
			$game->last_play = time();
		}
		$game->save();
		return array(
			'player' => $choice,
			'npc'    => $npc,
			'win'    => $win,
			'draw'   => $choice == $npc
		);
	}
}
