<div class="formCon">

<div class="formConInner">

<?php
if(isset($_REQUEST['id']) and isset($_REQUEST['elective']))
{
	
		$posts = StudentElectives::model()->findAll("elective_id=:x and status=:y", array(':x'=>$_REQUEST['elective'],':y'=>1));
		//$posts=Students::model()->findAll("batch_id=:x and is_active=:y and is_deleted=:z", array(':x'=>$_REQUEST['id'],':y'=>1,':z'=>0));
	
  
  


    ?>
    <?php if($posts!=NULL)
    { ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'exam-scores-form',
	'enableAjaxValidation'=>false,
)); ?>

	<h3><?php echo Yii::t('examination','Enter Exam Scores here:');?></h3>
    <?php echo $form->hiddenField($model,'exam_id',array('value'=>$_REQUEST['examid'])); ?>
	
    <div class="tableinnerlist">
<table width="95%" cellspacing="0" cellpadding="0">
<?php $i=1;
	  $j=0;
	  foreach($posts as $posts_1)
	  { 
	  	$student = Students::model()->findByAttributes(array('id'=>$posts_1->student_id));
	   $checksub = ExamScores::model()->findByAttributes(array('exam_id'=>$_REQUEST['examid'],'student_id'=>$student->id));
	   if($checksub==NULL)
	   {
	  if($j==0)
			  {?>
              
              <tr>
              <th><?php echo Yii::t('examination','Student Name');?></th>
              <th><?php echo Yii::t('examination','Marks');?></th>
              <th><?php echo Yii::t('examination','Remarks');?></th>
            
              
              </tr>
              
              
              
              <?php $j++;} ?>
	<tr>
		
		<td><?php echo $student->first_name.' '.$student->middle_name.' '.$student->last_name;?>
		
		
		<?php echo $form->hiddenField($model,'student_id[]',array('value'=>$student->id,'id'=>$student->id)); ?></td>
		

	
		<td><?php echo $form->textField($model,'marks[]',array('size'=>7,'maxlength'=>3,'id'=>$student->id)); ?></td>
        
        <td><?php echo $form->textField($model,'remarks[]',array('size'=>30,'maxlength'=>255,'id'=>$student->id)); ?></td>
        
	</tr>	

	
		<?php echo $form->hiddenField($model,'grading_level_id'); ?>
		

	
		<?php //echo $form->hiddenField($model,'is_failed'); ?>
		

	<?php echo $form->hiddenField($model,'created_at',array('value'=>date('Y-m-d')));
		  echo $form->hiddenField($model,'updated_at',array('value'=>date('Y-m-d'))); ?>
		
<?php  $i++;}}?>
	</table>

<br />
<?php if($i==1)
	  {
		 
		 echo '<div class="notifications nt_green">'.'<i>'.Yii::t('examination','Exam Score Entered For All Students').'</i></div>'; 
		 
		 $allscores = ExamScores::model()->findAllByAttributes(array('exam_id'=>$_REQUEST['examid']));
		 $sum=0;
		 foreach($allscores as $allscores1)
		 {
			$sum=$sum+$allscores1->marks;
		 }
		 $avg=$sum/count($allscores);
		 echo '<div class="notifications nt_green">'.Yii::t('examination','Class Average = ').$avg.'</div>';
		 echo '<div style="padding-left:10px;">';
		 echo CHtml::link('<img src="images/pdf-but.png" />', array('examScores/pdf','id'=>$_REQUEST['id'],'examid'=>$_REQUEST['examid']),array('target'=>"_blank"));
		 
			 echo '</div>';
	  }
	  ?>
</div>

	<div align="left">
		<?php if($i!=1) echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'formbut')); ?>
	</div>

<?php $this->endWidget(); ?>
<?php }
	else{
		echo '<i>'.Yii::t('examination','No Students In This Batch').'</i>';
		 } ?>

</div></div><!-- form -->


<?php 
	$checkscores = ExamScores::model()->findByAttributes(array('exam_id'=>$_REQUEST['examid']));
	if($checkscores!=NULL)
	{?>
   
    
    <?php $model1=new ExamScores('search');
	      $model1->unsetAttributes();  // clear any default values
		  if(isset($_GET['examid']))
			$model1->exam_id=$_GET['examid'];
	     
		 
		  ?>
          <h3> <?php echo Yii::t('examination','Scores');?></h3>
      <div style="position:relative">    
    <div class="edit_bttns" style="width:250px; top:-10px; right:-123px;">
    <ul>
    <li>
    <?php echo CHtml::link('<span>'.Yii::t('examination','Clear All Scores').'</span>', array('examScores/deleteall','id'=>$_REQUEST['id'],'examid'=>$_REQUEST['examid']),array('class'=>'addbttn last','confirm'=>Yii::t('examination','Are You Sure? All Scores will be deleted.')));?>
    </li>
    
    </ul>
    <div class="clear"></div>
    </div>
   </div>
          <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'exam-scores-grid',
	'dataProvider'=>$model1->search(),
	'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
 	'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
	'columns'=>array(
		
		
		array(
		    'header'=>Yii::t('examination','Student Name'),
			'value'=>array($model,'studentname'),
			'name'=> 'firstname',
            'sortable'=>true,

		
		),
		
		'marks',
		array(
			'header'=>Yii::t('examination','Grades'),
			'value'=>array($model,'getgradinglevel'),
			'name'=> 'grading_level_id',
		),
		'remarks',
		//'is_failed',
		/*
		'grading_level_id',
		array(
		    'name'=>'subject_id',
			'value'=>array($model,'subjectname')
		
		),
		'minimum_marks',
		'grading_level_id',
		'weightage',
		'event_id',
		'created_at',
		'updated_at',
		*/
		array(
			'class'=>'CButtonColumn',
			'buttons' => array(
                                                     
														'update' => array(
                                                        'label' => 'update', // text label of the button
														
                                                        'url'=>'Yii::app()->createUrl("/courses/examScores/update", array("sid"=>$data->id,"examid"=>$data->exam_id,"id"=>$_REQUEST["id"]))', // a PHP expression for generating the URL of the button
                                                      
                                                        ),
														
                                                    ),
													'template'=>'{update} {delete}',
													'afterDelete'=>'function(){window.location.reload();}'
													
		),
		
	),
)); echo '</div></div>';}
else
{
	echo '<div class="notifications nt_red">'.'<i>'.Yii::t('examination','No Scores Updated').'</i></div>'; 
	}?>
	<?php }
	else
    {
	echo '<div class="notifications nt_red">'.'<i>'.Yii::t('examination','Nothing Found').'</i></div>'; 
	}?>
	
	
	