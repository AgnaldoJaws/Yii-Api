<?php

class cnpj extends CValidator
{
	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel the data object being validated
	 * @param string the name of the attribute to be validated.
	 */
	protected function validateAttribute( $object, $attribute ){
		if ( !$this->validaCNPJ( $object->$attribute ) )
			$this->addError($object, $attribute, Yii::t('yii','{attribute} inválido.'));
	}
	public function clientValidateAttribute($object,$attribute) {
	}
	
	public function validaCNPJ($cnpj)
	{
		if(!empty($cnpj))
		{
			if (strlen($cnpj) <> 18){
				return false;
			}else{
				$soma1 = ($cnpj[0] * 5) +
		
				($cnpj[1] * 4) +
				($cnpj[3] * 3) +
				($cnpj[4] * 2) +
				($cnpj[5] * 9) +
				($cnpj[7] * 8) +
				($cnpj[8] * 7) +
				($cnpj[9] * 6) +
				($cnpj[11] * 5) +
				($cnpj[12] * 4) +
				($cnpj[13] * 3) +
				($cnpj[14] * 2);
				$resto = $soma1 % 11;
				$digito1 = $resto < 2 ? 0 : 11 - $resto;
				$soma2 = ($cnpj[0] * 6) +
		
				($cnpj[1] * 5) +
				($cnpj[3] * 4) +
				($cnpj[4] * 3) +
				($cnpj[5] * 2) +
				($cnpj[7] * 9) +
				($cnpj[8] * 8) +
				($cnpj[9] * 7) +
				($cnpj[11] * 6) +
				($cnpj[12] * 5) +
				($cnpj[13] * 4) +
				($cnpj[14] * 3) +
				($cnpj[16] * 2);
				$resto = $soma2 % 11;
				$digito2 = $resto < 2 ? 0 : 11 - $resto;
				if ( ($cnpj[16] == $digito1) && ($cnpj[17] == $digito2) ){
					return true;
				}else{
					return false;
				}
			}
		} else {
			return true;
		}
	}
}
