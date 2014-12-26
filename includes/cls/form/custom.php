<?php
namespace cls\form;

class custom extends \lib\form{
	public function __construct($type = 'edit'){
		$this->username 	= $this->make('input')		->name("username")	->label('username');
		$this->password 	= $this->make('password')	->name("password")	->label('password');
		$this->submit 		= $this->make('submit')						->label($type);
	}
}
?>