<style>
.container
{
	background:#FFF;
}
</style>

<?php
$this->breadcrumbs=array(
	Yii::t('Batch','Courses')=>array('/courses'),
	Yii::t('Batch','Batch'),
);
?>
<?php Yii::app()->clientScript->registerCoreScript('jquery');

         //IMPORTANT about Fancybox.You can use the newest 2.0 version or the old one
        //If you use the new one,as below,you can use it for free only for your personal non-commercial site.For more info see
		//If you decide to switch back to fancybox 1 you must do a search and replace in index view file for "beforeClose" and replace with 
		//"onClosed"
        // http://fancyapps.com/fancybox/#license
          // FancyBox2
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js_plugins/fancybox2/jquery.fancybox.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js_plugins/fancybox2/jquery.fancybox.css', 'screen');
         // FancyBox
         //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/fancybox/jquery.fancybox-1.3.4.js', CClientScript::POS_HEAD);
         // Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/fancybox/jquery.fancybox-1.3.4.css','screen');
        //JQueryUI (for delete confirmation  dialog)
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/jqui1812/js/jquery-ui-1.8.12.custom.min.js', CClientScript::POS_HEAD);
         Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/jqui1812/css/dark-hive/jquery-ui-1.8.12.custom.css','screen');
          ///JSON2JS
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/json2/json2.js');
       

           //jqueryform js
               Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/jquery.form.js', CClientScript::POS_HEAD);
              Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/form_ajax_binding.js', CClientScript::POS_HEAD);
              Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/client_val_form.css','screen');  ?>
              <?php
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".info").animate({opacity: 1.0}, 3000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>


<?php $batch=Batches::model()->findByAttributes(array('id'=>$_REQUEST['id'])); ?>
          
<div style="background:#FFF;">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
   
    <td valign="top">
	<?php if($batch!=NULL)
		   {
			   ?>
    <div style="padding:20px;">
    <div class="clear"></div>
    <div class="emp_right_contner">
    <div class="emp_tabwrapper">
     <?php $this->renderPartial('tab');?>
    
    <div class="clear"></div>
    <div class="emp_cntntbx" style="padding-top:10px;">
    <div class="c_subbutCon" align="right" style="width:100%; height:40px; position:relative">
    <div class="edit_bttns" style="top:0px; right:-6px">
    <ul>
    <li>
   <?php echo CHtml::link('<span>'.Yii::t('Batch','Electives').'</span>', array('/courses/electives','id'=>$_REQUEST['id']),array('class'=>'addbttn last')) ?>

    
	</li>
     <li><?php echo CHtml::link('<span>'.Yii::t('Batch','Add Students').'</span>', array('/courses/batches/elective','id'=>$_REQUEST['id']),array('class'=>'addbttn last')) ?></li>
    </ul>
    <div class="clear"></div>
    </div>
    </div>
     
    <?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="info" style="color:#C30; width:575px; height:30px">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="info" style="color:#C30; width:575px; height:30px">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
    <?php endif; ?>
    
  
    <div class="table_listbx">
     <?php
                if(isset($_REQUEST['id']))
                {
					
					$criteria 	= 	new CDbCriteria;
					$criteria->condition='batch_id=:x and status=:y';
					$criteria->params=array(':x'=>$_REQUEST['id'],':y'=>'1');
					$criteria->order	='`id` desc';
					$total 		=	StudentElectives::model()->count($criteria);
					$pages 		= 	new CPagination($total);
					$pages->setPageSize(Yii::app()->params['listPerPage']);
					$pages->applyLimit($criteria);  // the trick is here!
					$posts 	= 	StudentElectives::model()->findAll($criteria);
					$item_count =	$total;
					$page_size 	=	Yii::app()->params['listPerPage'];
					
               // $posts=StudentElectives::model()->findAll("batch_id=:x and status=:y", array(':x'=>$_REQUEST['id'],':y'=>'1'));
				if($posts!=NULL)
				{
                ?>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr class="listbxtop_hdng">
                   <td class="listbx_subhdng"><?php echo Yii::t('Batch','Sl no.');?></td>
                    <td class="listbx_subhdng"><?php echo Yii::t('Batch','Student Name');?></td>
                    <td class="listbx_subhdng"><?php echo Yii::t('Batch','Admission Number');?></td>
		   <td class="listbx_subhdng"><?php echo Yii::t('Batch','Elective Group');?></td>
                    <td class="listbx_subhdng"><?php echo Yii::t('Batch','Elective');?></td>
		   <td class="listbx_subhdng"><?php echo Yii::t('Batch','Action');?></td>
                    </tr>
                        <?php
						$i=0;
						$elective_flag = 0;
                            foreach($posts as $posts_1)
                            {

								$student = Students::model()->findByAttributes(array('id'=>$posts_1->student_id,'batch_id'=>$_REQUEST['id'],'is_deleted'=>'0','is_active'=>'1'));
								if($student)
								{
									$elective_flag =1;
								$elective = Electives::model()->findByAttributes(array('id'=>$posts_1->elective_id));
								$group = ElectiveGroups::model()->findByAttributes(array('id'=>$elective ->elective_group_id));
								$i++;
								echo '<tr>';
								echo '<td>'.$i.'</td>';	
                                echo '<td>'.CHtml::link(ucfirst($student->first_name).' '.ucfirst($student->middle_name).' '.ucfirst($student->last_name), array('/students/students/view', 'id'=>$student->id)).'</td>';
								echo '<td>'.$student->admission_no.'</td>';?>
								<td><?php echo $group->name;?></td>
                                				<td><?php echo $elective->name;?></td>
				
								<td><?php echo CHtml::link('Remove',array('removeelective','eid'=>$posts_1->id,'id'=>$_REQUEST['id']),array('confirm'=>'Are you sure you want to remove?'));?></td>
								
                            <?php 
								}
								else
								{
									continue;
								}
							}
							if($elective_flag==0)
							{
							?>
                            	<tr>
                                	<td colspan="6" align="center">
                                    	<?php echo Yii::t('Batch','No students have choosen the electives!')?>
                                    </td>
                                </tr>
                            <?php
							}
                            ?>
                    </table>
                <?php    	
                }
				else
				{
					echo '<br><div class="notifications nt_red" style="padding-top:10px">'.'<i>'.Yii::t('Batch','No Elective Chosen For The Batch').'</i></div>'; 
									
				}
				
				}
                ?>
    
   				 <div class="pagecon">
               	 <?php 
						$this->widget('CLinkPager', array(
						'currentPage'=>$pages->getCurrentPage(),
						'itemCount'=>$item_count,
						'pageSize'=>$page_size,
						'maxButtonCount'=>5,
						//'nextPageLabel'=>'My text >',
						'header'=>'',
						'htmlOptions'=>array('class'=>'pages'),
                	));
					?>
                </div>
   

 
    </div>
    <br />
   
    
  

   
    </div>
    </div>
    
    </div>
    </div>
     <?php    	
                }
				else
				{
					 echo '<div class="emp_right" style="padding-left:20px; padding-top:50px;">';
					 echo '<div class="notifications nt_red">'.'<i>'.Yii::t('Batch','Nothing Found!').'</i></div>'; 
					 echo '</div>';
					
				}
                ?>
    </td>
  </tr>
</tbody></table>
</div>


<script>
	//CREATE 

    $('.addevnt').bind('click', function() {var id = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=students/studentLeave/returnForm",
            data:{"id":id,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
                beforeSend : function() {
                    $("#"+$(this).attr('name')).addClass("ajax-sending");
                },
                complete : function() {
                    $("#"+$(this).attr('name')).removeClass("ajax-sending");
                },
            success: function(data) {
                $.fancybox(data,
                        {    "transitionIn"      : "elastic",
                            "transitionOut"   : "elastic",
                            "speedIn"                : 600,
                            "speedOut"            : 200,
                            "overlayShow"     : false,
                            "hideOnContentClick": false,
                            "afterClose":    function() {window.location.reload();} //onclosed function
                        });//fancybox
            } //success
        });//ajax
        return false;
    });//bind
	
	
	
	/*//CREATE 


	 $('.addevntelect').bind('click', function() {var id = $(this).attr('name');
        $.ajax({
            type: "POST",
           url: "<?php //echo Yii::app()->request->baseUrl;?>/index.php?r=courses/electiveGroups/returnForm",
            data:{"batch_id":<?php //echo $_GET['id'];?>,"YII_CSRF_TOKEN":"<?php //echo Yii::app()->request->csrfToken;?>"},
                beforeSend : function() {
                    $("#"+$(this).attr('name')).addClass("ajax-sending");
                },
                complete : function() {
                    $("#"+$(this).attr('name')).removeClass("ajax-sending");
                },
            success: function(data) {
                $.fancybox(data,
                        {    "transitionIn"      : "elastic",
                            "transitionOut"   : "elastic",
                            "speedIn"                : 600,
                            "speedOut"            : 200,
                            "overlayShow"     : false,
                            "hideOnContentClick": false,
                            "afterClose":    function() {window.location.reload();} //onclosed function
                        });//fancybox
            } //success
        });//ajax
        return false;
    });//bind*/

	
	</script>
               



