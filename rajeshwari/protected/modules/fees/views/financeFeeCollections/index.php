<?php 
/**
 * Ajax Crud Administration
 * FinanceFeeCollections * index.php view file
 * InfoWebSphere {@link http://libkal.gr/infowebsphere}
 * @author  Spiros Kabasakalis <kabasakalis@gmail.com>
 * @link http://reverbnation.com/spiroskabasakalis/
 * @copyright Copyright &copy; 2011-2012 Spiros Kabasakalis
 * @since 1.0
 * @ver 1.3
 * @license The MIT License
 */
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    
    <?php $this->renderPartial('/default/left_side');?>
    
    </td>
    <td valign="top">
    <div class="cont_right formWrapper">
<?php
 $this->breadcrumbs=array(
	 'Manage Finance Fee Collections'=>array('/fees'),
);
?>
<?php  
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('finance-fee-collections-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('fees','Finance Fee Collections');?> </h1>
<br />

<div>
 <?php echo CHtml::link(Yii::t('fees','Create Fee Collections'), array('/financeFeeCollections/create'),array('id'=>'add_finance-fee-collections','class'=>'cbut')) ?>


<!--    <input id="add_finance-fee-collections" type="button" style="display:block; clear: both;"
           value="Create FinanceFeeCollections" class="client-val-form button">-->
  </div><div id="success_flash" align="center" style=" color:#F00; display:none;"><h4>Selected fee category Deleted Successfully !</h4>
 
   </div>

<?php

//Strings for the delete confirmation dialog.
$del_con = Yii::t('admin_finance-fee-collections', 'Are you sure you want to delete this?');
$del_title=Yii::t('admin_finance-fee-collections', 'Delete Confirmation');
 $del=Yii::t('admin_finance-fee-collections', 'Delete');
 $cancel=Yii::t('admin_finance-fee-collections', 'Cancel');
   ?>
<?php


    $this->widget('zii.widgets.grid.CGridView', array(
         'id' => 'finance-fee-collections-grid',
         'dataProvider' => $model->search(),
		  'pager'=>array('cssFile'=>Yii::app()->baseUrl.'/css/formstyle.css'),
 	     'cssFile' => Yii::app()->baseUrl . '/css/formstyle.css',
         /*'filter' => $model,*/
         'htmlOptions'=>array('class'=>'grid-view clear'),
          'columns' => array(
          		
		'name',
		 array(            // display 'create_time' using an expression
            'name'=>'start_date',
			'type'=>'raw',
			'value'=>'financeFeeCollectionsController::convertTime($data->start_date)',

        ),
		 array(            // display 'create_time' using an expression
            'name'=>'end_date',
			'type'=>'raw',
			'value'=>'financeFeeCollectionsController::convertTime($data->end_date)',

        ),
		 array(            // display 'create_time' using an expression
            'name'=>'due_date',
			'type'=>'raw',
			'value'=>'financeFeeCollectionsController::convertTime($data->due_date)',

        ),
		/*'fee_category_id',*/
		array(
			'name' => 'fee_category_id',
			'type'=>'raw',
			'value' => array($model,'feecategory'),
		),
		
		/*'batch_id',*/
		array(
			'name' => 'batch_id',
			'type'=>'raw',
			'value' => array($model,'batchname'),
		),
		/*'is_deleted',
		*/

    array(
                   'class' => 'CButtonColumn',
                    'buttons' => array(
                                                     'finance-fee-collections_delete' => array(
                                                     'label' => Yii::t('admin_finance-fee-collections', 'Delete'), // text label of the button
                                                      'url' => '$data->id', // a PHP expression for generating the URL of the button
                                                      'imageUrl' =>Yii::app()->request->baseUrl .'/js_plugins/ajaxform/images/icons/cross.png', // image URL of the button.   If not set or false, a text link is used
                                                      'options' => array("class" => "fan_del", 'title' => Yii::t('admin_finance-fee-collections', 'Delete')), // HTML options for the button   tag
                                                      ),
                                                     'finance-fee-collections_update' => array(
                                                     'label' => Yii::t('admin_finance-fee-collections', 'Update'), // text label of the button
                                                     'url' => '$data->id', // a PHP expression for generating the URL of the button
                                                     'imageUrl' =>Yii::app()->request->baseUrl .'/js_plugins/ajaxform/images/icons/pencil.png', // image URL of the button.   If not set or false, a text link is used
                                                     'options' => array("class" => "fan_update", 'title' => Yii::t('admin_finance-fee-collections', 'Update')), // HTML options for the    button tag
                                                        ),
                                                     'finance-fee-collections_view' => array(
                                                      'label' => Yii::t('admin_finance-fee-collections', 'View'), // text label of the button
                                                      'url' => '$data->id', // a PHP expression for generating the URL of the button
                                                      'imageUrl' =>Yii::app()->request->baseUrl .'/js_plugins/ajaxform/images/icons/properties.png', // image URL of the button.   If not set or false, a text link is used
                                                      'options' => array("class" => "fan_view", 'title' => Yii::t('admin_finance-fee-collections', 'View')), // HTML options for the    button tag
                                                        )
                                                    ),
                   'template' => '{finance-fee-collections_view}{finance-fee-collections_update}{finance-fee-collections_delete}',
            ),
    ),
           'afterAjaxUpdate'=>'js:function(id,data){$.bind_crud()}'

                                            ));


   ?>
<script type="text/javascript">
//document ready
$(function() {

    //declaring the function that will bind behaviors to the gridview buttons,
    //also applied after an ajax update of the gridview.(see 'afterAjaxUpdate' attribute of gridview).
        $. bind_crud= function(){
            
 //VIEW

    $('.fan_view').each(function(index) {
        var id = $(this).attr('href');
        $(this).bind('click', function() {
            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/financeFeeCollections/returnView",
                data:{"id":id,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
                beforeSend : function() {
                    $("#finance-fee-collections-grid").addClass("ajax-sending");
                },
                complete : function() {
                    $("#finance-fee-collections-grid").removeClass("ajax-sending");
                },
                success: function(data) {
                    $.fancybox(data,
                            {    "transitionIn" : "elastic",
                                "transitionOut" :"elastic",
                                "speedIn"              : 600,
                                "speedOut"         : 200,
                                "overlayShow"  : false,
                                "hideOnContentClick": false
                            });//fancybox
                    //  console.log(data);
                } //success
            });//ajax
            return false;
        });
    });

//UPDATE

    $('.fan_update').each(function(index) {
        var id = $(this).attr('href');
        $(this).bind('click', function() {
            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/financeFeeCollections/returnForm",
                data:{"update_id":id,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
                beforeSend : function() {
                    $("#finance-fee-collections-grid").addClass("ajax-sending");
                },
                complete : function() {
                    $("#finance-fee-collections-grid").removeClass("ajax-sending");
                },
                success: function(data) {
                    $.fancybox(data,
                            {    "transitionIn"    :  "elastic",
                                 "transitionOut"  : "elastic",
                                 "speedIn"               : 600,
                                 "speedOut"           : 200,
                                 "overlayShow"    : false,
                                 "hideOnContentClick": false,
                                "afterClose":    function() {
                                   var page=$("li.selected  > a").text();
                                $.fn.yiiGridView.update('finance-fee-collections-grid', {url:'<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/financeFeeCollections',data:{"FinanceFeeCollections_page":page}});
                                }//onclosed
                            });//fancybox
                    //  console.log(data);
                } //success
            });//ajax
            return false;
        });
    });


// DELETE

    var deletes = new Array();
    var dialogs = new Array();
    $('.fan_del').each(function(index) {
        var id = $(this).attr('href');
        deletes[id] = function() {
            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/financeFeeCollections/ajax_delete",
                data:{"id":id,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
                    beforeSend : function() {
                    $("#finance-fee-collections-grid").addClass("ajax-sending");
                },
                complete : function() {
                    $("#finance-fee-collections-grid").removeClass("ajax-sending");
                },
                success: function(data) {
                    var res = jQuery.parseJSON(data);
                     var page=$("li.selected  > a").text();
                    $.fn.yiiGridView.update('finance-fee-collections-grid', {url:'<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/financeFeeCollections',data:{"FinanceFeeCollections_page":page}});
                }//success
            });//ajax
        };//end of deletes

        dialogs[id] =
                        $('<div style="text-align:center;"></div>')
                        .html('<?php echo  $del_con; ?><br><br>' + '<h2 style="color:#999999">ID: ' + id + '</h2>')
                       .dialog(
                        {
                            autoOpen: false,
                            title: '<?php echo  $del_title; ?>',
                            modal:true,
                            resizable:false,
                            buttons: [
                                {
                                    text: "<?php echo  $del; ?>",
                                    click: function() {
                                                                      deletes[id]();
                                                                      $(this).dialog("close");
																	 $("#success_flash").css("display","block").animate({opacity: 1.0}, 3000).fadeOut("slow");
                                                                      }
                                },
                                {
                                   text: "<?php echo $cancel; ?>",
                                   click: function() {
                                                                     $(this).dialog("close");
                                                                     }
                                }
                            ]
                        }
                );

        $(this).bind('click', function() {
                                                                      dialogs[id].dialog('open');
                                                                       // prevent the default action, e.g., following a link
                                                                      return false;
                                                                     });
    });//each end

        }//bind_crud end

   //apply   $. bind_crud();
  $. bind_crud();


//CREATE 

    $('#add_finance-fee-collections').bind('click', function() {
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/financeFeeCollections/returnForm",
            data:{"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
                beforeSend : function() {
                    $("#finance-fee-collections-grid").addClass("ajax-sending");
                },
                complete : function() {
                    $("#finance-fee-collections-grid").removeClass("ajax-sending");
                },
            success: function(data) {
                $.fancybox(data,
                        {    "transitionIn"      : "elastic",
                            "transitionOut"   : "elastic",
                            "speedIn"                : 600,
                            "speedOut"            : 200,
                            "overlayShow"     : false,
                            "hideOnContentClick": false,
							"closeEffect": 'none',
                            "afterClose":    function() {
                                   var page=$("li.selected  > a").text();
                                $.fn.yiiGridView.update('finance-fee-collections-grid', {url:'<?php echo Yii::app()->request->baseUrl;?>/index.php?r=fees/financeFeeCollections',data:{"FinanceFeeCollections_page":page}});
                            } //onclosed function
                        });//fancybox
            } //success
        });//ajax
        return false;
    });//bind


})//document ready
    
</script>
</div>
    </td>
  </tr>
</table>

