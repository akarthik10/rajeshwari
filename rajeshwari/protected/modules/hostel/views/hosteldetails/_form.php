<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'hosteldetails-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<div class="formCon">
<div class="formConInner">
	<table width="50%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php echo $form->labelEx($model,Yii::t('hostel','hostel_name')); ?></td>
    <td>&nbsp;</td>
    <td><?php echo $form->textField($model,'hostel_name',array('size'=>20)); ?>
		<?php echo $form->error($model,'hostel_name'); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $form->labelEx($model,Yii::t('hostel','Address')); ?></td>
    <td>&nbsp;</td>
    <td><?php echo $form->textField($model,'address',array('size'=>20)); ?>
		<?php echo $form->error($model,'address'); ?></td>
  </tr>

</table>


	<div style="padding:20px 0 0 0px;">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('hostel','Create') : Yii::t('hostel','Save'),array('class'=>'formbut')); ?>
	</div>
    </div>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->