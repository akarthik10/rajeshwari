
<style>

.tableinnerlist{
	padding:0px;
	margin:0px;

}
.tableinnerlist table{
	 border-left:1px #b9c7d0 solid;
	  border-top:1px #b9c7d0 solid;
	
	  
}
.tableinnerlist td{
	
	 border-right:1px #b9c7d0 solid;
	  border-bottom:1px #b9c7d0 solid;
	 padding:4px 10px;
	 font-size:12px;
	 font-weight:bold;
	 text-align:center;
}
.tableinnerlist th{
	  border-right:1px #b9c7d0 solid;
	  border-bottom:1px #b9c7d0 solid;
	 padding:4px 10px;
	 font-size:12px;
	 font-weight:bold;
	 text-align:center;
	 
	
}
</style>
<?php
	$student=Students::model()->findByAttributes(array('id'=>$_REQUEST['id']));
	$collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_REQUEST['collection']));
	$category = FinanceFeeCategories::model()->findByAttributes(array('id'=>$collection->fee_category_id));
	//$particulars = FinanceFeeParticulars::model()->findAll("finance_fee_category_id=:x", array(':x'=>$collection->fee_category_id));	
	$batch=Batches::model()->findByAttributes(array('id'=>$_REQUEST['batch']));
    $finance_f = FinanceFees::model()->findByAttributes(array('fee_collection_id'=>$collection->id, 'student_id'=> $student->id));
	$currency=Configurations::model()->findByPk(5);

?>

<table width="700" border="1" bgcolor="#f9feff">
  <tr>
    <td>
    	<div style="padding:10px 20px;">
            <table width="700" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="150">
                <?php $logo=Logo::model()->findAll();?>
                <?php
                if($logo!=NULL)
				{
					Yii::app()->runController('Configurations/displayLogoImage/id/'.$logo[0]->primaryKey);
				}
                ?>
               </td>
                <td width="300" valign="middle">
                <h1 style="font-size:20px; text-align:left;"><?php $college=Configurations::model()->findByPk(1); ?>
                <?php echo $college->config_value ; ?></h1>
                <?php $college=Configurations::model()->findByPk(2); ?>
                <strong><?php echo $college->config_value ; ?></strong><br />
                <?php $college=Configurations::model()->findByPk(3); ?>
                <strong><?php echo ''.$college->config_value ; ?></strong>
                </td>
              </tr>
            </table>
		</div>
	</td>
  </tr>
  <tr>
    <td width="650" style="border-bottom:#ccc 1px solid; padding:10px 20px;">
        <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
            	<td width="550" style="padding:10px 0px;"><?php echo "Payment Transaction: ". $_REQUEST['latest_transaction']; ?></td>
                <td>
                	<?php echo Yii::t('fees','Date'); ?>: <?php 
					$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
					if($settings!=NULL)
					{	
					$date1=date($settings->displaydate,time());
					echo $date1;		
					}
					else
					echo date('d/m/Y');

                            $finance_fees = FinanceFees::model()->findByAttributes(array('fee_collection_id' => $_REQUEST['collection'], 'student_id' => $_REQUEST['id']));
        if($finance_fees != NULL)
        {
            if($settings!=NULL)
                    {   
                   
            $latestdate = date( $settings->displaydate, strtotime($finance_fees->date));
        }
        else
        {
            $latestdate = date( 'd/m/Y', strtotime($finance_fees->date));   
        }

        }
        else
        {
            $latestdate = "-";
        }

					?>
                </td>
            </tr>
            
            <tr>
            	<td style="padding:5px 0px;"><?php echo Yii::t('fees','Name'); ?>:<?php  echo $student->first_name.' '.$student->last_name; ?></td>
                <td style="padding:5px 0px;"><?php echo Yii::t('fees','Admission Number'); ?>: <?php echo $student->admission_no; ?></td>
            </tr>
            
            <tr>
                <td style="padding:5px 0px;"><?php echo Yii::t('fees','Course'); ?>:<?php echo $batch->course123->course_name; ?></td>
                <td style="padding:5px 0px;"><?php echo Yii::t('fees','Batch'); ?>:<?php echo $batch->name; ?></td>
            </tr>
            <tr>
                <td style=" padding:10px 0px;">
                <?php echo Yii::t('fees','Address'); ?>:<?php echo $student->address_line1.' , '.$student->city.' , '.$student->state;?>
                </td>
                <td style="padding:5px 0px;"><?php echo Yii::t('fees','Last transaction'); ?>: <?php echo $latestdate; ?></td>
            </tr>
            <tr>
            	<td><?php echo Yii::t('fees','Fee Category'); ?>: <?php echo $category->name; ?></td>
                <td></td>
            </tr>
        </table>
    
    </td>
  </tr>
  <tr>
    <td width="650" style="padding:10px 0px;">
    <div style="padding:20px 20px;" class="tableinnerlist">
        <table width="760" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th style="border-top:#cad4dc 1px solid; border-left:#cad4dc 1px solid; background:#e4eaed;" width="190"><strong><?php echo Yii::t('fees','Sl no.'); ?></strong></th>
                <th style="border-top:#cad4dc 1px solid; border-left:#cad4dc 1px solid; background:#e4eaed;" width="190"><strong><?php echo Yii::t('fees','Particulars'); ?></strong></th>
                <th style="border-top:#cad4dc 1px solid; border-left:#cad4dc 1px solid; background:#e4eaed;" width="190"><strong><?php echo Yii::t('fees','Amount'); ?></strong></th>
            </tr>
            <tr>
            <?php 
			echo '<td>1.</td>';
            echo '<td>Fee Paid</td>';
            echo '<td>'. $finance_f->fees_paid.'</td>';
			
			?>
            </tr>
            
            <tr>
                <td style="border-left:#cad4dc 1px solid;">&nbsp;</td>
                <td style="color:#333333; font-size:16px; text-align:right; background:#e4eaed;"><strong><?php echo Yii::t('fees','Grand Total'); ?></strong></td>
                <td style="color:#333333; font-size:16px; background:#e4eaed;"><?php echo number_format($finance_f->fees_paid,2).' '.$currency->config_value;?> </td>
            </tr>
            <tr>
                <td style="border-left:#cad4dc 1px solid;">&nbsp;</td>
                <td style="color:#333333; font-size:16px; text-align:right; background:#e4eaed;"><strong><?php echo Yii::t('fees','Balance'); ?></strong></td>
                <td style="color:#333333; font-size:16px; background:#e4eaed;"><?php echo number_format($_REQUEST['balance'],2).' '.$currency->config_value;?> </td>
            </tr>
        </table>
    </div>
    </td>
  </tr>
  <tr>
  	<td>
    	<div>
            <table width="750" border="0" cellspacing="0" cellpadding="0" style="padding:30px 0px;">
              <tr>
                <td width="20"></td>
                <td width="200" align="left"><?php echo 'Month: '.date('F',strtotime($collection->start_date));?></td>
                <td width="200">&nbsp;</td>
                <td width="280" align="left"><?php echo Yii::t('fees','Signature'); ?>:</td>
              </tr>
            </table>
		</div>
	</td>
  </tr>
</table>

