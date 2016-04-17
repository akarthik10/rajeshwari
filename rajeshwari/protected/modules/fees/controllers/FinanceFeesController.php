<?php

class FinanceFeesController extends RController
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
				'actions'=>array('index','view','Payfees','unpaid','unpaidpdf','printreceipt','cashregister','partialfees', 'transaction'),
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
		$model=new FinanceFees;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FinanceFees']))
		{
			$model->attributes=$_POST['FinanceFees'];
			//$model->saveAttributes('date' => date('Y-m-d') );
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FinanceFees']))
		{
			$model->attributes=$_POST['FinanceFees'];
			//$model->saveAttributes('date' => date('Y-m-d') );
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
		$dataProvider=new CActiveDataProvider('FinanceFees');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionUnpaid()
	{
		
		$this->render('unpaid');
	}
	public function actionPrintreceipt()
	{
		$student = Students::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$student = $student->first_name.' '.$student->last_name.' Fees Receipt.pdf';
		//saving receipt details
		$receipt = FeeReceipt::model()->findByAttributes(array('student'=>$_REQUEST['id'],'batch'=>$_REQUEST['batch'],'collection'=>$_REQUEST['collection']));
		if($receipt==NULL){
			$newReceipt	=	new FeeReceipt;
			$newReceipt->student	=	$_REQUEST['id'];
			$newReceipt->batch		=	$_REQUEST['batch'];
			$newReceipt->collection	=	$_REQUEST['collection'];
			if($newReceipt->validate()){
				$newReceipt->save();
				$receipt_no	=	$newReceipt->id;
			}
		}
		else{
			$receipt_no	=	$receipt->id;
		}
		
		# HTML2PDF has very similar syntax



        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $receipt_type = "student_copy";
        $sid1 = $_REQUEST['id'];
        $sid2 = $_REQUEST['id'];
        
      $html2pdf->WriteHTML($this->renderPartial('printreceipt', array('batch'=>$_REQUEST['batch'],'collection'=>$_REQUEST['course'],'id'=>$sid1,'receipt_no'=>$receipt_no, 'receipt_type'=>$receipt_type), true));

        $html2pdf->WriteHTML("<br/><br/><br/><br/><br/>");
        $receipt_type = "office_copy";
        $html2pdf->WriteHTML($this->renderPartial('printreceipt', array('batch'=>$_REQUEST['batch'],'collection'=>$_REQUEST['course'],'id'=>$sid2,'receipt_no'=>$receipt_no, 'receipt_type'=>$receipt_type), true));
        $html2pdf->Output($student);
		//$this->render('printreceipt');
	}


		public function actionPartialreceipt()
	{
		$list  = FinanceTransaction::model()->findByAttributes(array('id'=>$_REQUEST['id']));
		$collection_id = $list->collection_id;
		$student_id = $list->student_id;
		$collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$collection_id));

		$student = Students::model()->findByAttributes(array('id'=>$student_id));
		$student = $student->first_name.' '.$student->last_name.' Fees Receipt.pdf';
		$batch_id = $collection->batch_id;
		//saving receipt details
		$receipt = FeeReceipt::model()->findByAttributes(array('student'=>$student_id,'batch'=>$batch_id,'collection'=>$collection_id));
		if($receipt==NULL){
			$newReceipt	=	new FeeReceipt;
			$newReceipt->student	=	$student_id;
			$newReceipt->batch		=	$batch_id;
			$newReceipt->collection	=	$collection_id;
			if($newReceipt->validate()){
				$newReceipt->save();
				$receipt_no	=	$newReceipt->id;
			}
		}
		else{
			$receipt_no	=	$receipt->id;
		}
		
		# HTML2PDF has very similar syntax
				  
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $receipt_type = "student_copy";
        $trans_id = $_REQUEST['id'];
        $html2pdf->WriteHTML($this->renderPartial('partialreceipt', array('transaction_id'=>$trans_id,'batch_id'=>$batch_id,'collection_id'=>$collection_id,'student_id'=>$student_id,'receipt_no'=>$receipt_no, 'receipt_type'=>$receipt_type), true));

        $html2pdf->WriteHTML("<br/><br/><br/><br/><br/>");
        $receipt_type = "office_copy";
        $html2pdf->WriteHTML($this->renderPartial('partialreceipt', array('transaction_id'=>$trans_id,'batch_id'=>$batch_id,'collection_id'=>$collection_id,'student_id'=>$student_id,'receipt_no'=>$receipt_no, 'receipt_type'=>$receipt_type), true));
        $html2pdf->Output($student);
		//$this->render('printreceipt');
	}
	
	public function actionPaid()
	{
		
		$this->render('paid');
	}
	public function actionPayfees()
	{
		$list  = FinanceFees::model()->findByAttributes(array('id'=>$_GET['val1']));
		$fees_initial = $list->fees_paid;
		$list->fees_paid = $_GET['fees'];
		$list->is_paid = 1;
		$list->date = date('Y-m-d');
		$list->save();
		echo 'Paid';
		$to = "";

		$sms_settings=SmsSettings::model()->findByAttributes(array('settings_key'=>'FeesEnabled'));
		if($sms_settings->is_enabled=='1'){ // Checking if SMS is enabled.
			$guardian = Guardians::model()->findByAttributes(array('ward_id'=>$list->student_id));
			$student=Students::model()->findByAttributes(array('id'=>$list->student_id));
							if(count($guardian)!=0 && $guardian->mobile_phone && $guardian->mobile_phone!="")
							{
								$to = $guardian->mobile_phone;
							}else if($student->phone1){
								$to = $student->phone1;	
							}
							else if($student->phone2){
								$to = $student->phone2;
							}
			SmsSettings::model()->sendSmsFees($to,$student->first_name.' '.$student->last_name,$_GET['fees'] - $fees_initial,0 )		;
		}

		if(defined('EMAIL_ALERT_ADDRESS'))
		{
			UserModule::sendMail(constant('EMAIL_ALERT_ADDRESS') ,UserModule::t("Student paid fees : {student_name}",array('{student_name}'=>$student->first_name.' '.$student->last_name)),UserModule::t("Student has paid fees: {student_name} of Rs. {fee_amount}",array('{student_name}'=>$old_model->firstname." ".$old_model->lastname, 'fee_amount'=>$_GET['fees'] - $fees_initial)));
		}

		$transaction  = new FinanceTransaction;
				$transaction->amount = $_GET['fees'] - $fees_initial;
				$transaction->collection_id = $list->fee_collection_id;
				$transaction->student_id = $list->student_id;
				$transaction->transaction_date = date('Y-m-d');
				$transaction->save();


		exit;
		
	}
	public function actionPartialfees()
	{
		

		if(isset($_POST['FinanceFees']) and isset($_POST['FinanceFees']['fees_paid'])) 
        {
			$model = $this->loadModel($_POST['FinanceFees']['id']);
			$dt = date('Y-m-d');
			$model->saveAttributes(array('date'=> $dt));	
			$student = Students::model()->findByAttributes(array('id'=>$_POST['FinanceFees']['student_id']));
			$collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_POST['FinanceFees']['fee_collection_id']));
			$check_admission_no = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'admission_no'=>$student->admission_no));
			$to_student="";					
					if(count($check_admission_no)>0){ // If any particular is present for this student
						$adm_amount = 0;
						foreach($check_admission_no as $adm_no){
							$adm_amount = $adm_amount + $adm_no->amount;
						}
						$fees = $adm_amount;						
					}
					else{ // If any particular is present for this student category
						$check_student_category = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>$student->student_category_id,'admission_no'=>''));
						if(count($check_student_category)>0){
							$cat_amount = 0;
							foreach($check_student_category as $stu_cat){
								$cat_amount = $cat_amount + $stu_cat->amount;
							}
							$fees = $cat_amount;
							
						}
						else{ //If no particular is present for this student or student category
							$check_all = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>NULL,'admission_no'=>''));
							if(count($check_all)>0){
								$all_amount = 0;
								foreach($check_all as $all){
									$all_amount = $all_amount + $all->amount;
								}
								$fees = $all_amount;
							}
							else{
								$fees = 0; // If no particular is found.
							}
						}
					}
			
		}
		elseif(isset($_REQUEST['id']))
		{
			$model  = $this->loadModel($_REQUEST['id']);
		}
        // Flag to know if we will render the form or try to add 
        // new jon.
        $flag=true;
        if(isset($_POST['FinanceFees']) and isset($_POST['FinanceFees']['fees_paid'])) 
        { 
			$flag = false;
			
			$fees_paid = $model->fees_paid + $_POST['FinanceFees']['fees_paid'];
			if($model->saveAttributes(array('fees_paid'=>$fees_paid)))
			//if($model->save())
			{
				$transaction  = new FinanceTransaction;
				$transaction->amount = $_POST['FinanceFees']['fees_paid'];
				$transaction->collection_id = $_POST['FinanceFees']['fee_collection_id'];
				$transaction->student_id = $_POST['FinanceFees']['student_id'];
				$transaction->transaction_date = date('Y-m-d');
				$transaction->save();
				if($fees == $fees_paid)
				{
					$model->saveAttributes(array('is_paid'=>1));	
				}	


		$sms_settings=SmsSettings::model()->findByAttributes(array('settings_key'=>'FeesEnabled'));
		if($sms_settings->is_enabled=='1'){ // Checking if SMS is enabled.

						$guardian = Guardians::model()->findByAttributes(array('ward_id'=>$_POST['FinanceFees']['student_id']));
						$student=Students::model()->findByAttributes(array('id'=>$_POST['FinanceFees']['student_id']));
							if(count($guardian)!=0 && $guardian->mobile_phone && $guardian->mobile_phone!="")
							{
								$to = $guardian->mobile_phone;
							}else if($student->phone1){
								$to = $student->phone1;	
							}
							else if($student->phone2){
								$to = $student->phone2;
							}
				$balance = ($fees-$fees_paid)>0?($fees-$fees_paid):0;
				SmsSettings::model()->sendSmsFees($to,$student->first_name.' '.$student->last_name,$fees_paid,$balance )		;
				if(defined('EMAIL_ALERT_ADDRESS'))
				{
					UserModule::sendMail(constant('EMAIL_ALERT_ADDRESS') ,UserModule::t("Student paid fees : {student_name}",array('{student_name}'=>$student->first_name.' '.$student->last_name)),UserModule::t("Student has paid fees: {student_name} of Rs. {fee_amount}",array('{student_name}'=>$old_model->firstname." ".$old_model->lastname, 'fee_amount'=>$fees_paid)));
				}
			}
				echo CJSON::encode(array(
						'status'=>'success',
						));
				exit;      
  			}
			else
			{
				echo CJSON::encode(array(
                        'status'=>'error',
                        ));
                 exit;    
			}
		}
		if($flag) {
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('partialfees',array('model'=>$model),false,true);
		}
		
	}
	
	public function actionEditfees()
	{
		if(isset($_POST['FinanceFees']) and isset($_POST['FinanceFees']['fees_paid'])) 
        {
			$model = $this->loadModel($_POST['FinanceFees']['id']);
			$dt = date('Y-m-d');
			$model->saveAttributes(array('date'=> $dt));
			$student = Students::model()->findByAttributes(array('id'=>$_POST['FinanceFees']['student_id']));
			$collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_POST['FinanceFees']['fee_collection_id']));
			$check_admission_no = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'admission_no'=>$student->admission_no));
			if(count($check_admission_no)>0){ // If any particular is present for this student
				$adm_amount = 0;
				foreach($check_admission_no as $adm_no){
					$adm_amount = $adm_amount + $adm_no->amount;
				}
				$fees = $adm_amount;						
			}
			else{ // If any particular is present for this student category
				$check_student_category = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>$student->student_category_id,'admission_no'=>''));
				if(count($check_student_category)>0){
					$cat_amount = 0;
					foreach($check_student_category as $stu_cat){
						$cat_amount = $cat_amount + $stu_cat->amount;
					}
					$fees = $cat_amount;
					
				}
				else{ //If no particular is present for this student or student category
					$check_all = FinanceFeeParticulars::model()->findAllByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id,'student_category_id'=>NULL,'admission_no'=>''));
					if(count($check_all)>0){
						$all_amount = 0;
						foreach($check_all as $all){
							$all_amount = $all_amount + $all->amount;
						}
						$fees = $all_amount;
					}
					else{
						$fees = 0; // If no particular is found.
					}
				}
			}
			
		}
		elseif(isset($_REQUEST['id']))
		{
			$model  = $this->loadModel($_REQUEST['id']);
		}
		// Flag to know if we will render the form or try to add 
        // new json.
        $flag=true;
		if(isset($_POST['FinanceFees']) and isset($_POST['FinanceFees']['fees_paid'])) 
        { 
			$flag = false;
			
			$fees_paid = $_POST['FinanceFees']['fees_paid'];
			if($model->saveAttributes(array('fees_paid'=>$fees_paid)))
			//if($model->save())
			{
				if($fees == $fees_paid)
				{
					$model->saveAttributes(array('is_paid'=>1));	
				}
				elseif($fees != $fees_paid and $model->is_paid == 1)
				{
					$model->saveAttributes(array('is_paid'=>0));
				}
				echo CJSON::encode(array(
						'status'=>'success',
						));
				exit;      
  			}
			else
			{
				echo CJSON::encode(array(
                        'status'=>'error',
                        ));
                 exit;    
			}
		}
		if($flag) {
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('partialfees',array('model'=>$model),false,true);
		}
	}
	
	/*public function loadModel($id)
	{
		$model=FinanceFees::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}*/
	/*public function actionUnpaidpdf()
	 {
		 $collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_REQUEST['collection']));
//$particular = FinanceFeeParticulars::model()->findByAttributes(array('finance_fee_category_id'=>$collection->fee_category_id));
$data = FinanceFeeParticulars::model()->findAll("finance_fee_category_id=:x", array(':x'=>$collection->fee_category_id));
		
	$amount = 0;
		 
         

	 Yii::import('application.extensions.fpdf.*');
     require('fpdf.php');
	 $pdf = new FPDF();
     $pdf->AddPage();
     $pdf->SetFont('Arial','BU',15);
	 $pdf->Cell(75,10,'Unpaid Students',0,0,'C');
	 $pdf->Ln();
	 $pdf->Ln();
	 $pdf->SetFont('Arial','BU',10);
	 
	 $w= array(40,40,40,60);

	 $header = array('Sl.No','Student Name','Fees');
	
    //Header
    for($i=0;$i<count($header);$i++)
	{
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',false);
    
	}
     $pdf->Ln();
	 $pdf->SetFont('Arial','',10);

	 $fill=false;
	 $i=40;
	 foreach($data as $data1)
	 {
	 
	 $amount = $amount + $data1->amount;
	 $list  = FinanceFees::model()->findAll("fee_collection_id=:x and is_paid=:y", array(':x'=>$_REQUEST['collection'],':y'=>0));
	}
	 $j = 1;
		 foreach($list as $list_1)
		 {
			 $posts=Students::model()->findByAttributes(array('id'=>$list_1->student_id));
			 $pdf->Cell($i,6,$j,1,0,'C',$fill);
			 $pdf->Cell($i,6,$posts->first_name,1,0,'L',$fill);
	 		$pdf->Cell($i,6,$amount,1,0,'C',$fill);
	 		$pdf->Ln();
			$j++;
	 
	 }
     $pdf->Output();
	 Yii::app()->end();
	 }*/
	 
	 public function actionUnpaidpdf()
    {
        $batch_name = Batches::model()->findByAttributes(array('id'=>$_REQUEST['batch']));
		$batch_name = $batch_name->name.' Students With Pending Fees.pdf';
		
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->WriteHTML($this->renderPartial('unpaidpdf',array('model'=>$_REQUEST['collection']), true));
        $html2pdf->Output($batch_name);
 
	}
	 
	public function actionPaidpdf()
    {
        $batch_name = Batches::model()->findByAttributes(array('id'=>$_REQUEST['batch']));
		$batch_name = $batch_name->name.' Students With Paid Fees.pdf';
		
        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->WriteHTML($this->renderPartial('paidpdf',array('model'=>$_REQUEST['collection']), true));
        $html2pdf->Output($batch_name);
 
	}
	 
	 public function actionCashregister(){

		  if(isset($_POST['search']))
		{
			
			$criteria = new CDbCriteria;
				if(isset($_POST['student_id']) and $_POST['student_id']!=NULL)
				{
					
					
					$criteria->condition='id LIKE :match';
		 			$criteria->params = array(':match' =>$_POST['student_id'].'%');
					
					
			
				}
				
			$total = Students::model()->count($criteria);
			$pages = new CPagination($total);
      	    $pages->setPageSize(Yii::app()->params['listPerPage']);
			$pages->applyLimit($criteria);  // the trick is here!
			$posts = Students::model()->findAll($criteria);
			$this->render('cashregister',array('model'=>$model,
			'list'=>$posts,
			'pages' => $pages,
			'item_count'=>$total,
			'page_size'=>Yii::app()->params['listPerPage'],
			));	
		}

		$this->render('cashregister');
		
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FinanceFees('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FinanceFees']))
			$model->attributes=$_GET['FinanceFees'];

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
		$model=FinanceFees::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='finance-fees-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	
	public function actionPrec(){
		$this->renderPartial('printreceipt');
	}
	
	public function actionSendsms(){
		/*echo 'Batch ID: '.$_REQUEST['batch_id'].'<br/>';
		echo 'Fee Collection ID: '.$_REQUEST['collection'].'<br/>';
		echo 'Days in between: '.$_REQUEST['date_status'].'<br/>';
		echo 'Amount: '.$_REQUEST['amount'].'<br/>';*/
		$sms_settings=SmsSettings::model()->findAll();
		if($sms_settings[0]->is_enabled=='1' and $sms_settings[7]->is_enabled=='1'){ // Checking if SMS is enabled.
			$collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_REQUEST['collection']));
			/*echo 'Fees Name: '.$collection->name.'<br/>';
			echo 'Due Date: '.$collection->due_date.'<br/>';*/
			$unpaid_students  = FinanceFees::model()->findAll("fee_collection_id=:x and is_paid=:y", array(':x'=>$_REQUEST['collection'],':y'=>0));
			//echo 'Total unpaid students: '.count($unpaid_students).'<br/><br/>';
			foreach ($unpaid_students as $unpaid_student){
				//echo 'Student ID: '.$unpaid_student->student_id.'<br/>';
				$student=Students::model()->findByAttributes(array('id'=>$unpaid_student->student_id));
				$guardian = Guardians::model()->findByAttributes(array('ward_id'=>$student->id));
				/*echo 'Name: '.$student->first_name.'<br/>';
				echo 'Phone 1: '.$student->phone1.'<br/>';*/
				$to_parent = '';
				$to_student = '';
				$message = '';
				if(count($guardian)!=0 and $guardian->mobile_phone!=NULL){ // If guardian is added
					$to_parent = $guardian->mobile_phone;
				}
				if($student->phone1){ // Checking if phone number is provided
					$to_student = $student->phone1;	
				}
				elseif($student->phone2){
					$to_student = $student->phone2;
				}
				//echo 'Message To: '.$to.'<br/>';
				
				$college=Configurations::model()->findByPk(1);
				$from = $college->config_value;
				// Checking the days between the current date and due date. And, the customising the message accordingly
				if($_REQUEST['date_status']<1){
					$message = 'Last date for the payment of ['.$collection->name.'] fees was '.$collection->due_date;
				}
				elseif($_REQUEST['date_status']>1 and $_REQUEST['date_status']<=7){
					$message = 'Last date for the payment of ['.$collection->name.'] fees is '.$collection->due_date;
				}
				elseif($_REQUEST['date_status']==1){
					$message = 'Last date for the payment of ['.$collection->name.'] fees is today. i.e.,'.$collection->due_date;
				}
				//echo 'Message: '.$message.'<br/><br/>';
				if($message!='' && 0){ // Send SMS if message is set
				
					if($to_parent!=''){ // If unpaid and parent phone number is provided, send SMS
						SmsSettings::model()->sendSms($to_parent,$from,$message);
					} // End check if parent phone number is provided
					
					if($to_student!=''){ // If unpaid and student phone number is provided, send SMS
						SmsSettings::model()->sendSms($to_student,$from,$message);
					} // End check if student phone number is provided
					
					
					Yii::app()->user->setFlash('notification','SMS send Successfully!');
				} // End check if message is set
				
			} // End for each student
			//exit;
		} // End check whether SMS is enabled
		$this->redirect(array('unpaid','batch'=>$_REQUEST['batch_id'],'course'=>$_REQUEST['collection']));
	} // End send SMS function


	function actionTransaction()
	{
		$this->render('transaction');
	}

