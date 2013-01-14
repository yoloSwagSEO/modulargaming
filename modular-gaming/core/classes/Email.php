<?php defined('SYSPATH') OR die('No direct script access.');

class Email extends Kohana_Email {

	public static function factory($view = NULL, $message = NULL, $type = NULL)
	{
		return new Email($view);
	}

	public function __construct(Abstract_View_Email $view)
	{
		// Create a new message, match internal character set
		$this->_message = Swift_Message::newInstance();

		$this->subject($view->subject);

		$from = Kohana::$config->load('email.from');
		$this->from($from['email'], $from['name']);

		$html = Kostache_Email::factory();
		$html->set_type('html');
		$this->message($html->render($view), 'text/html');

		$text = Kostache_Email::factory();
		$text->set_type('text');
		$this->message($text->render($view), 'text/plain');
	}

	public function to($email, $name = NULL, $type = 'to')
	{
		$redirect = Kohana::$config->load('email.redirect');

		if ($redirect)
		{
			$email = $redirect;
		}

		return parent::to($email, $name, $type);
	}

}
