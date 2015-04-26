<div id="othleft-sidebar">
             <!--<div class="lsearch_bar">
             	<input type="text" value="Search" class="lsearch_bar_left" name="">
                <input type="button" class="sbut" name="">
                <div class="clear"></div>
  </div>-->       
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
			array('label'=>''.'<h1>'.Yii::t('transport','Manage Route').'</h1>'),  
					array('label'=>''.Yii::t('transport','List All Routes').'<span>'.Yii::t('transport','All Route Details').'</span>', 'url'=>array('/transport/RouteDetails/manage') ,'linkOptions'=>array('class'=>'list_all_r_ico'),
                                   'active'=> (Yii::app()->controller->id=='routeDetails' and Yii::app()->controller->action->id=='manage')
					    ),
						array('label'=>''.Yii::t('transport','Assign Route').'<span>'.Yii::t('transport','Assign Route').'</span>', 'url'=>array('/transport/DriverDetails/assign') ,'linkOptions'=>array('class'=>'aroot_ico'),
                                   'active'=> (Yii::app()->controller->id=='driverDetails' and Yii::app()->controller->action->id=='assign')
					    ),        
						
						array('label'=>''.Yii::t('transport','Search Students').'<span>'.Yii::t('transport','Search All Students').'</span>', 'url'=>array('/transport/Transportation/studentsearch') ,'linkOptions'=>array('class'=>'sstudent_ico'),
                                   'active'=> (Yii::app()->controller->id=='transportation' and Yii::app()->controller->action->id=='studentsearch')
					    ),              
					array('label'=>''.'<h1>'.Yii::t('transport','Routes').'</h1>'), 
					array('label'=>''.Yii::t('transport','Allotment').'<span>'.Yii::t('transport','Allot Students').'</span>', 'url'=>array('/transport/Transportation/create') ,'linkOptions'=>array('class'=>'allot_ico'),
                             'active'=> (Yii::app()->controller->id=='transportation' and  (Yii::app()->controller->action->id=='create' or
							 Yii::app()->controller->action->id=='view'))
					    ),  
						
						
						array('label'=>''.'<h1>'.Yii::t('transport','Settings').'</h1>'),  
						array('label'=>''.Yii::t('transport','Vehicle Details').'<span>'.Yii::t('transport','All Vehicle Details').'</span>', 'url'=>array('/transport/VehicleDetails/manage') ,'linkOptions'=>array('class'=>'vdetail_ico'),
                                   'active'=> (Yii::app()->controller->id=='vehicleDetails' and (Yii::app()->controller->action->id=='manage' or Yii::app()->controller->action->id=='create' or Yii::app()->controller->action->id=='update' or Yii::app()->controller->action->id=='view'))
					    ), 
						array('label'=>''.Yii::t('transport','Route Details').'<span>'.Yii::t('transport','All Route Details').'</span>', 'url'=>array('/transport/RouteDetails/create') ,'linkOptions'=>array('class'=>'rdetail_ico'),
                                   'active'=> (Yii::app()->controller->id=='routeDetails' and (Yii::app()->controller->action->id=='create' or Yii::app()->controller->action->id=='update' or Yii::app()->controller->action->id=='view' ) or Yii::app()->controller->id=='stopDetails')
					    ), 
						array('label'=>''.Yii::t('transport','Driver Details').'<span>'.Yii::t('transport','All Driver Details').'</span>', 'url'=>array('/transport/DriverDetails/manage') ,'linkOptions'=>array('class'=>'ddetail_ico'),
                                   'active'=> (Yii::app()->controller->id=='driverDetails' and (Yii::app()->controller->action->id=='manage' or Yii::app()->controller->action->id=='create' or Yii::app()->controller->action->id=='update' or Yii::app()->controller->action->id=='view'))
					    ),
						array('label'=>''.Yii::t('transport','Transport Manage').'<span>'.Yii::t('transport','Fee Payment Details').'</span>', 'url'=>array('/transport/Transportation/viewall') ,'linkOptions'=>array('class'=>'t_manage_ico'),
                                   'active'=> (Yii::app()->controller->id=='transportation' and (Yii::app()->controller->action->id=='viewall'or Yii::app()->controller->action->id=='Payfees'))
					    ),  
						array('label'=>''.Yii::t('transport','Bus Log').'<span>'.Yii::t('transport','Bus Log').'</span>', 'url'=>array('/transport/BusLog/manage') ,'linkOptions'=>array('class'=>'b_log_ico'),
                                   'active'=> ((Yii::app()->controller->id=='busLog' and (Yii::app()->controller->action->id=='manage' or Yii::app()->controller->action->id=='create' or  Yii::app()->controller->action->id=='view' or Yii::app()->controller->action->id=='update')) or
								    (Yii::app()->controller->id=='fuelConsumption' and  (Yii::app()->controller->action->id=='create' or Yii::app()->controller->action->id=='view' or Yii::app()->controller->action->id=='update')))
					    ), 
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