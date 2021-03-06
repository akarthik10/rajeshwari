
<style>
.formCon
{
	padding:0px;
	margin:0px 0px 20px 0px;
	width:100%;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	border:0px #f68575 solid;
	background:#f8fafb url(images/formcon-bg.png);
}
.sd_form_row input[type="text"], textArea, select{ border:#d1e0ea 1px solid;}
.formConInner_frst{padding:15px 15px;position:relative;width:100%; border:1px #d1e0ea solid; width:auto;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;}
.formConInner td{ color:#674d22; font-weight:bold;}
.formConInner{background:#f8fafb url(images/formcon_new-bg.png); width:auto;border:1px #edbc3a solid;-webkit-border-radius: 3px;-moz-border-radius: 3pxborder-radius: 3px; }
.timetable{ width:712px;overflow-x:auto; overflow-y: hidden; }
.timetable table{overflow-x:auto;}
.timetable i{ color:#f62402;}
</style>



<script>
function getcourse() // Function to get course and update the search form
{
	var course_id = document.getElementById('cid').value;
	var batch_id = document.getElementById('batchid').value;
	var mode_id = document.getElementById('mode_id').value;
	var day_id = document.getElementById('day_id').value;
	if(course_id != '' && course_id != '0') // To show batch dropdown. Some course selected
	{
		//window.location= 'index.php?r=/timetable/weekdays/fulltimetable&cid='+course_id;		
		document.getElementById("batch_dropdown").style.display="table-row";
		document.getElementById("filler").style.display="table-row";
		//document.getElementById('batchid').selectedIndex = 0;
		//alert(document.getElementById('batchid').selectedIndex);
		if(mode_id != '') // Some mode selected
		{
			if(mode_id == '1' && batch_id != '') //Mode Week and batch selected
			{
				document.getElementById("filler_2").style.display="none";
				document.getElementById("day").style.display="none";
				window.location= 'index.php?r=/timetable/weekdays/fulltimetable&cid='+course_id+'&bid='+batch_id+'&mode='+mode_id;
			}
			else if(mode_id == '2') //Mode Day
			{
				document.getElementById("filler_2").style.display="table-row";
				document.getElementById("day").style.display="table-row";
				if(day_id != '' && batch_id != '') // Some day selected
				{
					window.location= 'index.php?r=/timetable/weekdays/fulltimetable&cid='+course_id+'&bid='+batch_id+'&mode='+mode_id+'&day='+day_id;
				}
			}
		}
		
		
	}
	else if(course_id == '') // No course selected
	{
		document.getElementById("batch_dropdown").style.display="none";
		document.getElementById("filler").style.display="none";
		document.getElementById("filler_2").style.display="none";
		document.getElementById("day").style.display="none";
		document.getElementById('mode_id').selectedIndex = 0;
	}
	else if(course_id == '0')
	{
		document.getElementById("batch_dropdown").style.display="none";
		document.getElementById("filler").style.display="none";
		//document.getElementById('batchid').selectedIndex = 0;
		if(mode_id == '1') //Mode Week
		{
			
			//window.location= 'index.php?r=/timetable/weekdays/fulltimetable&cid='+course_id+'&bid='+batch_id+'&mode='+mode_id;
			window.location= 'index.php?r=/timetable/weekdays/fulltimetable&cid='+course_id+'&mode='+mode_id;
		}
		else if(mode_id == '2') //Mode Day
		{
			document.getElementById("filler_2").style.display="table-row";
			document.getElementById("day").style.display="table-row";
			if(day_id != '' && batch_id != '') // Some day selected
			{
				window.location= 'index.php?r=/timetable/weekdays/fulltimetable&cid='+course_id+'&mode='+mode_id+'&day='+day_id;
			}
		}
	}
	
}


function getbatch() //Function to get batch and update the form
{
	var course_id = document.getElementById('cid').value;
	var batch_id = document.getElementById('batchid').value;
	var mode_id = document.getElementById('mode_id').value;
	var day_id = document.getElementById('day_id').value;
	if(course_id != '' && batch_id != '' && mode_id !='')
	{
		if(mode_id == '1')
		{
			window.location= 'index.php?r=/timetable/weekdays/fulltimetable&cid='+course_id+'&bid='+batch_id+'&mode='+mode_id;	
		}
		if(mode_id == '2')
		{
			document.getElementById("filler_2").style.display="table-row";
			document.getElementById("day").style.display="table-row";
			if(day_id != '')
			{
				window.location= 'index.php?r=/timetable/weekdays/fulltimetable&cid='+course_id+'&bid='+batch_id+'&mode='+mode_id+'&day='+day_id;
			}
		}
	}
	
	//alert('COURSE: '+course_id+'\nBATCH: '+batch_id+'\nMODE: '+mode_id+'\nDAY: '+day_id);	
	
}


function getmode() // Function to get mode and the dependent dropdown after selecting mode
{
	
	var batch_id;
	var flag = 0;
	var mode_id = document.getElementById('mode_id').value;
	var course_id = document.getElementById('cid').value;
	if(course_id != '' && course_id != '0') // Some course is selected
	{
		batch_id = document.getElementById('batchid').value;
		if(batch_id == '') // No batch selected
		{
			flag = 1;
			alert('Select Batch');
		}
	}
	else if(course_id == '') // No course selected
	{
		flag = 1;
		alert('Select Course');
		
	}
	
	if(flag == 0)
	{
		if(mode_id == '1') // Week
		{
			document.getElementById("filler_2").style.display="none";
			document.getElementById("day").style.display="none";
			if(course_id == '0') // Selected All Courses
			{
				window.location= 'index.php?r=/timetable/weekdays/fulltimetable&cid='+course_id+'&mode='+mode_id;
			}
			else
			{
				window.location= 'index.php?r=/timetable/weekdays/fulltimetable&cid='+course_id+'&bid='+batch_id+'&mode='+mode_id;
			}
			
		}
		else if(mode_id == '2') //Day
		{
			document.getElementById("filler_2").style.display="table-row";
			document.getElementById("day").style.display="table-row";
			//window.location= 'index.php?r=/timetable/weekdays/fulltimetable';
		}
	}
	
}

function getday() // Function to get day
{
	var batch_id;
	var flag = 0;
	var mode_id = document.getElementById('mode_id').value;
	var day_id = document.getElementById('day_id').value;
	var course_id = document.getElementById('cid').value;
	if(day_id == '')
	{
		flag = 1;
	}
	if(course_id != '' && course_id != '0')
	{
		batch_id = document.getElementById('batchid').value;
		if(batch_id == '') // No batch selected
		{
			flag = 1;
			alert('Select Batch');
		}
		
	}
	
	else if(course_id == '')
	{
		flag = 1;
		alert('Select Course');
		
	}
	
	if(flag == 0)
	{
		if(course_id == '0') // Selected All Courses
		{
			window.location= 'index.php?r=/timetable/weekdays/fulltimetable&cid='+course_id+'&mode='+mode_id+'&day='+day_id;
		}
		else
		{
			window.location= 'index.php?r=/timetable/weekdays/fulltimetable&cid='+course_id+'&bid='+batch_id+'&mode='+mode_id+'&day='+day_id;
		}
		//window.location= 'index.php?r=/timetable/weekdays/fulltimetable&cid='+course_id+'&bid='+batch_id+'&mode='+mode_id+'&day='+day_id;
	}
	
}

</script>



<?php
$this->breadcrumbs=array(
	'Weekdays'=>array('/timetable'),
	'TimeTable',
);?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="247" valign="top">
            <?php $this->renderPartial('/default/left_side');?>
        </td>
        <td valign="top">
            <div class="cont_right formWrapper">
               <!--<div class="searchbx_area">
                    <div class="searchbx_cntnt">
                        <ul>
                            <li><a href="#"><img src="images/search_icon.png" width="46" height="43" /></a></li>
                            <li><input class="textfieldcntnt"  name="" type="text" /></li>
                        </ul>
                    </div>
                </div>-->
                <div class="clear"></div>
                <div class="emp_right_contner">
                    <div class="emp_tabwrapper">
                        <div class="clear"></div>
                        <div class="emp_cntntbx" style="padding-top:10px;">
                        
                        	<h1><?php echo Yii::t('timetable','View Full Timetable');?> </h1>
                            
                            
                            <!-- Options Form -->
                           	<div class="formCon"> 
     							<div class="formConInner_frst">
                                	<table style=" font-weight:normal;">
                                    	<!-- Row to select course -->
                                    	<tr>
                                        	<td>&nbsp;</td>
                                            <td style="width:200px;"><strong><?php echo Yii::t('report','Select Course');?></strong></td>
                                            <td>&nbsp;</td>
                                            <?php
                                            $model = new Courses;
                                            $criteria = new CDbCriteria;
                                            $criteria->compare('is_deleted',0); ?>
                                            <td>
                                                <?php 
												$course_names = CHtml::listData(Courses::model()->findAllByAttributes(array('is_deleted'=>0),array('order'=>'id DESC')),'id','course_name'); 
												$course_list = CMap::mergeArray(array(0=>'All Courses'),$course_names);
                                                echo CHtml::dropDownList('cid','',$course_list,array('prompt'=>'Select Course','style'=>'width:190px;',
                                                'ajax' => array(
                                                'type'=>'POST',
                                                'url'=>CController::createUrl('/timetable/weekdays/batchname'),
                                                'update'=>'#batchid',
                                                'data'=>'js:$(this).serialize()'
                                                ),'options'=>array($_REQUEST['cid']=>array('selected'=>true)),'onchange'=>'getcourse()'));
                                                ?>
                                            </td>  
                                        </tr>
                                        <!-- End row to select course -->
                                        <tr>
                                            <td colspan="4">&nbsp;</td>
                                        </tr>
                                        
                                        <!-- Row to select batch. Visible only if a course is selected -->
                                        <?php
										if($_REQUEST['cid']!=NULL and $_REQUEST['cid']!=0)
										{
											$batch_style = "display:table-row";
											$filler_style = "display:table-row";
										}
										else
										{
											$batch_style = "display:none";
											$filler_style = "display:none";
										}
										?>
                                        <tr id="batch_dropdown" style=" <?php echo $batch_style; ?> ">
                                            <td>&nbsp;</td>
                                            <td><strong><?php echo Yii::t('report','Select Batch');?></strong></td>
                                            <td>&nbsp;</td>
                                            <td>
                                                <?php  
                                               // echo CHtml::dropDownList('batch_id','',array(),array('prompt'=>'Select Batch','id'=>'batchid','submit'=>array('/report/default/studentattendance')));
                                                if(isset($_REQUEST['bid']) and $_REQUEST['bid']!=NULL)
                                                {
                                                    $batch_names = CHtml::listData(Batches::model()->findAllByAttributes(array('course_id'=>$_REQUEST['cid'],'is_active'=>1,'is_deleted'=>0)),'id','name');
													$batch_list = CMap::mergeArray(array(0=>'All Batches'),$batch_names);
                                                    echo CHtml::dropDownList('bid','',$batch_list,array('prompt'=>'Select Batch','id'=>'batchid','style'=>'width:190px;','options'=>array($_REQUEST['bid']=>array('selected'=>true)),'onchange'=>'getbatch()'));
                                                }
                                                else
                                                {
                                                    echo CHtml::dropDownList('bid','',array(),array('prompt'=>'Select Batch','id'=>'batchid','style'=>'width:190px;','onchange'=>'getbatch()'));
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <!-- End row to select batch -->
                                        
                                        <!-- Batch Filler row -->
                                        <tr id="filler" style=" <?php echo $filler_style; ?> ">
                                            <td colspan="4">&nbsp;</td>
                                        </tr>
                                        <!-- END Batch Filler row -->
                                        
                                        <!-- Row to select mode -->
              							<tr>
                                        	<td>&nbsp;</td>
                                            <td style="width:100px;"><strong><?php echo Yii::t('timetable','Select Mode');?></strong></td>
                                            <td>&nbsp;</td>
                                            <td>
												<?php
                                                if(isset($_REQUEST['mode']) and $_REQUEST['mode']!=NULL)
                                                {
                                                    echo CHtml::dropDownList('mode_id','',array('1'=>'Week','2'=>'Day'),array('prompt'=>'Select Mode','style'=>'width:190px;','onchange'=>'getmode()','id'=>'mode_id','options'=>array($_REQUEST['mode']=>array('selected'=>true)))); 
                                                }
                                                else
                                                {
                                                    echo CHtml::dropDownList('mode_id','',array('1'=>'Week','2'=>'Day'),array('prompt'=>'Select Mode','style'=>'width:190px;','onchange'=>'getmode()','id'=>'mode_id')); 
                                                }
                                                ?>
                                        	</td>
                                        </tr>
                                        <!-- End row to select mode -->
                                        
                                       
                                        <?php
										if($_REQUEST['mode'] == 2)
										{
											$filler_2_style = "display:table-row";
											$day_style = "display:table-row";
											
										}
										else
										{
											$filler_2_style = "display:none";
											$day_style = "display:none";
										}
										?>
                                        
                                        <!-- Batch Filler row -->
                                        <tr id="filler_2" style=" <?php echo $filler_2_style; ?> ">
                                            <td colspan="4">&nbsp;</td>
                                        </tr>
                                        <!-- END Batch Filler row -->
                                       
                                        <!-- Row to select day. Visible only if mode is Day --> 
                                        <tr id="day" style=" <?php echo $day_style; ?> ">
                                        	<td>&nbsp;</td>
                                            <td style="width:100px;"><strong><?php echo Yii::t('timetable','Select Day');?></strong></td>
                                            <td>&nbsp;</td>
                                        	<td>
                                            	<?php
                                                if(isset($_REQUEST['day']) and $_REQUEST['day']!=NULL)
                                                {
                                                    echo CHtml::dropDownList('day_id','',array('1'=>'Sunday','2'=>'Monday','3'=>'Tuesday','4'=>'Wednesday','5'=>'Thursday','6'=>'Friday','7'=>'Saturday'),array('prompt'=>'Select Day','style'=>'width:190px;','onchange'=>'getday()','id'=>'day_id','options'=>array($_REQUEST['day']=>array('selected'=>true)))); 
                                                }
                                                else
                                                {
                                                    echo CHtml::dropDownList('day_id','',array('1'=>'Sunday','2'=>'Monday','3'=>'Tuesday','4'=>'Wednesday','5'=>'Thursday','6'=>'Friday','7'=>'Saturday'),array('prompt'=>'Select Day','style'=>'width:190px;','onchange'=>'getday()','id'=>'day_id')); 
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <!-- Row to select day -->
                                        
                                        
                                    </table>
                                </div> <!-- END div class="formConInner" -->
							</div> <!-- END div class="formCon" -->
                            
                            <!-- END  Options form -->
                            
                            <!-- Search Result -->
                            <div>
                            	<?php
								if(isset($_REQUEST['mode']) and isset($_REQUEST['cid']))
								{
								
									if($_REQUEST['cid'] == 0) // Selected All Courses
									{
										$courses = Courses::model()->findAllByAttributes(array('is_deleted'=>0));
										//echo 'All courses - '.count($courses);
										
										foreach($courses as $course) // Each Course
										{
										
											$batches = Batches::model()->findAllByAttributes(array('course_id'=>$course->id,'is_active'=>1,'is_deleted'=>0));
											foreach($batches as $batch)
											{
											?>
												<!-- Batch Details -->
												<div class="formCon"> 
													<div class="formConInner">
														<table style="text-align:center;">
															<tr>
																<td style="width:auto; min-width:200px;">
																	<?php echo Yii::t('timetable','Course').' : '.ucfirst($course->course_name);?>
																</td>
																<td width="20px">&nbsp;
																	
																</td>
																<td style="width:auto; min-width:200px;">
																	<?php echo Yii::t('timetable','Batch').' : '.ucfirst($batch->name);?>
																</td>
																<td width="20px">&nbsp;
																	
																</td>
																<td>
																	<?php
																		$classteacher = Employees::model()->findByAttributes(array('id'=>$batch->employee_id));
																		echo Yii::t('timetable','Class Teacher').' : '.ucfirst($classteacher->first_name).' '.ucfirst($classteacher->middle_name).' '.ucfirst($classteacher->last_name);
																	?>
																</td>
															</tr>
														</table>
													</div>
												</div>
												<!-- END Batch Details -->
												<!-- Week Timetable -->
												<?php
												if($_REQUEST['mode']==1)
												{
												$this->renderPartial('/weekdays/viewtable',array('course_id'=>$course,'batch_id'=>$batch->id,'mode'=>$_REQUEST['mode']));
												}
												elseif($_REQUEST['mode']==2)
												{
													$this->renderPartial('/weekdays/viewtable',array('course_id'=>$course,'batch_id'=>$batch->id,'mode'=>$_REQUEST['mode'],'day'=>$_REQUEST['day']));
												}
												?>
												<!-- END Week Timetable -->
										<?php
											} // END foreach($batches as $batch)
										} // END foreach($courses as $course)
									} // END Selected All Courses
									else // Selected Individual course
									{
										$course = Courses::model()->findByAttributes(array('id'=>$_REQUEST['cid']));
										//echo 'Individual Course - '.count($course).' : '.$course->course_name.'<br />';
										if($_REQUEST['bid'] == 0) // All Batches
										{
											//echo 'All Batches';
											$batches = Batches::model()->findAllByAttributes(array('course_id'=>$course->id,'is_active'=>1,'is_deleted'=>0));
											foreach($batches as $batch)
											{
											?>
												<!-- Batch Details -->
												<div class="formCon"> 
													<div class="formConInner">
														<table style="text-align:center;">
															<tr>
																<td style="width:auto; min-width:200px;">
																	<?php echo Yii::t('timetable','Course').' : '.ucfirst($course->course_name);?>
																</td>
																<td width="20px">&nbsp;
																	
																</td>
																<td style="width:auto; min-width:200px;">
																	<?php echo Yii::t('timetable','Batch').' : '.ucfirst($batch->name);?>
																</td>
																<td width="20px">&nbsp;
																	
																</td>
																<td>
																	<?php
																		$classteacher = Employees::model()->findByAttributes(array('id'=>$batch->employee_id));
																		echo Yii::t('timetable','Class Teacher').' : '.ucfirst($classteacher->first_name).' '.ucfirst($classteacher->middle_name).' '.ucfirst($classteacher->last_name);
																	?>
																</td>
															</tr>
														</table>
													</div>
												</div>
												<!-- END Batch Details -->
												<!-- Week Timetable -->
												<?php
												if($_REQUEST['mode']==1)
												{
												$this->renderPartial('/weekdays/viewtable',array('course_id'=>$course,'batch_id'=>$batch->id,'mode'=>$_REQUEST['mode']));
												}
												elseif($_REQUEST['mode']==2)
												{
													$this->renderPartial('/weekdays/viewtable',array('course_id'=>$course,'batch_id'=>$batch->id,'mode'=>$_REQUEST['mode'],'day'=>$_REQUEST['day']));
												}
												?>
												<!-- END Week Timetable -->
										<?php
											} // END foreach($batches as $batch)
										} // END if($_REQUEST['bid'] == 0) All Batches
										else // Individual Batch
										{
											$batch = Batches::model()->findByAttributes(array('id'=>$_REQUEST['bid'],'course_id'=>$course->id,'is_active'=>1,'is_deleted'=>0));
											?>
												<!-- Batch Details -->
												<div class="formCon"> 
													<div class="formConInner">
														<table style="text-align:center;">
															<tr>
																<td style="width:auto; min-width:200px;">
																	<?php echo Yii::t('timetable','Course').' : '.ucfirst($course->course_name);?>
																</td>
																<td width="20px">&nbsp;
																	
																</td>
																<td style="width:auto; min-width:200px;">
																	<?php echo Yii::t('timetable','Batch').' : '.ucfirst($batch->name);?>
																</td>
																<td width="20px">&nbsp;
																	
																</td>
																<td>
																	<?php
																		$classteacher = Employees::model()->findByAttributes(array('id'=>$batch->employee_id));
																		echo Yii::t('timetable','Class Teacher').' : '.ucfirst($classteacher->first_name).' '.ucfirst($classteacher->middle_name).' '.ucfirst($classteacher->last_name);
																	?>
																</td>
															</tr>
														</table>
													</div>
												</div>
												<!-- END Batch Details -->
												<!-- Week Timetable -->
												<?php
												if($_REQUEST['mode']==1)
												{
												$this->renderPartial('/weekdays/viewtable',array('course_id'=>$course,'batch_id'=>$batch->id,'mode'=>$_REQUEST['mode']));
												}
												elseif($_REQUEST['mode']==2)
												{
													$this->renderPartial('/weekdays/viewtable',array('course_id'=>$course,'batch_id'=>$batch->id,'mode'=>$_REQUEST['mode'],'day'=>$_REQUEST['day']));
												}
												?>
												<!-- END Week Timetable -->
										<?php
										} // END Individual Batch
									} // END Selected Individual course
									
								}
								?>
                            </div>                           
                            
                            <!-- END Search Result -->
                            
                        </div> <!-- END div class="emp_cntntbx" -->
                    </div> <!-- END div class="emp_tabwrapper" -->
                </div> <!-- END div class="emp_right_contner" -->
            </div> <!-- END div class="cont_right formWrapper" -->
        </td>
    </tr>
</table>
