<?php
$this->breadcrumbs=array(
	'Settings'=>array('/library'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Settings', 'url'=>array('index')),
	array('label'=>'Create Settings', 'url'=>array('create')),
	array('label'=>'View Settings', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Settings', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('library','Update Settings');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>