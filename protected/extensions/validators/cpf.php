<?php

class cpf extends CValidator
{
	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel the data object being validated
	 * @param string the name of the attribute to be validated.
	 */
	protected function validateAttribute( $object, $attribute ){
		if ( !$this->validaCPF( $object->$attribute ) )
			$this->addError($object, $attribute, Yii::t('yii','{attribute} inválido.'));
	}
	public function clientValidateAttribute($object,$attribute) {
	}

	// Função que valida o CPF
	private function validaCPF($cpf)
	{
		// Verifiva se o número digitado contém todos os digitos
		$cpf = str_pad(preg_replace('/[^0-9_]/', '', $cpf), 11, '0', STR_PAD_LEFT);
		
		// valida número sequencial 1111... 22222 ......
		for ($x=0; $x<10; $x++)
			if ( $cpf == str_repeat($x, 11) )
				return false;
		
		// Verifica se nenhuma das sequências acima foi digitada, caso sim, retorna falso
		if ( strlen($cpf) != 11 )
		{
			return false;
		} else {
			// Calcula os números para verificar se o CPF é verdadeiro
			for ($t = 9; $t < 11; $t++) {
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				
				$d = ((10 * $d) % 11) % 10;
				
				if ($cpf{$c} != $d) {
					return false;
				}
			}
			
			return true;
		}
	}
}
