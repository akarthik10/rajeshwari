<div class="formCon">
<div class="formConInner" style="width:50%">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-attentance-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('attendance','Specify Reason') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php
		 //echo $form->labelEx($model,'student_id'); ?>
		<?php echo $form->hiddenField($model,'student_id',array('value'=>$emp_id)); ?>
		<?php echo $form->error($model,'student_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'date'); ?>
		<?php echo $form->hiddenField($model,'date',array('value'=>$year.'-'.$month.'-'.$day)); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reason'); ?>
		<?php echo $form->textField($model,'reason',array('size'=>60,'maxlength'=>120)); ?>
		<?php echo $form->error($model,'reason'); ?>
	</div>
<br />
	<div class="row buttons">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
         <?php echo CHtml::ajaxSubmitButton(Yii::t('attendance','Save'),CHtml::normalizeUrl(array('StudentAttentance/Addnew','render'=>false)),array('success'=>'js: function(data) {
						$("#td'.$day."_".$emp_id.'").text("");
						$("#jobDialog_a'.$day.'_'.$emp_id.'").html("<span class=\"abs\"></span>","");
						$("#jobDialog'.$day.'_'.$emp_id.'").dialog("close");
						window.location.reload();
                    }'),array('id'=>'closeJobDialog'.$day.$emp_id,'name'=>'save')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
</div><!-- form -->