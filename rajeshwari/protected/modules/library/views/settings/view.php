<?php
$this->breadcrumbs=array(
	'Settings'=>array('/library'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Settings', 'url'=>array('index')),
	array('label'=>'Create Settings', 'url'=>array('create')),
	array('label'=>'Update Settings', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Settings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Settings', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('library','View Settings');?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'value',
	),
)); ?>
