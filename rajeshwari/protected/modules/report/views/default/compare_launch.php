<?php

$baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile($baseUrl.'/js/datatables/jquery.dataTables.min.js');
  $cs->registerCssFile($baseUrl.'/js/datatables/jquery.dataTables.min.css');


$criteria  = new CDbCriteria;
$criteria ->compare('is_deleted',0);
		          $criteria->order = 'start_date DESC'; 
?>
<div class="comparebg" style="padding: 20px;">
<?php
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-form',
	'enableAjaxValidation'=>false,
)); 


?>

<h1><?php echo Yii::t('report','Subject Comparison Report');?></h1>

<table class="comparetable">
<tr>
<td>
<?php echo Yii::t('report','Batch 1');?> <br />
<?php echo CHtml::dropDownList('batch1','',CHtml::listData(Batches::model()->findAll($criteria),'id','coursename'),array('prompt'=>'Select',
					'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('/report/default/batch'),
					'update'=>'#exam_id1',
					'data'=>'js:"batch="+$(this).val()',),'style'=>'width:270px;','options' => array($request['batch1']=>array('selected'=>true)))); ?>
</td>
<td>
<?php echo Yii::t('report','Batch 2');?> <br />
<?php echo CHtml::dropDownList('batch2','',CHtml::listData(Batches::model()->findAll($criteria),'id','coursename'),array('prompt'=>'Select',
					'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('/report/default/batch'),
					'update'=>'#exam_id2',
					'data'=>'js:"batch="+$(this).val()',),'style'=>'width:270px;','options' => array($request['batch2']=>array('selected'=>true)))); 
?>
</td>
</tr>
<?php

$data=ExamGroups::model()->findAll('batch_id=:x',array(':x'=>$request['batch1']));
?>
<tr>
<td>
<?php echo Yii::t('report','Exam 1');?> <br />
<?php echo CHtml::dropDownList('exam_id1','',CHtml::listData($data,'id','name'),array('prompt'=>'Select',
					'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('/report/default/exam1'),
					'update'=>'#subject1',
					'data'=>'js:"exam_id="+$(this).val()',),'style'=>'width:270px;','options' => array($request['exam_id1']=>array('selected'=>true))));
?>
</td>
<td>
<?php echo Yii::t('report','Exam 2');?> <br />
<?php $data=ExamGroups::model()->findAll('batch_id=:x',array(':x'=>$request['batch2'])); 
echo CHtml::dropDownList('exam_id2','',CHtml::listData($data,'id','name'),array('prompt'=>'Select',
					'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('/report/default/exam2'),
					'update'=>'#subject2',
					'data'=>'js:"exam_id="+$(this).val()',),'style'=>'width:270px;','options' => array($request['exam_id2']=>array('selected'=>true)))); ?>
</td>
</tr>

<tr>
<td>

<?php

echo Yii::t('report','Gender 1'); echo '<br />'; 
echo CHtml::radioButtonList('gender1',$request['gender1'],array('M'=>'Male','F'=>'Female', 'B'=>'Both'),array('separator'=>'')); 
echo '<br />'; 
echo '<br />'; 
 
echo Yii::t('report','Subjects 1'); echo '<br />'; 
$data=Exams::model()->findAll('exam_group_id=:x',array(':x'=>$request['exam_id1']));
					$subjects = array();
						$subject_l = array();
						foreach ($data as $datai) {
							$subjects[] = $datai->subject_id;
							// echo $datai->id;
							$sub = Subjects::model()->findAll('id=:x',array(':x'=>$datai->subject_id));
							$subject_l = array_merge($sub, $subject_l);
							
						}
						$data=CHtml::listData($subject_l,'id','name'); ?>

						<input id="Subjects1_selectall" class="subjects" value="" type="checkbox" name="s1" onclick='$(".subjects1").prop("checked", $(this).prop("checked"));'>
						<label for="Subjects1_selectall">Select All</label>
						<br />
						<?php 
						echo '<div id="subject1" style="max-height: 100px; overflow-y: auto;">';
						$model = Subjects::model();
						$model->id = $request['Subjects1']['id']; ?>
						


						<?php
					echo CHtml::activeCheckBoxList($model, 'id',$data, array( 'id'=>'Subjects1[id]', 'name'=>'Subjects1[id]', 'class'=>'subjects1'));
					echo '</div>';
?>
</td>
<td>
<?php

