<?php
/* @var $this CubeSummationController */
/* @var $model CubeSummation */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cube-summation-procesar-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'textArea'); ?>
		<?php echo $form->textArea($model, 'textArea', array('maxlength' => 300, 'rows' => 15, 'cols' => 50)); ?>
		<?php echo $form->error($model,'textArea'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Enviar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
	<div>
		<?php print_r(Yii::app()->session['res']); ?>
	</div>
