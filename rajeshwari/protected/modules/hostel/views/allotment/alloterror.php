
<?php
$this->breadcrumbs=array(
	'Allotments'=>array('/hostel'),
	'RoomInfo',
);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    <?php $this->renderPartial('/settings/hostel_left');?>
 </td>
    <td valign="top"> 
    <div class="cont_right">
      <div class="yellow_bx" style="background-image:none;width:90%;padding-bottom:45px;">
                    <div class="y_bx_head" style="width:90%">
                    <?php
 echo '<strong>'.Yii::t('hostel','Sorry!!&nbsp;The requested room is not available now.').'</strong>&nbsp;';
 echo '<strong>'.Yii::t('hostel','Click Here to view the ').'</strong> &nbsp;&nbsp;'. CHtml::link(Yii::t('hostel','Room details'),array('/hostel/Room/manage'));
 
 ?>
	
		
</div></div>
</div>
</td>
</tr>
</table>
