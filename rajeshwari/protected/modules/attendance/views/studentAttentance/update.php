<?php
$this->breadcrumbs=array(
	Yii::t('attendance','Student Attentances')=>array('/courses'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('attendance','Update'),
);

$this->menu=array(
	array('label'=>'List StudentAttentance', 'url'=>array('index')),
	array('label'=>'Create StudentAttentance', 'url'=>array('create')),
	array('label'=>'View StudentAttentance', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StudentAttentance', 'url'=>array('admin')),
);
?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui-style.css" />
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog'.$day.'_'.$emp_id,
                'options'=>array(
                    'title'=>Yii::t('attendance','Edit Leave'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'auto',
                    'height'=>'auto',
                ),
                ));
				?>



<?php echo $this->renderPartial('_form1', array('model'=>$model,'day' =>$day,'month'=>$month,'year'=>$year,'emp_id'=>$emp_id));?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>