<?php

class CubeSummationController extends Controller
{
	public function actionProcesar()
	{
	    $model=new CubeSummation('CubeSummation');
	    Yii::app()->session->clear();

	    if(isset($_POST['CubeSummation']))
	    {
	        $model->attributes=$_POST['CubeSummation'];
	        if($model->validate())
	        {
	            // form inputs are valid, do something here
	            //return;
	        }
	    }
	    $this->render('procesar',array('model'=>$model));
	}
}