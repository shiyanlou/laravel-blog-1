<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;

class User extends Eloquent implements UserInterface {
	use UserTrait;

	protected $table = 'users';
	protected $hidden = array('password', 'remember_token');
	protected $guard = array('email', 'password');
}