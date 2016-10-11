<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
//require_once(dirname(__FILE__).'/environment.php');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'openschool',
	

	// preloading 'log' component
	
	'preload'=>array('log','translate'),
	
	'defaultController'=>'message/index',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.*',
		'application.modules.translate.TranslateModule',
		'application.modules.students.controllers.*',
		
		'application.modules.user.models.*',
        //'application.modules.inventory.models.*',
        'application.modules.mailbox.models.*',
		'application.modules.mailbox.*',
		'application.modules.user.components.*',
		'application.modules.user.*',
		
        'application.modules.rights.*',
		'application.modules.rights.models.*',
        'application.modules.rights.components.*',
		'application.modules.rights.components.dataproviders.*',
		
		'application.modules.transport.models.*',
		'application.modules.hostel.models.*',
		'application.components.validators.*',
	),
	'aliases' => array(
		//If you used composer your path should be
		//'xupload' => 'ext.vendor.asgaroth.xupload',
		//If you manually installed it
		'xupload' => 'ext.xupload'
	),
	'modules'=>array(
	'dashboard',
	'mailbox',
	//'inventory',
	'downloads'=>array(
	
	),
	// uncomment the following to enable the Gii tool
	'translate'=>array(
            'class'=>'application.modules.translate.TranslateModule',
    ),
	
	//The CSV Import
	'importcsv'=>array(
		'path'			=>	'uploads/importcsv/', // path to folder for saving csv file and file with import params
		'delimiter'		=>	',', //delimiter for the fields
		'textDelimiter'	=>	'"', //delemiter for the text data
		'perRequest'	=>	10000, //number or rows per request
		'mode'			=>	1, //1-insert all, 2- insert new, 3- insert and update exisiting 2 and 3 not working
		'csvKey'		=>	1, //comparing key from csv file
		'models'		=>	array(
			//Students model to import student details
			'Students' => array(
				'label' => 'Student Details',
				'description' => 'Email ID is unique',
				'allowedColumns' => array(
					'admission_no',
					'admission_date',
					'first_name',
					'middle_name',
					'last_name',
					'email',
					'date_of_birth',
					'gender'
				),
				'dataTypes' => array(
					'date_of_birth' => array(
						'type' => 'date',
					),
					'admission_date'=>array(
						'type' => 'date'
					),
					'gender'=>array(
						'type' => 'gender'
					),
				),
				'requiredColumns' => array(
					'admission_no',
					'admission_date',
					'email',
					'first_name',
					'last_name',
					'date_of_birth',
					'gender'
				),
				'uniqueColumns' => array(
					'email',
					'admission_no',
				),
				'external' => array(
					'parent_id' => array(
						'model' => 'Guardians',		
						'label' => 'Parent Details',
						'description' => 'Email ID is unique',
						'allowedColumns' => array(
							'first_name',
							'last_name',
							'relation',
							'email',
						),
						'requiredColumns' => array(
							'first_name',
							'last_name',
							'relation',
							'email',
						),
						'uniqueColumns' => array(
							'email',
						),
					),
				),
				
				'compare'=>array(
					'course_id' => array(
						'model' => 'Courses',
						'label' => 'Course Details',
						'description' => 'Courses must be already created',
						'allowedColumns' => array(
							'course_name',
						),
						'requiredColumns' => array(
							'course_name',
						),
						'compareWith' => 'batch_id',		//must given in the same array as below
					),
					'batch_id' => array(
						'model' => 'Batches',
						'label' => 'Batch Details',
						'description' => 'Batches must be already created',
						'allowedColumns' => array(
							'name',
						),
						'requiredColumns' => array(
							'name',
						),
					)
				),
			),
			//Employees model to import student details
			'Employees' => array(
				'label' => 'Employees Data',
				'allowedColumns' => array(
					'employee_number',
					'first_name',
					'middle_name',
					'last_name',
					'gender',
					'email'
				),
				'requiredColumns' => array(
					'employee_number',
					'first_name',
					'last_name',
					'gender',
					'email'
				),
				'uniqueColumns' => array(
					'employee_number',
					'email'
				),
				'compare' => array(
					'employee_department_id' => array(
						'model' => 'EmployeeDepartments',		
						'label' => 'Department Details',
						'description' => 'Department must be already created',
						'allowedColumns' => array(
							'name',
						),
						'requiredColumns' => array(
							'name',
						),
					),
				),
			),
		),
	),	
	
	//exporting module
	'export'=>array(
	),
	//sms module
	'sms'=>array(	
	),
	//mailbox module
	'mailbox'=>
    array(  
    'userClass' => 'User',
    'userIdColumn' => 'id',
    'usernameColumn' =>  'username',
	'newsUserId' => 2,
        
      ),
	  'inbox',
   

	'user'=>array(
                'tableUsers' => 'users',
                'tableProfiles' => 'profiles',
                'tableProfileFields' => 'profiles_fields',
					 # encrypting method (php hash function)
				'hash' => 'md5',
	 
				# send activation email
				'sendActivationMail' => true,
	 
				# allow access for non-activated users
				'loginNotActiv' => false,
	 
				# activate user on registration (only sendActivationMail = false)
				'activeAfterRegister' => false,
	 
				# automatically login from registration
				'autoLogin' => true,
	 
				# registration path
				'registrationUrl' => array('/user/registration'),
	 
				# recovery password path
				'recoveryUrl' => array('/user/recovery'),
	 
				# login form path
				'loginUrl' => array('/user/login'),
	 
				# page after login
				//'returnUrl' => array('/user/profile'),
	 
				# page after logout
				'returnLogoutUrl' => array('/user/login'),
        ),

	 'students',
	 'employees',
	 'courses',
	 'library',
	 'examination',
	 'fees',
	 'attendance',
	 'timetable',
	 'hostel',
	 'transport',
	 'parentportal',
	 'studentportal',
	 'report',
	 'store',
	 'teachersportal',
	  
        
    //Modules Rights
   'rights'=>array(
			//'debug'=>true,
			//'install'=>true,
			//'cssFile'=>'style.css',
			//'enableBizRuleData'=>true,
				'superuserName'=>'Admin', // Name of the role with super user privileges. 
			   'authenticatedName'=>'Authenticated',  // Name of the authenticated user role. 
			   'userIdColumn'=>'id', // Name of the user id column in the database. 
			   'userNameColumn'=>'username',  // Name of the user name column in the database. 
			   'enableBizRule'=>true,  // Whether to enable authorization item business rules. 
			   'enableBizRuleData'=>true,   // Whether to enable data for business rules. 
			   'displayDescription'=>true,  // Whether to use item description instead of name. 
			   'flashSuccessKey'=>'RightsSuccess', // Key to use for setting success flash messages. 
			   'flashErrorKey'=>'RightsError', // Key to use for setting error flash messages. 
			   //'install'=>true,  // Whether to install rights. 
			   'baseUrl'=>'/rights', // Base URL for Rights. Change if module is nested. 
			   'layout'=>'rights.views.layouts.main',  // Layout to use for displaying Rights. 
			   'appLayout'=>'application.views.layouts.main', // Application layout. 
			   'cssFile'=>'rights.css', // Style sheet file to use for Rights. 
			   'install'=>false,  // Whether to enable installer. 
			   'debug'=>false, 
		),
	 'message' => array(
	 			'class'=>'application.modules.messages.MessageModule',
                'userModel' => 'User',
                'getNameMethod' => 'getFullName',
                'getSuggestMethod' => 'getSuggest',
            ),
	 'cal'=>array('debug'=>true),
	 
		                                'gii'=>array(
											'class'=>'system.gii.GiiModule',
											'password'=>'1234567',
											// If removed, Gii defaults to localhost only. Edit carefully to taste.
											'ipFilters'=>array('127.0.0.1','::1','192.168.9.13','192.168.9.17'),
											
										),	
										'gii'=>array(
												'class'=>'system.gii.GiiModule',
												'password'=>'1',
												// If removed, Gii defaults to localhost only. Edit carefully to taste.
												'ipFilters'=>array('127.0.0.1','::1','192.168.9.13','*'),
															'generatorPaths' => array(
															'application.gii'  //Ajax Crud template path
												 ),
												 ),	
		
	),

	// application components
	'components'=>array(
	
	'request'=>array(
            //'enableCsrfValidation'=>true,
			//'enableCookieValidation'=>true,
        ),
	'db'=>(defined('DB_CONNECTION') ? array(
                    'connectionString'=>DB_CONNECTION,
                    'username'=>DB_USER,
                    'password'=>DB_PWD,
                    'charset'=>'utf8',
                    'emulatePrepare' => true,
                    'enableParamLogging'=>true,
					'initSQLs'=>array("set time_zone='+00:00';"), 
                ) : array()),
	'messages'=>array(
            'class'=>'CDbMessageSource',
            'onMissingTranslation' => array('TranslateModule', 'missingTranslation'),
        ),
	'translate'=>array(
            'class'=>'application.modules.translate.components.MPTranslate',
            //any avaliable options here
            'acceptedLanguages'=>array(
              
				'en_us'=>'English',
				'af'=>'Afrikaans',
				'sq'=>'shqiptar',
				'ar'=>'العربية',
				'cz'=>'中国的 ',
				'cs'=>'český', 
				'nl'=>'Nederlands', 
				'fr'=>'français', 
				'de'=>'Deutsch', 
				'el'=>'ελληνικά',
				 'gu'=>'Γκουτζαρατικά',
				 'hi'=>'हिंदी',
				'id'=>'Indonesia', 
				'ga'=>'Gaeilge',
				'it'=>'italiano',  
				'ja'=>'日本人',
				'kn'=>'ಕನ್ನಡ', 
				'ko'=>'한국의', 
				'la'=>'Latine',
				'ms'=>'Melayu', 
				'pt'=>'português', 
				'ru'=>'русский', 
				'es'=>'español',
				'ta'=>'தமிழ்',
				'te'=>'తెలుగు',
				'th'=>'ภาษาไทย',
				'uk'=>'Український',
				'ur'=>'اردو',
				'vi'=>'Việt',
				'vi_vn'=>'Tiếng Việt',
				                                                                          
            ),
            
        ),
		'ePdf' => array(
        'class'         => 'ext.yii-pdf.EYiiPdf',
        'params'        => array(
            'mpdf123'     => array(
                'librarySourcePath' => 'application.vendors.mpdf.*',
                'constants'         => array(
                    '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                ),
                'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
               
            ),
            'HTML2PDF' => array(
                'librarySourcePath' => 'application.vendors.html2pdf.*',
                'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
                /*'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                    'orientation' => 'P', // landscape or portrait orientation
                    'format'      => 'A4', // format A4, A5, ...
                    'language'    => 'en', // language: fr, en, it ...
                    'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                    'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                    'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                )*/
            )
        ),
    ),
	
	'ePdfL' => array(
        'class'         => 'ext.yii-pdf.EYiiPdf',
        'params'        => array(
            'mpdf123'     => array(
                'librarySourcePath' => 'application.vendors.mpdf.*',
                'constants'         => array(
                    '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                ),
                'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
               
            ),
            'HTML2PDF' => array(
                'librarySourcePath' => 'application.vendors.html2pdf.*',
                'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
                'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                    'orientation' => 'L', // landscape or portrait orientation
                    'format'      => 'A4', // format A4, A5, ...
                    'language'    => 'en', // language: fr, en, it ...
                    'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                    'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                    'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                )
            )
        ),
    ),

	// Pdf extension Ends
                 
	       
	        'user'=>array(
                'class'=>'RWebUser',
                // enable cookie-based authentication
                'allowAutoLogin'=>true,
                'loginUrl'=>array('/user/login'),
        ),
        
	        
            //Use Cache System by File
            'cache'=>array(
                'class'=>'system.caching.CFileCache',
            ),
		
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
/*		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=openschool',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),*/
		'authManager'=>array(
            'class'=>'RDbAuthManager',
            'connectionID'=>'db',
            'itemTable'=>'authitem',
			'itemChildTable'=>'authitemchild',
			'assignmentTable'=>'authassignment',
			'rightsTable'=>'rights',
        ),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'localtime'=>array(
        'class'=>'LocalTime',
        ),		
		'zip'=>array(
			'class'=>'application.extensions.zip.EZip',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);