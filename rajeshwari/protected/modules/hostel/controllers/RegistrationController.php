<?php

class RegistrationController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','autocomplete'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		
		$model=new Registration;
		$model_1=new Room;
		//$err_msg = '';
		$err_flag = 0;
		$err_msg = Yii::t('hostel','Please fix the following errors.').'<br/>';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Registration']))
		{
		
			$roles=Rights::getAssignedRoles(Yii::app()->user->Id); // check for single role
				
			foreach($roles as $role)
			{
				
				if(sizeof($roles)==1 and $role->name == 'student')
				{
					$request=new Roomrequest;
					$model->student_id=$_POST['Registration']['student_id'];
					$model->food_preference=$_POST['Registration']['food_preference'];
					$model->status='C';
					$request->student_id=$_POST['Registration']['student_id'];
					$request->status='C';
					$request->save();
					$model->save();
					$this->redirect(array('/hostel/registration/create'));
				}
				else
				{
					if($_POST['hostel']==NULL)
					{
						$err_flag = 1;
						$err_msg = $err_msg.'- '.Yii::t('hostel','Hostel cannot be blank').'<br/>';
					}
					if($_POST['floor']==NULL)
					{
						$err_flag = 1;
						$err_msg = $err_msg.'- '.Yii::t('hostel','Floor cannot be blank').'<br/>';
					}
					if($_POST['student_id']==NULL)
					{
						$err_flag = 1;
						$err_msg = $err_msg.'- '.Yii::t('hostel','Student cannot be blank').'<br/>';
					}
					if($_POST['Registration']['food_preference']==NULL)
					{
						$err_flag = 1;
						$err_msg = $err_msg.'- '.Yii::t('hostel','Food Preference cannot be blank').'<br/>';
					}
					
					if($err_flag == 0)
					{
						$allot_erre=Allotment::model()->findByAttributes(array('student_id'=>$_POST['student_id'],'status'=>'S'));
						$hostel_reg=Registration::model()->findByAttributes(array('student_id'=>$_POST['student_id'],'status'=>'S')); 
						
						$model->attributes=$_POST['Registration']; 
						$model->student_id=$_POST['student_id'];
						
						if($allot_erre!=NULL and $hostel_reg!=NULL)
						{
							$this->redirect(array('error','student_id'=>$_POST['student_id']));
						}
						$trans=Transportation::model()->findByAttributes(array('student_id'=>$_POST['student_id']));
						if($trans->student_id != NULL)
						{
							if($trans->student_id == $_POST['student_id'])
							{
								$this->redirect(array('warning','registration'=>$_POST['Registration'],'student_id'=>$_POST['student_id'],'floor_id'=>$_POST['floor'],'hostel'=>$_POST['hostel']));
							}
						
						}
						
						$register=Registration::model()->findByAttributes(array('student_id'=>$_POST['student_id']));
						//var_dump($register->attributes);exit;
						if($register!=NULL)
						{
							$request=Roomrequest::model()->findByAttributes(array('student_id'=>$register->student_id,'status'=>'C'));
							if($request!=NULL)
							{
								$request->status='S';
								$request->save();
							}
							
							$register->status='S';
							$register->save();
						}
						else
						{
							$model->food_preference = $_POST['Registration']['food_preference'];
							$model->student_id=$_POST['student_id'];
							$model->status='S';
						}
						if($model->save())
						{
							//$bed_info=Allotment::model()->findAll('status=:x AND student_id=:y',array(':x'=>'C',':y'=>NULL));
							$bed_info=Allotment::model()->findByAttributes(array('student_id'=>NULL,'status'=>'C'));
							//var_dump($bed_info->attributes);exit;
							if($bed_info==NULL)
							{
								
								$this->redirect(array('/hostel/allotment/roominfo/'));
							}
							else
							{
								$this->redirect(array('/hostel/room/roomlist','id'=>$model->student_id,'floor_id'=>$_POST['floor']));
							}
						}
					} // END if($err_flag == 0)
					else
					{
						Yii::app()->user->setFlash('errorMessage',$err_msg);
					}
				}
			}
		}
		$this->render('create',array(
		'model'=>$model,
		));
	}
	
	public function actionSave()
	{
	   	$model=new Registration;
		/*$model->student_id=$_REQUEST['student_id']; 
	   	$model->food_preference = $_REQUEST['registration']['food_preference'];
	    $model->desc = $_REQUEST['registration']['desc'];
		$model->status='C';*/
		$model->attributes = $_REQUEST['registration'];
		$model->student_id=$_REQUEST['student_id'];
		$model->status='C';
		//print_r($model->attributes);
		/*if($model->validate()){echo 'vvv';}
		var_dump($model->getErrors());*/
		if($model->save())
		{
	
				$bed_info=Allotment::model()->findAll('status=:x AND student_id IS NULL',array(':x'=>'C'));
				if($bed_info==NULL)
				{
					$this->redirect(array('/hostel/allotment/roominfo/'));
				}
				else
				{
				$this->redirect(array('/hostel/room/roomlist','id'=>$model->student_id,'floor_id'=>$_REQUEST['floor_id']));
				}
		}
			
	}
	
	
	public function actionWarning()
	{
		
		$this->render('warning');
		
	}
	public function actionError()
	{
		
		$this->render('error');
		
	}
	
	public function actionChange($id)
	 {
		
		 $model = new MessManage; 
		
		$this->render('change',array('model'=>$model,'id'=>$id));
		
	 }
	 public function actionMesschange($id)
	 {  
	
		 $model = new Registration;
		 $model=$this->loadModel($id);
		 if(isset($_POST['food_preference']))
		{   
			$model->food_preference=$_POST['food_preference'];
			$model->save();
			$this->redirect(array('/hostel/MessManage/messinfo'));
		} 
	 }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$reg= Registration::model()->findByAttributes(array('student_id'=>$_REQUEST['studentid'])); 
		$student= Students::model()->findByAttributes(array('id'=>$_REQUEST['studentid']));
		$model->student_id=$student->first_name.' ' .$student->last_name;
		$model->food_preference=$reg->food_preference;
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Registration']))
		{
			$model->attributes=$_POST['Registration'];
			$model->student_id=$_REQUEST['studentid'];
			 $register=Registration::model()->findByAttributes(array('student_id'=>$_REQUEST['studentid']));
							 if($register!=NULL)
							 {
								 $request=Roomrequest::model()->findByAttributes(array('student_id'=>$register->student_id,'status'=>'C'));
								 if($request!=NULL)
								 {
									 $request->status='S';
									 $request->save();
								 }
								
								 $model->status='S';
								 $register->save();
							 }
			if($model->save())
			{
				
				$bed_info=Allotment::model()->findAll('status=:x AND student_id IS NULL',array(':x'=>'C'));
				if($bed_info==NULL)
				{
					$this->redirect(array('/hostel/allotment/roominfo/'));
				}
				else
				{
				$this->redirect(array('/hostel/room/roomlist','id'=>$model->student_id,'floor_id'=>$_POST['floor']));
				}
			
			}
			
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	public function actionAutocomplete() 
	 {
	  if (isset($_GET['term'])) {
		$criteria=new CDbCriteria;
		$criteria->alias = "last_name";
		$criteria->condition = "last_name   like '%" . $_GET['term'] . "%'";
		 $userArray = Students::model()->findAll($criteria);
		
		$hotels = Students::model()->findAll($criteria);;
	
		$return_array = array();
		foreach($hotels as $hotel) {
		  $return_array[] = array(
						'label'=>$hotel->last_name.' '.$hotel->first_name  ,
						'id'=>$hotel->id,
						);
		}
		echo CJSON::encode($return_array);
	  }
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Registration');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Registration('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Registration']))
			$model->attributes=$_GET['Registration'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Registration::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
