<?php
$this->breadcrumbs=array(
	'Report'=>array('/report'),
	'SMS Attendance Report',
);
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-form',
	'enableAjaxValidation'=>false,
)); ?>




<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    <?php $this->renderPartial('left_side');?>
 </td>
    <td valign="top"> 
    <div class="cont_right">
    <h1><?php echo Yii::t('report','SMS Attendance Report');?></h1>
	<div class="formCon">
     <div class="formConInner">
                              
       </div>



<table width="100%" border="0" cellspacing="0" cellpadding="0" class="s_search">
         <tr>
                <td>&nbsp;</td>
                <td style="width:100px;"><strong><?php echo Yii::t('report','Select Date');?></strong></td>
		<td>&nbsp;</td>
		<td> 
		<?php
$this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'name'=>'datepicker-date-format',    
    'value'=>"Select Date (yy-mm-dd)",
    'options'=>array(        
        'showButtonPanel'=>true,
        'dateFormat'=>'yy-mm-dd',//Date format 'mm/dd/yy','yy-mm-dd','d M, y','d MM, y','DD, d MM, yy'
        'onSelect'=> 'js: function(date) { 
            if(date != "") { 
                document.cookie = "atten_date=" + date ;  
            } 
        }',
    ),
    'htmlOptions'=>array(
        'style'=>''
    ),
    
));?>
		</td>
       
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
		<?php
		 echo CHtml::link('Send SMS', array('/report/default/Sendsms'));
		?>
		</td>
	</tr>
</table>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<?php $this->endWidget(); ?>