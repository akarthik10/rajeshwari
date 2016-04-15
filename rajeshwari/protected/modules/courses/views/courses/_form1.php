


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'courses-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p style="padding-left:20px;"><?php echo Yii::t('courses','Fields with');?><span class="required">*</span><?php echo Yii::t('courses',' are required.');?></p>

	<?php 

	echo $form->errorSummary($model); ?>
    
    <h3 style="padding-left:20px;"><?php echo Yii::t('courses','Course');?></h3>
    <div style="padding:0 0 0 20px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php echo $form->labelEx($model,'course_name'); ?></td>
    <td width="3%">&nbsp;</td>
    <td ><?php echo $form->textField($model,'course_name',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'course_name'); ?></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $form->labelEx($model,'code'); ?></td>
    <td>&nbsp;</td>
    <td><?php echo $form->textField($model,'code',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'code'); ?></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $form->labelEx($model,'section_name'); ?></td>
    <td>&nbsp;</td>
    <td><?php echo $form->textField($model,'section_name',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'section_name'); ?></td>
  </tr>
   <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

    <tr>
    <td><?php echo $form->labelEx($model,'start_date'); ?></td>
    <td>&nbsp;</td>
    <td><?php $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
      if($settings!=NULL)
      {
        $date=$settings->dateformat;
    
    
      }
      else
        $date = 'dd-mm-yy'; 
          
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                //'name'=>'Students[admission_date]',
                'model'=>$model,
                'attribute'=>'start_date',
                // additional javascript options for the date picker plugin
                'options'=>array(
                  'showAnim'=>'fold',
                  'dateFormat'=>$date,
                  'changeMonth'=> true,
                  'changeYear'=>true,
                  'yearRange'=>'1900:'
                ),
                'htmlOptions'=>array(
                  'style'=>'height:20px;'
                ),
              ));?>
    <?php echo $form->error($model,'start_date'); ?></td>
  </tr>

   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

<tr>
    <td><?php echo $form->labelEx($model,'end_date'); ?></td>
    <td>&nbsp;</td>
    <td><?php $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
      if($settings!=NULL)
      {
        $date=$settings->dateformat;
    
    
      }
      else
        $date = 'dd-mm-yy'; 
          
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                //'name'=>'Students[admission_date]',
                'model'=>$model,
                'attribute'=>'end_date',
                // additional javascript options for the date picker plugin
                'options'=>array(
                  'showAnim'=>'fold',
                  'dateFormat'=>$date,
                  'changeMonth'=> true,
                  'changeYear'=>true,
                  'yearRange'=>'1900:'
                ),
                'htmlOptions'=>array(
                  'style'=>'height:20px;'
                ),
              ));?>
    <?php echo $form->error($model,'end_date'); ?></td>
  </tr>

   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php //echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save',array('class'=>'formbut')); ?>
         <?php	echo CHtml::ajaxSubmitButton(Yii::t('courses','Save'),CHtml::normalizeUrl(array('courses/Edit&val1='.$val1,'render'=>false)),array('success'=>'js: function(data) {
                       $("#jobDialog11").dialog("close");  window.location.reload();
					   alert("'.Yii::t('courses','Course Updated Successfully.').'");
                    }'),array('id'=>'closeJobDialog12','name'=>'Submit')); ?></td>
  </tr>
 <?php $this->renderPartial('_flash',array('model'=>$model,'id'=>jobDialog)); ?>
</table>
</div>
	<div class="row">
		<?php //echo $form->labelEx($model,'is_deleted'); ?>
		<?php echo $form->hiddenField($model,'is_deleted'); ?>
		<?php echo $form->error($model,'is_deleted'); ?>
	</div>

	<div class="row">
   
		<?php //echo $form->labelEx($model,'created_at')
  
		 echo $form->hiddenField($model,'created_at'); ?>

		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->hiddenField($model,'updated_at',array('value'=>date('d-m-Y'))); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div>

  
    
    <!-- Batch Form Ends -->
	<div style="padding:0px 0 0 0px; text-align:left">
		
	</div>

<?php $this->endWidget(); ?>
