<?php
$this->breadcrumbs=array(
	'Student Attentances'=>array('/courses'),
	'Attendance',
);
?>
<style>
.unpaid_table{
	border-top:1px #CCC solid;
	margin:30px 0px;
	font-size:15px;
	border-right:1px #CCC solid;
}
.unpaid_table td,th{
	border-left:1px #CCC solid;
	padding:5px 6px;
	border-bottom:1px #CCC solid;
	
}
</style>
<div class="atnd_Con" style="padding-left:20px; padding-top:30px;">

<?php

  if(isset($_REQUEST['collection']) && isset($_REQUEST['batch']))
  {
	?>
    <!-- Header -->
    <div style="border-bottom:#666 1px; width:700px; padding-bottom:20px;">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="first">
                           <?php $logo=Logo::model()->findAll();?>
                            <?php
                            if($logo!=NULL)
                            {
                                //Yii::app()->runController('Configurations/displayLogoImage/id/'.$logo[0]->primaryKey);
                                echo '<img src="uploadedfiles/school_logo/'.$logo[0]->photo_file_name.'" alt="'.$logo[0]->photo_file_name.'" class="imgbrder" width="100%" />';
                            }
                            ?>
                </td>
                <td align="center" valign="middle" class="first" style="width:300px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:22px; width:300px;  padding-left:10px;">
                                <?php $college=Configurations::model()->findAll(); ?>
                                <?php echo $college[0]->config_value; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:14px; padding-left:10px;">
                                <?php echo $college[1]->config_value; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:14px; padding-left:10px;">
                                <?php echo 'Phone: '.$college[2]->config_value; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <!-- End Header -->
    <br /><br />
    <span align="center"><h4><?php echo Yii::t('fees','LIST OF STUDENTS WITH PENDING FEES'); ?></h4></span>
    <!-- Fees and course details -->
    <div style="border:#CCC 1px; width:700px; padding:10px 10px; background:#E1EAEF;">
        <table style="font-size:14px;">
            <?php $batch = Batches::model()->findByAttributes(array('id'=>$_REQUEST['batch']));
                  $course_name = Courses::model()->findByAttributes(array('id'=>$batch->course_id));
                  $collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_REQUEST['collection']));
				  $category = FinanceFeeCategories::model()->findByAttributes(array('id'=>$collection->fee_category_id));
                  $particulars = FinanceFeeParticulars::model()->findAll("finance_fee_category_id=:x", array(':x'=>$collection->fee_category_id));
				  $currency=Configurations::model()->findByPk(5);
                if($currency->config_value == "₹"){
                    $currency->config_value = '<img src="images/rupee_symbol.png" width="8">';                 
                  } 
            ?>
            <tr>
                <td style="width:100px;"><b><?php echo Yii::t('fees','Course'); ?></b></td>
                <td style="width:10px;">:</td>
                <td style="width:250px;"><?php echo $course_name->course_name; ?></td>
            
                <td><b><?php echo Yii::t('fees','Batch'); ?></b></td>
                <td style="width:10px;">:</td>
                <td><?php echo $batch->name; ?></td>
            </tr>
            <tr>
                <td><b><?php echo Yii::t('fees','Fee Collection'); ?></b></td>
                <td>:</td>
                <td><?php echo $collection->name; ?></td>
                <td><b><?php echo Yii::t('fees','Fee Category'); ?></b></td>
                <td>:</td>
                <td><?php echo $category->name; ?></td>
            </tr>
            <?php 
            $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
			if($settings!=NULL)
			{	
				$collection->start_date=date($settings->displaydate,strtotime($collection->start_date));
				$collection->end_date=date($settings->displaydate,strtotime($collection->end_date));
				$collection->due_date=date($settings->displaydate,strtotime($collection->due_date));		
			}
			?>
            <tr>
                <td><b><?php echo Yii::t('fees','Start Date'); ?></b></td>
                <td>:</td>
                <td><?php echo $collection->start_date; ?></td>
                <td><b><?php echo Yii::t('fees','End Date'); ?></b></td>
                <td>:</td>
                <td><?php echo $collection->end_date; ?></td>
            </tr>
            <tr>
                <td><b><?php echo Yii::t('fees','Due Date'); ?></b></td>
                <td>:</td>
                <td><?php echo $collection->due_date; ?></td>
                <td colspan="3">&nbsp;</td>
            </tr>
           
        </table>
    </div>
    <!-- END fees and course details -->
    <!-- Particulars Table -->

    <div style="width:700px;">
         <!--
    	<table style="font-size:14px;" class="unpaid_table"  width="100%" cellspacing="0" >
        	<tr style="background:#E1EAEF; text-align:center; line-height:10px;">
                <th style="width:30px; padding-top:10px;"><strong><?php echo Yii::t('fees','Sl no.');?></strong></th>
                <th style="width:230px; padding-top:10px;"><strong><?php echo Yii::t('fees','Particulars');?></strong></th>
                <th style="width:250px; padding-top:10px;"><strong><?php echo Yii::t('fees','Applicable For');?></strong></th>
                <th style="width:100px; padding-top:10px;"><strong><?php echo Yii::t('fees','Amount');?></strong></th>
        	</tr>
			<?php 
			$i = 1;
			foreach($particulars as $particular) { 
			?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $particular->name; ?></td>
                    <td>
                    <?php 
                    if($particular->student_category_id==NULL and $particular->admission_no==NULL){
                    echo 'All'; 
                    }
                    elseif($particular->student_category_id!=NULL and $particular->admission_no==NULL){
                    $student_category = StudentCategories::model()->findByAttributes(array('id'=>$particular->student_category_id));
                    echo 'Category: '.$student_category->name; 
                    }
                    elseif($particular->student_category_id==NULL and $particular->admission_no!=NULL){
                    echo 'Admission No: '.$particular->admission_no;
                    }
                    else{
                    echo '-';
                    }
                    ?>
                    </td>
                    <td><?php echo $currency->config_value.' '.$particular->amount; ?></td>
                </tr>
            <?php  
			$i++;} 
			?>
        </table> 
        -->   
    </div>
    <!-- Particulars Table End -->
