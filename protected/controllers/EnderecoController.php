<?php

/**
 * Created by PhpStorm.
 * User: agnaldo
 * Date: 3/13/16
 * Time: 7:17 PM
 */
class EnderecoController  extends Controller
{

	public function actionIndex ()
	{
		$dataProvider = new CActiveDataProvider('Endereco');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));

	}

	public function actionNew ()
	{
		$model = new Endereco();

		if (isset($_POST['Endereco']))
		{
			$model->attributes=$_POST['Endereco'];
			if ($model->save())
				$this->redirect(array('index'));
		}

		$this->render('new',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Endereco']))
		{
			$model->attributes=$_POST['Endereco'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


	public function actionDelete ($id)
	{
		if ($this->loadModel($id)->delete());
		{
			$this->redirect(array('index'));
		}
	}



	public function loadModel($id)
	{
		$model=Endereco::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}