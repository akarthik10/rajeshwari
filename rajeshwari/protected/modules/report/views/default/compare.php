<?php
$this->breadcrumbs=array(
	'Report'=>array('/report'),
	'Subject Assessment Report',
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
    <h1><?php echo Yii::t('report','Subject Comparison Report');?></h1>
	<div class="formCon">
     <div class="formConInner">
     <!--
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="s_search">
              <tr>
                <td>&nbsp;</td>
                <td style="width:100px;"><strong><?php echo Yii::t('report','Batch');?></strong></td>
                <td>&nbsp;</td>
                 <?php $criteria  = new CDbCriteria;
		          $criteria ->compare('is_deleted',0);
		          $criteria->order = 'start_date DESC'; ?>
                <td> 
				<?php 
				if($batch_id!=NULL)
				{
					echo CHtml::dropDownList('batch','',CHtml::listData(Batches::model()->findAll($criteria),'id','coursename'),array('prompt'=>'Select',
					'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('/report/default/batch'),
					'update'=>'#exam_id',
					'data'=>'js:$(this).serialize()',),'style'=>'width:270px;','options' => array($batch_id=>array('selected'=>true))));
				}
				else
				{
					echo CHtml::dropDownList('batch','',CHtml::listData(Batches::model()->findAll($criteria),'id','coursename'),array('prompt'=>'Select',
					'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('/report/default/batch'),
					'update'=>'#exam_id',
					'data'=>'js:$(this).serialize()',),'style'=>'width:270px;'));
				}
				?>
                </td>
             </tr>
             <tr>
                <td colspan="4">&nbsp;</td>
              </tr>
             <tr>
                <td>&nbsp;</td>
                <td valign="top"><strong><?php echo Yii::t('report','Examination');?></strong></td>
                <td>&nbsp;</td>
               
                <td><?php 
				if($exam)
				{
					$data=ExamGroups::model()->findAll('batch_id=:x',array(':x'=>$batch_id));
					// $data=CHtml::listData($data,'id','name');
					// echo CHtml::activeDropDownList($model_1,'id',$data,array('prompt'=>'Select','id'=>'exam_id','style'=>'width:270px;','options' => array($group_id=>array('selected'=>true))));
					
					echo CHtml::dropDownList('exam_id','',CHtml::listData($data,'id','name'),array('prompt'=>'Select',
					'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('/report/default/exam'),
					'update'=>'#subject',
					'data'=>'js:$(this).serialize()',),'style'=>'width:270px;','options' => array($exam=>array('selected'=>true))));

					/*echo CHtml::dropDownList('exam_id','',CHtml::listData($model_1,'id','coursename'),array('prompt'=>'Select',
					'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('/report/default/exam'),
					'update'=>'#subject',
					'data'=>'js:$(this).serialize()',),'style'=>'width:270px;', 'options' => array($exam=>array('selected'=>true))));*/
					
				}
				else
				{
					//echo CHtml::activeDropDownList($model_1,'id',array(),array('prompt'=>'Select','id'=>'exam_id','style'=>'width:270px;'));

					/*echo CHtml::dropDownList('exam_id','',CHtml::listData($model_1,'id','name'),array('prompt'=>'Select',
					'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('/report/default/exam'),
					'update'=>'#subject',
					'data'=>'js:$(this).serialize()',),'style'=>'width:270px;'));*/
					echo CHtml::dropDownList('exam_id','',CHtml::listData(array(),'id','coursename'),array('prompt'=>'Select',
					'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('/report/default/exam'),
					// 'update'=>'#subject',
					'success' => 'function(data){$("#subject").html(data);}',
					'data'=>'js:$(this).serialize()',),'style'=>'width:270px;'));

				}


				?></td>
            </tr>

            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
                         <tr>
                <td>&nbsp;</td>
                <td valign="top"><strong><?php echo Yii::t('report','Subjects');?></strong></td>
                <td>&nbsp;</td>
               
                <td><?php 
                $selected_subs = $subject;
				if($subject || ($batch_id && $exam))
				{
					$data=Exams::model()->findAll('exam_group_id=:x',array(':x'=>$exam));
					$subjects = array();
						$subject_l = array();
						foreach ($data as $datai) {
							$subjects[] = $datai->subject_id;
							// echo $datai->id;
							$sub = Subjects::model()->findAll('id=:x',array(':x'=>$datai->subject_id));
							$subject_l = array_merge($sub, $subject_l);
							
						}
						$data=CHtml::listData($subject_l,'id','name');
						echo '<div id="subject" style="display:inline-flex; width: 600px; overflow-x: auto;">';
						$model = Subjects::model();
						$model->id = $subject;
					echo CHtml::activeCheckBoxList($model, 'id',$data, array( 'template' => '<span class="subjects_ckbs" style="display: inline-flex; margin-right: 20px;">{input}{label}</span><br />', 'class'=>'subjects'));
					echo '</div>';

					
				}
				else
				{
					// echo CHtml::activeDropDownList($model_1,'id',array(),array('prompt'=>'Select','id'=>'subject','style'=>'width:270px;'));
					// echo "Select Examination first";
					echo '<div id="subject" style="display:inline-flex; width: 600px; overflow-x: auto;">Select an Examination first</div>';


				}?></td>
            </tr>

            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
	</table>
	-->


       <div style="margin-top:10px;"><?php echo CHtml::submitButton( 'Launch',array('name'=>'search','class'=>'formbut','onclick'=>'js:window.open("index.php?r=report/default/compare_launch"); return false;')); ?></div> 

       </div>
       </div>
     <br />
  <?php
  if(isset($list) and $list!=NULL)
  {
	  
	$flag='';
	$cls="even";
	 
	?>
     <div class="ea_pdf" style="top:235px; right:-2px;"><?php echo CHtml::link('<img src="images/pdf-but.png" border="0" />', array('/report/default/subjectpdf','examid'=>$group_id,'id'=>$batch_id, 'subject'=>$subject),array('target'=>"_blank")); ?></div>
     <br />
     
    <!-- Batch Assessment Report -->
    <div class="tablebx" style="overflow-x:auto;">
    	<!-- Assessment Table -->
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<!-- Table Headers -->
        	<tr class="tablebx_topbg">
                <td style="width:90px;"><?php echo Yii::t('students','Admn No.');?></td>
                <td style="width:auto;min-width:100px;"><?php echo Yii::t('students','Name');?></td>
                <?php
				foreach($list as $exam) // Creating subject column(s)
				{
							$subject=Subjects::model()->findByAttributes(array('id'=>$exam->subject_id));	
							if(!in_array($subject->id, $selected_subs))	{continue;}
				?>
                	<td style="width:auto; min-width:80px; text-align:center;"><?php  echo @$subject->name; ?></td>
                <?php
				} ?>
				<td style="width:auto;min-width:100px;"><?php echo Yii::t('students','Total');?></td>
				<td style="width:auto;min-width:100px;"><?php echo Yii::t('students','Percent');?></td>
				<td style="width:auto;min-width:100px;"><?php echo Yii::t('students','Result');?></td>
				
            </tr>
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
				?> 
					<tr class=<?php echo $cls;?>>
						<td>
							<?php echo $student->admission_no; ?>
						</td>
						<td>
							<?php echo CHtml::link(ucfirst($student->first_name).'  '.ucfirst($student->middle_name).'  '.ucfirst($student->last_name),array('/students/students/view','id'=>$student->id)); ?>
						</td>
						<?php
						foreach($list as $exam) // Creating subject column(s)
						{
							if(!in_array($exam->subject_id, $selected_subs))	{continue;}

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
							<table align="center" width="100%" style="border:none;width:auto; min-width:80px;">
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
    <!-- End Batch Assessment Report -->
    <br />
  
     <?php
	
  }
  ?>  
<div class="clear"></div>
    </div>
</td>
</tr>
</table>
<?php $this->endWidget(); ?>