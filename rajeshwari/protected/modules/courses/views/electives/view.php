

<style>
.fancybox-inner
{
	height: auto !important;
}
</style>
<?php
$this->breadcrumbs=array(
	Yii::t('Electives','Electives')=>array('index'),
	$model->name,
);

/**$this->menu=array(
	array('label'=>'List ', 'url'=>array('index')),
	array('label'=>'Create ', 'url'=>array('create')),
	array('label'=>'Update ', 'url'=>array('update', 'id'=>$model->)),
	array('label'=>'Delete ', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ', 'url'=>array('admin')),
);*/
?>

<div class="tableinnerlist" style="padding-right:25px; height:auto;">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><?php echo Yii::t('Electives','Subject Name');?></td>
    <td><?php echo $model->name; ?></td>
  </tr>
    <tr>
    <td><?php echo Yii::t('Electives','Subject Code');?></td>
    <td><?php echo $model->code; ?></td>
  </tr>
    <tr>
    <td><?php echo Yii::t('Electives','Elective Group');?></td>
    <td><?php
    $posts=ElectiveGroups::model()->findByAttributes(array('id'=>$model->elective_group_id));
	echo $posts->name;
	?></td>
  </tr>
   
</table>
</div>