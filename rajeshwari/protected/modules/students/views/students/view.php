<?php
$this->breadcrumbs=array(
	'Students'=>array('index'),
	'View',
);


?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    <?php $this->renderPartial('profileleft');?>
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
    
    <h1 style="margin-top:.67em;"><?php echo Yii::t('students','Student Profile :');?> <?php echo ucfirst($model->first_name).' '.ucfirst($model->middle_name).' '.ucfirst($model->last_name); ?><br /></h1>
        
    <div class="edit_bttns last">
    <ul>
    <li>
    <?php echo CHtml::link(Yii::t('students','<span>Edit</span>'), array('update', 'id'=>$model->id),array('class'=>' edit ')); ?>
    </li>
     <li>
    <?php echo CHtml::link(Yii::t('students','<span>Students</span>'), array('students/manage'),array('class'=>'edit last'));?>
    </li>
    </ul>
    </div>
    
    
    <div class="clear"></div>
    <div class="emp_right_contner">
    <div class="emp_tabwrapper">
     <?php $this->renderPartial('tab');?>
    <div class="clear"></div>
    <div class="emp_cntntbx" >
    
    <div class="table_listbx">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="listbxtop_hdng">
    <td><?php echo Yii::t('students','General');?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Admission Date');?></td>
    <td class="subhdng_nrmal"><?php 
								$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
								if($settings!=NULL)
								{	
									$date1=date($settings->displaydate,strtotime($model->admission_date));
									echo $date1;
		
								}
								else
								echo $model->admission_date; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','City');?></td>
    <td class="subhdng_nrmal"><?php echo $model->city; ?></td>
  </tr>

  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Class Roll No');?></td>
    <td class="subhdng_nrmal"><?php echo $model->class_roll_no; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Date of Birth');?></td>
    <td class="subhdng_nrmal"><?php 
									if($settings!=NULL)
								{	
									$date1=date($settings->displaydate,strtotime($model->date_of_birth));
									echo $date1;
		
								}
								else
								echo $model->date_of_birth; 
								 ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng"> <?php echo Yii::t('students','Birth Place');?></td>
    <td class="subhdng_nrmal"><?php echo $model->birth_place; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Blood Group');?></td>
    <td class="subhdng_nrmal"><?php echo $model->blood_group; ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','State');?></td>
    <td class="subhdng_nrmal"><?php echo $model->state; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Country');?></td>
    <td class="subhdng_nrmal"><?php 
	$count = Countries::model()->findByAttributes(array('id'=>$model->country_id));
	if(count($count)!=0)
	echo $count->name; ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Nationality');?></td>
    <td class="subhdng_nrmal"><?php
	$natio_id=Countries::model()->findByAttributes(array('id'=>$model->nationality_id));
	echo $natio_id->name;?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Gender');?></td>
    <td class="subhdng_nrmal">
	<?php if($model->gender=='M')
			echo 'Male';
		else 
			echo 'Female';	 ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Pin Code');?>  </td>
    <td class="subhdng_nrmal"><?php echo $model->pin_code; ?></td>
    <td class="listbx_subhdng">&nbsp;</td>
    <td class="subhdng_nrmal">&nbsp;</td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Address Line1');?>  </td>
    <td class="subhdng_nrmal"><?php echo $model->address_line1; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Address Line 2');?></td>
    <td class="subhdng_nrmal"><?php echo $model->address_line2; ?></td>
  </tr>
 <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Phone 1');?></td>
    <td class="subhdng_nrmal"><?php echo $model->phone1; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Phone 2');?></td>
    <td class="subhdng_nrmal"><?php echo $model->phone2; ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Language');?></td>
    <td class="subhdng_nrmal"><?php echo $model->language; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Email');?></td>
    <td class="subhdng_nrmal"><?php echo $model->email; ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Category');?></td>
    <td class="subhdng_nrmal"><?php 
	$cat =StudentCategories::model()->findByAttributes(array('id'=>$model->student_category_id));
	if($cat !=NULL)
	 echo $cat->name; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Religion');?></td>
    <td class="subhdng_nrmal"><?php echo $model->religion; ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Caste');?></td>
    <td class="subhdng_nrmal"><?php echo $model->caste; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Medium of Instruction');?></td>
    <td class="subhdng_nrmal"><?php echo $model->medium_of_instruction; ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Aadhar Card No.');?></td>
    <td class="subhdng_nrmal"><?php echo $model->aadhar_card_no; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Scholarship Code');?></td>
    <td class="subhdng_nrmal"><?php echo $model->scholarship_code; ?></td>
  </tr>
    <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Identification Mark');?></td>
    <td class="subhdng_nrmal"><?php echo $model->identification_mark; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Vaccinated');?></td>
    <td class="subhdng_nrmal"><?php echo $model->vaccinated; ?></td>
  </tr>
      <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Place of Stay');?></td>
    <td class="subhdng_nrmal"><?php echo $model->place_of_stay; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','No. of Brothers');?></td>
    <td class="subhdng_nrmal"><?php echo $model->no_of_brothers; ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','No. of Sisters');?></td>
    <td class="subhdng_nrmal"><?php echo $model->no_of_sisters; ?></td>
    <td class="listbx_subhdng">&nbsp;</td>
    <td class="subhdng_nrmal">&nbsp;</td>
  </tr>
        <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','TC Given');?></td>
    <td class="subhdng_nrmal"><?php echo $model->tc_given; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','TC Remarks');?></td>
    <td class="subhdng_nrmal"><?php echo $model->tc_remarks; ?></td>
  </tr>

    </tr>
        <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Child Code');?></td>
    <td class="subhdng_nrmal"><?php echo $model->child_code; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Bank Account No.');?></td>
    <td class="subhdng_nrmal"><?php echo $model->bank_account_no; ?></td>
  </tr>

    <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Student Type');?></td>
    <td class="subhdng_nrmal"><?php echo $model->student_type; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Selected Language');?></td>
    <td class="subhdng_nrmal"><?php echo $model->selected_language; ?></td>
  </tr>

      <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Student College Code');?></td>
    <td class="subhdng_nrmal"><?php echo $model->student_college_code; ?></td>
    <td class="listbx_subhdng">&nbsp;</td>
    <td class="subhdng_nrmal">&nbsp;</td>
  </tr>

  <tr class="listbxtop_hdng">
    <td><?php echo Yii::t('students','Emergeny Contact');?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td colspan="4" class="listbx_subhdng"><?php echo Yii::t('students','In case of emergencies,');?><br />
     <?php echo Yii::t('students',' contact : ');?><?php
	  $posts=Guardians::model()->findByAttributes(array('id'=>$model->parent_id));
	  if(count($posts)==0)
	  {
		  echo "No Guardians are added".'&nbsp;&nbsp;'.CHtml::link(Yii::t('students','Add new'), array('guardians/create&id='.$model->id)); 
	  }
	  else
	  {
		  echo ucfirst($posts->first_name).' '.ucfirst($posts->last_name).'&nbsp;&nbsp;'.CHtml::link(Yii::t('students','Edit'), array('/students/guardians/update', 'id'=>$posts->id,'std'=>$model->id));
	  }
	   ?></td>
  </tr>
  <tr class="listbxtop_hdng">
    <td><?php echo Yii::t('students','Student Previous Datas');?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <!--<tr class="table_listbxlast">-->
    
    <?php
    $previous=StudentPreviousDatas::model()->findAllByAttributes(array('student_id'=>$model->id));
	if(count($previous)==0)
	{
		echo '<tr class="table_listbxlast"><td colspan="4" class="listbx_subhdng"><span class="subhdng_nrmal">';
		echo Yii::t('students','No Previous Datas');
		echo '</span></td></tr>';
		echo '<td colspan="4" class="listbx_subhdng"><span class="subhdng_nrmal">'; 
		echo CHtml::link(Yii::t('students','Add another Previous Data'), array('studentPreviousDatas/create&id='.$model->id)); 
		echo '</span></td>';	
	}
	else {
	?>
    <?php
		foreach($previous as $prev){
			if($prev->institution!=NULL or $prev->year!=NULL or $prev->course!=NULL or $prev->total_mark!=NULL){
		?>
    <tr>
          <td class="listbx_subhdng"><?php echo Yii::t('students','Institution');?></td>
            <td class="subhdng_nrmal"><?php if($prev->institution!=NULL){echo $prev->institution;} else { echo '-';} ?></td> 
          <td class="listbx_subhdng"><?php echo Yii::t('students','Year');?></td>
            <td class="subhdng_nrmal"><?php if($prev->year!=NULL){ echo $prev->year;} else { echo '-';} ?></td> 
      </tr>
            <tr>
          <td class="listbx_subhdng"><?php echo Yii::t('students','Course');?></td>
            <td class="subhdng_nrmal"><?php if($prev->course!=NULL){echo $prev->course; } else { echo '-';}?></td> 
          <td class="listbx_subhdng"><?php echo Yii::t('students','Total Mark');?></td>
            <td class="subhdng_nrmal"><?php if($prev->total_mark!=NULL){echo $prev->total_mark;} else { echo '-';} ?></td> 
      </tr>
      
        	<tr>
        	<td class="listbx_subhdng"><?php echo Yii::t('prev_dise','Previous School DISE ');?></td>
            <td class="subhdng_nrmal"><?php if($prev->prev_dise!=NULL){echo $prev->prev_dise;} else { echo '-';} ?></td> 
        	<td class="listbx_subhdng"><?php echo Yii::t('prev_scholarship','Previous Scholarship');?></td>
            <td class="subhdng_nrmal"><?php if($prev->prev_scholarship!=NULL){ echo $prev->prev_scholarship;} else { echo '-';} ?></td> 
			</tr>
            <tr>
        	<td class="listbx_subhdng"><?php echo Yii::t('prev_dol','Date of Leaving');?></td>
            <td class="subhdng_nrmal"><?php if($prev->prev_dol!=NULL){echo $prev->prev_dol; } else { echo '-';}?></td> 
        	<td class="listbx_subhdng"><?php echo Yii::t('prev_reason','Reason');?></td>
            <td class="subhdng_nrmal"><?php if($prev->prev_reason!=NULL){echo $prev->prev_reason;} else { echo '-';} ?></td> 
			</tr>

            <tr>
            	<td class="listbx_subhdng"><?php echo CHtml::link(Yii::t('students','Edit'), array('studentPreviousDatas/update','id'=>$model->id,'pid'=>$prev->id)); ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        
        <?php
			}
		}
		echo '<td colspan="4" class="listbx_subhdng"><span class="subhdng_nrmal">'; 
		echo CHtml::link(Yii::t('students','Add another Previous Data'), array('studentPreviousDatas/create&id='.$model->id)); 
		echo '</span></td>';
		?>
        
    <?php } ?>
    
  <!--</tr>-->
  </table>
 <div class="ea_pdf" style="top:4px; right:6px;">
 <?php echo CHtml::link('<img src="images/pdf-but.png">', array('Students/pdf','id'=>$_REQUEST['id']),array('target'=>'_blank')); ?>
	</div>
 
    </div>
    </div>
    </div>
    
    </div>
    </div>
   
    </td>
  </tr>
</table>