echo Yii::t('report','Gender 2'); echo '<br />'; 
echo CHtml::radioButtonList('gender2',$request['gender2'],array('M'=>'Male','F'=>'Female', 'B'=>'Both'),array('separator'=>'')); 
echo '<br />'; 
echo '<br />'; 

echo Yii::t('report','Subjects 2'); echo '<br />'; 
$data=Exams::model()->findAll('exam_group_id=:x',array(':x'=>$request['exam_id2']));
					$subjects = array();
						$subject_l = array();
						foreach ($data as $datai) {
							$subjects[] = $datai->subject_id;
							// echo $datai->id;
							$sub = Subjects::model()->findAll('id=:x',array(':x'=>$datai->subject_id));
							$subject_l = array_merge($sub, $subject_l);
							
						}
						$data=CHtml::listData($subject_l,'id','name'); ?>

						<input id="Subjects2_selectall" class="subjects" value="" type="checkbox" name="s2" onclick='$(".subjects2").prop("checked", $(this).prop("checked"));'>
						<label for="Subjects2_selectall">Select All</label>
						<br />

<?php 
						echo '<div id="subject2" style="max-height: 100px; overflow-y: auto;">';
						$model = Subjects::model();
						$model->id = $request['Subjects2']['id']; ?>



						<?php 
					echo CHtml::activeCheckBoxList($model, 'id',$data, array( 'id'=>'Subjects2[id]', 'name'=>'Subjects2[id]','class'=>'subjects2'));
					echo '</div>';
?>
</td>
</tr>
</table>

<div style="margin-top:10px;"><?php echo CHtml::submitButton( 'Submit',array('name'=>'search','class'=>'formbut')); ?></div> 

<?php if($request['Subjects2']['id'] != null) { ?>
<div style="">
<table class="dttholder">
<tr>
<td><?php printTable($request['batch1'], $request['exam_id1'], $request['Subjects1']['id'], $request['gender1'], "dtt1"); ?></td>
<td><?php printTable($request['batch2'], $request['exam_id2'], $request['Subjects2']['id'], $request['gender2'], "dtt2"); ?></td>
</tr>
</table>
</div>
<?php } ?>


