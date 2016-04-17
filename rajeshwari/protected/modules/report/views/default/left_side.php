<div id="othleft-sidebar">
             <!--<div class="lsearch_bar">
             	<input type="text" value="Search" class="lsearch_bar_left" name="">
                <input type="button" class="sbut" name="">
                <div class="clear"></div>
  </div>-->    <h1><?php echo Yii::t('report','Manage Reports');?></h1>   
                    <?php
			function t($message, $category = 'cms', $params = array(), $source = null, $language = null) 
{
    return $message;
}

			$this->widget('zii.widgets.CMenu',array(
			'encodeLabel'=>false,
			'activateItems'=>true,
			'activeCssClass'=>'list_active',
			'items'=>array(
					
						    
					
						array('label'=>Yii::t('report','Advanced Report').'<span>'.Yii::t('report','Student advanced report').'</span>', 'url'=>array('/report/default/advancedreport'),'linkOptions'=>array('class'=>'abook_ico'),'active'=> (Yii::app()->controller->action->id=='advancedreport')),
		  				 array('label'=>''.'<h1>'.Yii::t('report','Assessment Report').'</h1>'), 
					
						array('label'=>Yii::t('report','Batch Assessment Report').'<span>'.Yii::t('report','Batch wise assessment report').'</span>', 'url'=>array('/report/default/assessment'),'active'=>(Yii::app()->controller->action->id=='assessment' ? true : false),'linkOptions'=>array('class'=>'ar_ico')),
						array('label'=>Yii::t('report','SMS Exam Report').'<span>'.Yii::t('report','SMS Exam Report').'</span>', 'url'=>array('/report/default/assessmentsms'),'active'=>(Yii::app()->controller->action->id=='assessmentsms' ? true : false),'linkOptions'=>array('class'=>'ar_ico')),
						array('label'=>Yii::t('report','Student Assessment Report').'<span>'.Yii::t('report','Student assessment').'</span>', 'url'=>array('/report/default/studentexam'),'active'=>(Yii::app()->controller->action->id=='studentexam' ? true : false),'linkOptions'=>array('class'=>'sa_ico')),
						array('label'=>Yii::t('report','Subject Assessment Report').'<span>'.Yii::t('report','Subject wise assessment report').'</span>', 'url'=>array('/report/default/subject'),'active'=>(Yii::app()->controller->action->id=='subject' ? true : false),'linkOptions'=>array('class'=>'ar_ico')),
						array('label'=>Yii::t('report','Subject Comparison Report').'<span>'.Yii::t('report','Subject wise comparison report').'</span>', 'url'=>array('/report/default/compare'),'active'=>(Yii::app()->controller->action->id=='compare' ? true : false),'linkOptions'=>array('class'=>'ar_ico')),
						array('label'=>''.'<h1>'.Yii::t('report','Attendance Report').'</h1>'),


						
						
						array('label'=>Yii::t('report','Employee Attendance').'<span>'.Yii::t('report','Employee attendance report').'</span>', 'url'=>array('/report/default/employeeattendance'),'active'=>(Yii::app()->controller->action->id=='employeeattendance' ? true : false),'linkOptions'=>array('class'=>'sm_ico')),
						array('label'=>Yii::t('report','Student Attendance').'<span>'.Yii::t('report','Student attendance report').'</span>', 'url'=>array('/report/default/studentattendance'),'active'=>(Yii::app()->controller->action->id=='studentattendance' ? true : false),'linkOptions'=>array('class'=>'md_ico')),
						array('label'=>Yii::t('report','SMS Student Attendance').'<span>'.Yii::t('report','SMS Student attendance report').'</span>', 'url'=>array('/report/default/Smsstudentattendance'),'active'=>(Yii::app()->controller->action->id=='Smsstudentattendance' ? true : false),'linkOptions'=>array('class'=>'md_ico')),
						
				),
			)); ?>
		
        
		</div>
        <script type="text/javascript">

	$(document).ready(function () {
            //Hide the second level menu
            $('#othleft-sidebar ul li ul').hide();            
            //Show the second level menu if an item inside it active
            $('li.list_active').parent("ul").show();
            
            $('#othleft-sidebar').children('ul').children('li').children('a').click(function () {                    
                
                 if($(this).parent().children('ul').length>0){                  
                    $(this).parent().children('ul').toggle();    
                 }
                 
            });
          
            
        });
    </script>