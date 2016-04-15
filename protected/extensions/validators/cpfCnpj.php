<?php

class cpfCnpj extends CValidator
{
	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel the data object being validated
	 * @param string the name of the attribute to be validated.
	 */
	protected function validateAttribute( $object, $attribute ){
		if($this->verificaTipo($object->$attribute) == 'CPF')
		{
			if(!$this->validaCPF($object->$attribute))
				$this->addError($object, $attribute, Yii::t('yii','CPF inválido.'));
		}
		elseif($this->verificaTipo($object->$attribute) == 'CNPJ')
		{
			if(!$this->validaCNPJ($object->$attribute))
				$this->addError($object, $attribute, Yii::t('yii','CNPJ inválido.'));
		}
		else
		{
			$this->addError($object, $attribute, Yii::t('yii','Documento inválido.'));
		}
	}

	public function clientValidateAttribute($object,$attribute) {
	}

	// Função que verifica se é CPF ou CNPJ
	private function verificaTipo($numero)
	{
		$numero = preg_replace('/[^0-9]/', '', $numero);

		if (strlen($numero) == 11)
		{
			return 'CPF';
		}
		elseif (strlen($numero) == 14)
		{
			return 'CNPJ';
		}
		else
		{
			return null;
		}
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
