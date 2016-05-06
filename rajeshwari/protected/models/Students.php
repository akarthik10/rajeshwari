<?php

/**
 * This is the model class for table "students".
 *
 * The followings are the available columns in table 'students':
 * @property integer $id
 * @property string $admission_no
 * @property string $class_roll_no
 * @property string $admission_date
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property integer $batch_id
 * @property string $date_of_birth
 * @property string $gender
 * @property string $blood_group
 * @property string $birth_place
 * @property integer $nationality_id
 * @property string $language
 * @property string $religion
 * @property integer $student_category_id
 * @property string $address_line1
 * @property string $address_line2
 * @property string $city
 * @property string $state
 * @property string $pin_code
 * @property integer $country_id
 * @property string $phone1
 * @property string $phone2
 * @property string $email
 * @property integer $immediate_contact_id
 * @property integer $is_sms_enabled
 * @property string $photo_file_name
 * @property string $photo_content_type
 * @property string $photo_data
 * @property string $status_description
 * @property integer $is_active
 * @property integer $is_deleted
 * @property string $created_at
 * @property string $updated_at
 * @property integer $has_paid_fees
 * @property integer $photo_file_size
 * @property integer $user_id
 */
class Students extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Students the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public $status;
	public $dobrange;
	public $admissionrange;
	public $task_type;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'students';
	}

	/**
	 * @return array validation rules for model attributes.
	 * 
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$ret = array();
		$ret = array(
			array('parent_id, batch_id, nationality_id, student_category_id, country_id, immediate_contact_id, is_sms_enabled, is_active, is_deleted, has_paid_fees, photo_file_size, pin_code, phone1, phone2, user_id, uid', 'numerical', 'integerOnly'=>true),
			//array('first_name, last_name, email', 'required',),
			array('first_name, admission_no,student_category_id', 'required',),
			array('admission_no','unique'),
			array('email','check'),
			array('admission_no, class_roll_no, first_name, middle_name, last_name, gender, blood_group, birth_place, language, religion, address_line1, address_line2, city, state, email, photo_file_name, photo_content_type, status_description, medium_of_instruction, caste, aadhar_card_no, scholarship_code,identification_mark, vaccinated, place_of_stay, no_of_brothers, no_of_sisters, tc_given, tc_remarks, child_code, bank_account_no, student_type, selected_language, selected_language_2, student_college_code ', 'length', 'max'=>255),
			array('admission_date, date_of_birth, created_at, updated_at', 'safe'),			
			array('email','email'),
			/*array(
				'date_of_birth',
				'compare',
				'compareAttribute'=>'created_at',
				'operator'=>'<', 
				'allowEmpty'=>false , 
				'message'=>'{attribute} must be less than "{compareValue}".'
			  ),*/

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.

			array('photo_data', 'file', 'types'=>'jpg, gif, png', 'allowEmpty' => true, 'maxSize'=>716800, 'tooLarge'=>'File has to be smaller than 500KB'),
			array('id, admission_no, parent_id, class_roll_no, admission_date, first_name, middle_name, last_name, batch_id, date_of_birth, gender, blood_group, birth_place, nationality_id, language, religion, student_category_id, address_line1, address_line2, city, state, pin_code, country_id, phone1, phone2, email, immediate_contact_id, is_sms_enabled, photo_file_name, photo_content_type, status_description, is_active, is_deleted, created_at, updated_at, has_paid_fees, photo_file_size, user_id, medium_of_instruction, caste, aadhar_card_no, scholarship_code,identification_mark, vaccinated, place_of_stay, no_of_brothers, no_of_sisters, tc_given, tc_remarks, child_code, bank_account_no, student_type, selected_language, selected_language_2 student_college_code', 'safe', 'on'=>'search'),
		);

		if(defined("ADM_NO_FORMAT_CHECK") && ADM_NO_FORMAT_CHECK ) {
			array_push($ret, array(
            'admission_no',
            'match', 'pattern' => '/^'.ADM_NO_FORMAT_REGEX.'$/',
            'message' => 'Invalid admission no. format',
        ));
        }
        return $ret;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}
	
	public function check($attribute,$params)
    {
		if(Yii::app()->controller->action->id!='update' and $this->$attribute!='')
		{
		$validate = User::model()->findByAttributes(array('email'=>$this->$attribute));
		if($validate!=NULL)
		{
        
            $this->addError($attribute,'Email already in use');
		}
		}
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'admission_no' => 'Admission No',
			'class_roll_no' => 'Class Roll No',
			'admission_date' => 'Admission Date',
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'last_name' => 'Last Name',
			'batch_id' => 'Batch',
			'date_of_birth' => 'Date Of Birth',
			'gender' => 'Gender',
			'blood_group' => 'Blood Group',
			'birth_place' => 'Birth Place',
			'nationality_id' => 'Nationality',
			'language' => 'Mother Tongue',
			'religion' => 'Religion',
			'student_category_id' => 'Student Category',
			'address_line1' => 'Address Line 1',
			'address_line2' => 'Address Line 2',
			'city' => 'City',
			'state' => 'State',
			'pin_code' => 'Pin Code',
			'country_id' => 'Country',
			'phone1' => 'Phone 1',
			'phone2' => 'Phone 2',
			'email' => 'Email',
			'immediate_contact_id' => 'Immediate Contact',
			'is_sms_enabled' => 'Is Sms Enabled',
			'photo_file_name' => 'Photo File Name',
			'photo_content_type' => 'Photo Content Type',
			'photo_data' => 'Photo Data',
			'status_description' => 'Status Description',
			'is_active' => 'Is Active',
			'is_deleted' => 'Is Deleted',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'has_paid_fees' => 'Has Paid Fees',
			'photo_file_size' => 'Photo File Size',
			'user_id' => 'User',
			'medium_of_instruction' => 'Medium of Instruction',
			'caste' => 'Caste',
			'aadhar_card_no' => 'Aadhar Card No.',
			 'scholarship_code' => 'Scholarship Code',
			 'identification_mark' => 'Identification Mark',
			 'vaccinated' => 'Vaccinated', 
			 'place_of_stay' => 'Place of stay',
			 ' no_of_brothers' => 'No. of brothers', 
			 'no_of_sisters' => 'No. of sisters',
			 'tc_given' => 'TC Given',
			 'tc_remarks' => 'TC Remarks',
			 'child_code' => 'Child Code',
			 'bank_account_no' => 'Bank Account No.',
			 'student_type' => 'Student Type', 
			 'selected_language' => 'Selected Language 1',
			 'selected_language_2' => 'Selected Language 2',
			 'student_college_code' => 'Student College  Code'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('admission_no',$this->admission_no,true);
		$criteria->compare('class_roll_no',$this->class_roll_no,true);
		$criteria->compare('admission_date',$this->admission_date,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('batch_id',$this->batch_id);
		$criteria->compare('date_of_birth',$this->date_of_birth,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('blood_group',$this->blood_group,true);
		$criteria->compare('birth_place',$this->birth_place,true);
		$criteria->compare('nationality_id',$this->nationality_id);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('religion',$this->religion,true);
		$criteria->compare('student_category_id',$this->student_category_id);
		$criteria->compare('address_line1',$this->address_line1,true);
		$criteria->compare('address_line2',$this->address_line2,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('pin_code',$this->pin_code,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('phone1',$this->phone1,true);
		$criteria->compare('phone2',$this->phone2,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('immediate_contact_id',$this->immediate_contact_id);
		$criteria->compare('is_sms_enabled',$this->is_sms_enabled);
		$criteria->compare('photo_file_name',$this->photo_file_name,true);
		$criteria->compare('photo_content_type',$this->photo_content_type,true);
		$criteria->compare('status_description',$this->status_description,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('has_paid_fees',$this->has_paid_fees);
		$criteria->compare('photo_file_size',$this->photo_file_size);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('medium_of_instruction',$this->medium_of_instruction);
		$criteria->compare('caste',$this->caste);
		$criteria->compare('aadhar_card_no',$this->aadhar_card_no);
		$criteria->compare('scholarship_code',$this->scholarship_code);
		$criteria->compare('identification_mark',$this->identification_mark);
		$criteria->compare('vaccinated',$this->vaccinated);
		$criteria->compare('place_of_stay',$this->place_of_stay);
		$criteria->compare('no_of_brothers',$this->no_of_brothers);
		$criteria->compare('no_of_sisters',$this->no_of_sisters);
		$criteria->compare('child_code',$this->child_code);
		$criteria->compare('bank_account_no',$this->bank_account_no);
		$criteria->compare('student_type',$this->student_type);
		$criteria->compare('selected_language',$this->selected_language);
		$criteria->compare('selected_language_2',$this->selected_language_2);
		$criteria->compare('student_college_code',$this->student_college_code);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getval()
	{
		return '"123"';
	}
	
	public function getFullname()
	{
	
		return '</td><td  style="padding:0 0 0 20px;" >'.CHtml::link($this->first_name, array('/students/students/view', 'id'=>$this->id)).'
								   </td><td  style="padding:0 0 0 20px;">'.$this->admission_no.'</td>'.
								 '</tr>';
									 
	}
	public function getStudentname()
	{
		return ucfirst($this->first_name).' '.ucfirst($this->middle_name).' '.ucfirst($this->last_name);
	}


	
	
	
}