<!-- Students List Table -->
<table width="100%" cellspacing="0" class="unpaid_table">
    <tr style="background:#E1EAEF; text-align:center; line-height:10px;">
        <th style="width:30px; padding-top:10px;"><?php echo Yii::t('unpaid','Sl no.');?></th>
        <th style="padding-top:10px;"><?php echo Yii::t('unpaid','Admission No');?></th>
        <th style="width:200px; padding-top:10px;"><?php echo Yii::t('unpaid','Name of the student');?></th>
        <th style="width:70px; padding-top:10px;"><?php echo Yii::t('unpaid','Fees');?></th>
        <th style="width:100px; padding-top:10px;"><?php echo Yii::t('unpaid','Fees Paid');?></th>
        <th style="width:70px; padding-top:10px;"><?php echo Yii::t('unpaid','Balance');?></th>
    </tr>
<?php 
	
	$amount = 0;
	//$j=0;
	foreach($particulars as $particular)
	 {
	 
	 $amount = $amount + $particular->amount;
	 $list  = FinanceFees::model()->findAll("fee_collection_id=:x and is_paid=:y", array(':x'=>$_REQUEST['collection'],':y'=>0));
	}

	/*if($j%2==0)
		$class = 'class="odd"';	
	else
		$class = 'class="even"';	*/
		
		
	$k = 1;
	foreach($list as $list_1)
	{
		$student=Students::model()->findByAttributes(array('id'=>$list_1->student_id));
		if($student==NULL || $student->is_active==0)
		{
			continue;
		}
		echo "<tr>";
			echo "<td>".$k."</td>";
			echo "<td>".$student->admission_no."</td>";
			echo "<td style='padding-left:20px'>".$student->first_name.' '.$student->last_name."</td>";
			echo "<td>";
			
				$check_admission_no = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'admission_no'=>$posts->admission_no));
                if(count($check_admission_no)>0){ // If any particular is present for this student
                    $adm_amount = 0;
                    foreach($check_admission_no as $adm_no){
                        $adm_amount = $adm_amount + $adm_no->amount;
                    }
                    $fees = $adm_amount;
                    //echo $adm_amount.' '.$currency->config_value;
                    $balance = 	$adm_amount - $list_1->fees_paid;
                }
                else{ // If any particular is present for this student category
                    $check_student_category = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>$posts->student_category_id,'admission_no'=>''));
                    if(count($check_student_category)>0){
                        $cat_amount = 0;
                        foreach($check_student_category as $stu_cat){
                            $cat_amount = $cat_amount + $stu_cat->amount;
                        }
                        $fees = $cat_amount;
                        //echo $cat_amount.' '.$currency->config_value;
                        $balance = 	$cat_amount - $list_1->fees_paid;		
                    }
                    else{ //If no particular is present for this student or student category
                        $check_all = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>NULL,'admission_no'=>''));
                        if(count($check_all)>0){
                            $all_amount = 0;
                            foreach($check_all as $all){
                                $all_amount = $all_amount + $all->amount;
                            }
                            $fees = $all_amount;
                            //echo $all_amount.' '.$currency->config_value;
                            $balance = 	$all_amount - $list_1->fees_paid;
                        }
                        else{
                            echo '-'; // If no particular is found.
                        }
                    }
                }
            if($fees)	
                echo $currency->config_value.' '.$fees;
            else
                echo '-';
				
			echo "</td>";
			echo "<td>";
			
            if($list_1->is_paid == 0)
            {
                echo $currency->config_value.' '.$list_1->fees_paid;
            }
            else
            {
                echo $currency->config_value.' '.$fees; 
            }
            
         	echo "</td>";
			if($list_1->is_paid == 0 and $list_1->fees_paid > $fees)
			{
				echo "<td style='color: #F50000'>";
			}
           	else
			{
				echo "<td>";
			}
            if($list_1->is_paid == 0)
            {	
                echo $currency->config_value.' '.$balance;
            }
            else
            {
                echo '-';
            }
            echo "</td>";
			
			
			
			
			
		echo "</tr>";
		$k++;
	 
	 }	
	 ?>
</table>
<!--Students List Table End -->
<?php /*$j++;*/ }?>

</div>