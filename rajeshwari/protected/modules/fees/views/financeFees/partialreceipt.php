
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
     font-size:10px;
     font-weight:bold;
     text-align:center;
}
.tableinnerlist th{
      border-right:1px #b9c7d0 solid;
      border-bottom:1px #b9c7d0 solid;
     padding:4px 10px;
     font-size:10px;
     font-weight:bold;
     text-align:center;
     
    
}
</style>
<?php
    $student=Students::model()->findByAttributes(array('id'=>$student_id));
    $collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$collection_id));
    $category = FinanceFeeCategories::model()->findByAttributes(array('id'=>$collection->fee_category_id));
   $list  = FinanceTransaction::model()->findByAttributes(array('id'=>$transaction_id));
   $guard=Guardians::model()->findByAttributes(array('id'=>$student->parent_id));
    //$particulars = FinanceFeeParticulars::model()->findAll("finance_fee_category_id=:x", array(':x'=>$collection->fee_category_id));  
    $batch=Batches::model()->findByAttributes(array('id'=>$batch_id));
    $currency=Configurations::model()->findByPk(5);

      if($currency->config_value == "₹"){
      $currency->config_value = '<img src="images/rupee_symbol.png" width="8">';                 
    } 

?>

<table width="680" border="1" bgcolor="#f9feff">
  <tr>
    <td>
        <div style="padding:10px 20px;">
            <table width="650" border="0" cellspacing="0" cellpadding="0">
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
                <td width="450" style="padding:2px 0px;"><?php echo Yii::t('fees','Transaction no'); ?>:<?php echo $transaction_id;?><?php if(isset($receipt_type) && $receipt_type=="student_copy"){ echo " (student copy)";} else if(isset($receipt_type) && $receipt_type=="office_copy"){echo " (office copy)"; } ?></td>
                <td>
                    <?php echo Yii::t('fees','Print Date'); ?>: <?php 
                    $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                    if($settings!=NULL)
                    {   
                    $date1=date($settings->displaydate,time());
                      echo date('d/m/Y');
     
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
                <td style="padding:2px 0px;"><?php echo Yii::t('fees','Name'); ?>:<?php  echo $student->first_name.' '.$student->last_name; ?></td>
                <td style="padding:2px 0px;"><?php echo Yii::t('fees','Admission Number'); ?>: <?php echo $student->admission_no; ?></td>
            </tr>
            
            <tr>
                <td style="padding:2px 0px;"><?php echo Yii::t('fees','Course'); ?>:<?php echo $batch->course123->course_name; ?></td>
                <td style="padding:2px 0px;"><?php echo Yii::t('fees','Batch'); ?>:<?php echo $batch->name; ?></td>
            </tr>
        
            <tr>
                 <?php 
                                    if($guard->last_name!=NULL or $guard->first_name!=NULL)
                                        $pname = ucfirst($guard->last_name).' '.ucfirst($guard->first_name);
                                    else
                                        $pname = '-';
                 ?>
                <td><?php echo Yii::t('fees','Fee Category'); ?>: <?php echo $category->name; ?></td>
                <td><?php echo Yii::t('fees','Guardian'); ?>: <?php echo $pname; ?></td>
            </tr>
    <tr>
                        <td style="padding:5px 0px;"><?php echo Yii::t('fees','Payment Date'); ?>: <?php 
$date=date_create($list->transaction_date);
echo date_format($date,"d/m/Y");
 ?></td>
            </tr> 

        </table>
    
    </td>
  </tr>
  <tr>
    <td width="650" style="padding:2px 0px;">
    <div style="padding:2px 20px;" class="tableinnerlist">
        <table width="680" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th style="border-top:#cad4dc 1px solid; border-left:#cad4dc 1px solid; background:#e4eaed;" width="190"><strong><?php echo Yii::t('fees','Sl no.'); ?></strong></th>
                <th style="border-top:#cad4dc 1px solid; border-left:#cad4dc 1px solid; background:#e4eaed;" width="190"><strong><?php echo Yii::t('fees','Particulars'); ?></strong></th>
                <th style="border-top:#cad4dc 1px solid; border-left:#cad4dc 1px solid; background:#e4eaed;" width="190"><strong><?php echo Yii::t('fees','Amount'); ?></strong></th>
            </tr>
            <?php /*?><?php 
            $i = 1;
            foreach($particulars as $particular) {
                
            ?>
            <tr>
                <td style="border-left:#cad4dc 1px solid;"><?php echo $i; ?></td>
                <td><?php echo $particular->name.'-'.$particular->student_category_id; ?></td>
                <td><?php echo $particular->amount.'-'.$particular->admission_no; ?></td>
            </tr>
            <?php
            $amount = $amount + $particular->amount;
            $i++;}
            ?><?php */?>
            <?php
            $check_admission_no = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'admission_no'=>$student->admission_no));
            if($check_admission_no!=NULL){
                $particulars = $check_admission_no;
            }
            elseif($student->student_category_id!=NULL){
                $check_student_category = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>$student->student_category_id,'admission_no'=>''));
                if($check_student_category!=NULL){
                    $particulars = $check_student_category;
                }
                else{/*
                    $check_all = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>NULL,'admission_no'=>''));
                    if($check_all!=NULL){
                        $particulars = $check_all;
                        
                    }
                    else{
                    ?>
                       
                    <?php
                    }*/
                    ?>
                <tr>
                    <td style="border-left:#cad4dc 1px solid;">1</td>
                    <td>Fees Paid</td>
                    <td><?php echo $currency->config_value.' '.number_format(
                    $list->amount,2); ?></td>
                </tr>
                        <?php
                }
            }
            else{
                    /*$check_all = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>NULL,'admission_no'=>''));
                    if($check_all!=NULL){
                        $particulars = $check_all;
                        
                    }
                    else{
                    ?>
                        <tr>
                            <td style="border-left:#cad4dc 1px solid; text-align:center;" colspan="3"><?php echo Yii::t('fees','No Fees Particular Details Available!'); ?></td>                        
                        </tr>
                    <?php
                    }*/
                                        ?>
                <tr>
                    <td style="border-left:#cad4dc 1px solid;">1</td>
                    <td>Fees Paid</td>
                    <td><?php echo $currency->config_value.' '.number_format(
                    $list->amount,2); ?></td>
                </tr>
                        <?php
                }
            
            
            if($particulars!=NULL){
                $i=1;
                $amount = 0;
                foreach($particulars as $particular){
            ?>
                <tr>
                    <td style="border-left:#cad4dc 1px solid;"><?php echo $i; ?></td>
                    <td><?php echo $particular->name; ?></td>
                    <td><?php echo $currency->config_value.' '.number_format($particular->amount,2); ?></td>
                </tr>
            <?php
                $amount = $amount + $particular->amount;
                $i++;
                }
            }

            $amount = $list->amount;
            ?>
            
            <tr>
                <td style="border-left:#cad4dc 1px solid;">&nbsp;</td>
                <td style="color:#333333; font-size:16px; text-align:right; background:#e4eaed;"><strong><?php echo Yii::t('fees','Grand Total'); ?></strong></td>
                <td style="color:#333333; font-size:16px; background:#e4eaed;"><?php echo $currency->config_value.' '.number_format($amount,2);?> </td>
            </tr>
        </table>
    </div>
    </td>
  </tr>
  <tr>
    <td>
        <div>
            <table width="750" border="0" cellspacing="0" cellpadding="0" style="padding:3px 0px;">
              <tr>
                <td width="20"></td>
                <td width="200" align="left"><?php echo 'Month: '.date('F');?></td>
                <td width="200">&nbsp;</td>
                <td width="280" align="left"><?php echo Yii::t('fees','Signature'); ?>:</td>
              </tr>
            </table>
        </div>
    </td>
  </tr>
</table>
