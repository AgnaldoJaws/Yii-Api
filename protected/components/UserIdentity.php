<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$record = Api::model()->findByAttributes(array('token'=>$this->username, 'key'=>$this->password, 'status'=>1));
		if($record===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else
		{
			$this->_id=$record->id;
			defined('LOJA_ID') or define('LOJA_ID', $record->idLoja);

			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
}