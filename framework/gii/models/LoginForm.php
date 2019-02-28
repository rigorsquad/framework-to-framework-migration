<?php

OldYii::import('gii.components.UserIdentity');

class LoginForm extends CFormModel
{
	public $password;

	private $_identity;

	public function rules()
	{
		return array(
			array('password', 'required'),
			array('password', 'authenticate'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 * @param string $attribute the name of the attribute to be validated.
	 * @param array $params additional parameters passed with rule when being executed.
	 */
	public function authenticate($attribute,$params)
	{
		$this->_identity=new UserIdentity('yiier',$this->password);
		if(!$this->_identity->authenticate())
			$this->addError('password','Incorrect password.');
	}

	/**
	 * Logs in the user using the given password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity('yiier',$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			OldYii::app()->user->login($this->_identity);
			return true;
		}
		else
			return false;
	}
}