public function actionSendSMSFeeReminder(){
		/*echo 'Batch ID: '.$_REQUEST['batch_id'].'<br/>';
		echo 'Fee Collection ID: '.$_REQUEST['collection'].'<br/>';
		echo 'Days in between: '.$_REQUEST['date_status'].'<br/>';
		echo 'Amount: '.$_REQUEST['amount'].'<br/>';*/
		$sms_settings=SmsSettings::model()->findAll();
		if($sms_settings[0]->is_enabled=='1' and $sms_settings[7]->is_enabled=='1'){ // Checking if SMS is enabled.
			$collection = FinanceFeeCollections::model()->findByAttributes(array('id'=>$_REQUEST['collection']));
			/*echo 'Fees Name: '.$collection->name.'<br/>';
			echo 'Due Date: '.$collection->due_date.'<br/>';*/
			$unpaid_students  = FinanceFees::model()->findAll("fee_collection_id=:x and is_paid=:y", array(':x'=>$_REQUEST['collection'],':y'=>0));
			$to_parent = '';
			//echo 'Total unpaid students: '.count($unpaid_students).'<br/><br/>';
			foreach ($unpaid_students as $unpaid_student){
				//echo 'Student ID: '.$unpaid_student->student_id.'<br/>';
				$student=Students::model()->findByAttributes(array('id'=>$unpaid_student->student_id));
				$guardian = Guardians::model()->findByAttributes(array('ward_id'=>$student->id));
				/*echo 'Name: '.$student->first_name.'<br/>';
				echo 'Phone 1: '.$student->phone1.'<br/>';*/
				

				if(count($guardian)!=0 and $guardian->mobile_phone!=NULL){ // If guardian is added
					$to_parent .= $guardian->mobile_phone.",";
				}
				
				//if($message!='' && 0){ // Send SMS if message is set
				
					
				//} // End check if message is set
				
			} // End for each student
			if($to_parent!=''){ // If unpaid and parent phone number is provided, send SMS
				SmsSettings::model()->sendSmsFeeReminder($to_parent);
			} // End check if parent phone number is provided
					
					
					
					
			//exit;
		} // End check whether SMS is enabled
		Yii::app()->user->setFlash('notification','SMS sent Successfully!');
		$this->redirect(array('unpaid','batch'=>$_REQUEST['batch'],'collection'=>$_REQUEST['collection']));
	} // End send SMS function
}