</div>
 

 <?php $this->endWidget(); ?>


 <?php


 function printTable($batch_id, $exam_id, $subjects, $gender, $tid) {

	$criteria = new CDbCriteria;
	$criteria->condition='exam_group_id LIKE :match';
	$criteria->params = array(':match' => $exam_id.'%');
	$criteria->order = 'id ASC';
	$list = Exams::model()->findAll($criteria);
    ?>
    <div class="tablebx" style="background: #fff;">
    	<!-- Assessment Table -->
    	<table id="<?php echo $tid; ?>">
        	<!-- Table Headers -->
        	<thead>
        	<tr class="tablebx_topbg">
                <td style="width:90px;"><?php echo Yii::t('students','Admn No.');?></td>
                <td style="width:auto;min-width:100px;"><?php echo Yii::t('students','Name');?></td>
                <?php
				foreach($list as $exam) 
				{
							$subject=Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));	
							if(!in_array($subject->id, $subjects))	{continue;}
				?>
                	<td style="width:auto; min-width:80px; text-align:center;"><?php  echo @$subject->name; ?></td>
                <?php
				} ?>
				<td style="width:auto;min-width:100px;"><?php echo Yii::t('students','Total');?></td>
				<td style="width:auto;min-width:100px;"><?php echo Yii::t('students','Percent');?></td>
				<td style="width:auto;min-width:100px;"><?php echo Yii::t('students','Result');?></td>
				
            </tr>
            </thead>
            <!-- End Table Headers -->
            <?php
			
            $students = Students::model()->findAllByAttributes(array('batch_id'=>$batch_id,'is_deleted'=>0,'is_active'=>1));
			if(isset($students) and $students!=NULL) // Checking if students are present
			{
				foreach($students as $student) // Creating row corresponding to each student.
				{
					$total = 0;
					$total_max = 0;
					$result = "PASS";
					$grd = 0;
					if($gender != 'B') {
						if($student->gender!= NULL && ($gender == 'M' && $student->gender=='F') || ($gender == 'F' && $student->gender=='M') ) {
							continue;
						}
					}
				?> 
					<tr class=<?php echo $cls; ?> >
						<td>
							<?php echo $student->admission_no; ?>
						</td>
						<td>
							<?php echo CHtml::link(ucfirst($student->first_name).'  '.ucfirst($student->middle_name).'  '.ucfirst($student->last_name),array('/students/students/view','id'=>$student->id)); ?>
						</td>
						<?php
						foreach($list as $exam) // Creating subject column(s)
						{
							if(!in_array($exam->subject_id, $subjects))	{continue;}

						$score = ExamScores::model()->findByAttributes(array('student_id'=>$student->id,'exam_id'=>$exam->id));
						$examgroup = ExamGroups::model()->findByAttributes(array('id'=>$exam->exam_group_id));
						?>
						
						<td>
						<?php
						if($score->marks!=NULL or $score->remarks!=NULL)
						{
							$total += $score->marks;
							$total_max += $exam->maximum_marks;
						?>
							<!-- Mark and Remarks Column -->
							<table align="center" style="border:none;width:auto; min-width:80px;">
								<tr>
									<td style="border:none;<?php if($score->is_failed == 1){?>color:#F00;<?php }?>">
										<?php 
										 $grades = GradingLevels::model()->findAllByAttributes(array('batch_id'=>$batch_id));
			                                             $t = count($grades);

														 if($examgroup->exam_type == 'Marks') {  
														 if($score->marks==0) { echo "A"; }
														 else { echo $score->marks;  }
														 if($score->is_failed == 1){ $result = 'FAIL';}
														 } 
														  else if($examgroup->exam_type == 'Grades') {
														  	$grade_value = 'No Grade';
														  	$current_max = 0;
														  	if($score->is_failed == 1){ $result = 'FAIL';}
														   foreach($grades as $grade)
																{
																	
																 if($grade->min_score <= floor(($score->marks/$exam->maximum_marks)*100) )
																	{	if($grade->min_score > $current_max) {
																			$grade_value =  $grade->name;
																			$current_max = $grade->min_score;
																		}
																		
																	}
																	else
																	{
																		$t--;
																		
																		continue;
																		
																	}
																	$grd = 1;
																
																
																}
																echo $grade_value ;
																if($t<=0) 
																	{
																		$glevel = " No Grades" ;
																	} 


																
																} 
														   else if($examgroup->exam_type == 'Marks And Grades'){
															 foreach($grades as $grade)
																{
																	
																 if($grade->min_score <= $score->marks)
																	{	
																		$grade_value =  $grade->name;
																	}
																	else
																	{
																		$t--;
																		
																		continue;
																		
																	}
																	$grd = 1;
																echo $score->marks . " & ".$grade_value ;
																break;
																
																	
																} 
																if($t<=0) 
																	{
																		echo $score->marks." & No Grades" ;
																	}
																 } 
																 if($grade_value == 'F') {$result = 'FAIL'; }
										?>
									</td>


								</tr>
								
							</table>
							<!-- End Mark and Remarks Column -->
						<?php
						}
						else
						{
							echo '-';
						}
						?>
						</td>
						<?php
						}

						if($grd == 1)
						{
														  	$current_max = 0;
														  	$grade_value = 'No Grade';
														   foreach($grades as $grade)
																{
																	
																 if($grade->min_score <= floor(($total/$total_max)*100) )
																	{	if($grade->min_score > $current_max) {
																			$grade_value =  $grade->name;
																			$current_max = $grade->min_score;
																		}
																		
																	}
																	else
																	{
																		$t--;
																		
																		continue;
																		
																	}
																}
																$grde = $grade_value;
						}



						?>
						<td>
										<?php
										 echo $total; 
										if($grd==1){ echo '('.$grde.')'; } 
										?>
									</td>
									<td>
										<?php $perc = ($total/$total_max)*100; echo number_format($perc, 2, '.', '');?>
									</td>
									<td>
										<?php echo $result; ?>
									</td>
					</tr>
				<?php 
				} // END Creating row corresponding to each student.
  			} // End Checking if students are present
			?>
        	
        </table>
        <!-- End Assessment Table -->
    </div> 

    <script type="text/javascript">
	$(document).ready( function () {

/*
	$("#Subjects1_selectall").change(function(){
		console.log($(".subjects1"));
		$(".subjects1").prop('checked', $(this).prop("checked"));
	});

	$("#Subjects2_selectall").change(function(){
		$(".subjects2").prop("checked", $(this).prop("checked"));
	});

*/
		$("#dtt1").dataTable().fnDestroy();

		$("#dtt2").dataTable().fnDestroy();

	    $('#dtt1').DataTable( {
    		paging: false,
    		searching: false
		} );
		$('#dtt2').DataTable( {
    		paging: false,
    		searching: false
		} );




	} );





    </script>
    <?php
 }


 ?>