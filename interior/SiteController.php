<?php
require_once(FILE_PATH."/protected/extensions/mpdf/mpdf.php");
require_once(FILE_PATH."/protected/extensions/phpmailer/class.phpmailer.php");
error_reporting(0);
set_time_limit(0);
global $msg;
class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	 
	public function actionIndex()
	{
		unset(Yii::app()->session['verifyEmail']);
		unset(Yii::app()->session['cnt']);
		if(isset(Yii::app()->session['userId']))
		{
			$this->redirect($this->createUrl("user/index"));
				exit;
		}
		else
		{			
			$options	=	array();
			$genralObj	=	new General();
			
			$site=_SITENAME_NO_CAPS_;
			$countryObj = new Country();
			$countryData = $countryObj->getCountryList();
			Yii::app()->session['loginflag']	=	0;
			$this->render('index',array('site'=>$site,'countryData'=>$countryData));
		}
	}
	
	
	
	
	function actionFaq()
	{
		$this->render('faq');
	}
	
	function actionprivacyPolicy()
	{
		$this->render('privacyPolicy');
	}
	
	function actionterms()
	{
		$this->render('Terms');
	}
	
	function actioncookiePolicy()
	{
		$this->render('cookiePolicy');
	}
	
	function actionhelpAndSupport()
	{
		$this->render('helpAndSupport');
	}
	
	function actionaboutUs()
	{
		$this->render('aboutUs');
	}
	
	function actionmedia()
	{
		$this->render('media');
	}
	
	function actionpartner()
	{
		
		$this->render('partners');
		
	}
	
	function actionsubmitPartner()
	{
		if(isset($_REQUEST['name']) && $_REQUEST['name'] == "" )
		{
			Yii::app()->user->setFlash('error',"Please enter your name.");
			$this->render('partners',array("data"=>$_POST));
			exit;
		}
		if(isset($_REQUEST['businessName']) && $_REQUEST['businessName'] == "" )
		{
			Yii::app()->user->setFlash('error',"Please enter your business name.");
			$this->render('partners',array("data"=>$_POST));
			exit;
		}
		if(isset($_REQUEST['email']) && $_REQUEST['email'] == "" )
		{
			Yii::app()->user->setFlash('error',"Please enter your email address.");
			$this->render('partners',array("data"=>$_POST));
			exit;
		}
		if(isset($_REQUEST['number']) && $_REQUEST['number'] == "" )
		{
			Yii::app()->user->setFlash('error',"Please enter your phone number.");
			$this->render('partners',array("data"=>$_POST));
			exit;
		}
		if(isset($_REQUEST['number']) && !is_numeric($_REQUEST['number']))
		{
			Yii::app()->user->setFlash('error',"Please enter valid phone number.");
			$this->render('partners',array("data"=>$_POST));
			exit;
		}
		
		$bool =  preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/", $_REQUEST['email']);
		if($bool == false)
		{
			Yii::app()->user->setFlash('error',"Please enter valid email address.");
			$this->render('partners',array("data"=>$_POST));
			exit;
		}
		$Yii = Yii::app();	
		$recipients = $_POST['email'];							
		$email = 'info@kwexc.com';							
		$subject= 'Partners';
		
		$Yii = Yii::app();	
		$message = "<table>";
		$message .=  "<tr><td>Position : </td><td>".$_POST['name']."</td></tr>";
		$message .=  "<tr><td>Position : </td><td>".$_POST['position']."</td></tr>";
		$message .=  "<tr><td>Business Name : </td><td>".$_POST['businessName']."</td></tr>";
		$message .=  "<tr><td>Business Type : </td><td>".$_POST['businessType']."</td></tr>";
		$message .=  "<tr><td>Address : </td><td>".$_POST['address']."</td></tr>";
		$message .=  "<tr><td>City : </td><td>".$_POST['city']."</td></tr>";
		$message .=  "<tr><td>Post Code : </td><td>".$_POST['postCode']."</td></tr>";
		$message .=  "<tr><td>Country : </td><td>".$_POST['country']."</td></tr>";
		$message .=  "<tr><td>Email : </td><td>".$_POST['email']."</td></tr>";
		$message .=  "<tr><td>Phone No : </td><td>".$_POST['number']."</td></tr>";
		$message .=  "<tr><td>Website : </td><td>".$_POST['website']."</td></tr>";
		$message .=  "<tr><td>Information : </td><td>".$_POST['info']."</td></tr>";
		$helperObj = new Helper();
		$mailResponse=$helperObj->sendMail($email,$subject,$message);
		
		if($mailResponse!=true)
		{
			Yii::app()->user->setFlash('error',Yii::app()->params->msg['_EMAIL_SEND_ERROR_']);
			$this->redirect($this->createUrl("site/partner"));
		}
		else
		{	
			Yii::app()->user->setFlash('success',Yii::app()->params->msg['_EMAIL_SEND_']);
			$this->redirect($this->createUrl("site/partner"));
		}
	}
	
	function actionforgot()
	{
		if(isset(Yii::app()->session['userId']))
		{
			$this->redirect($this->createUrl("user/index"));
				exit;
		}
		$data['loginId'] = "asfsadf";
		$this->render('forgot_password_after',$data);
	}
	
	
	/*********** 	Checking Email address  ***********/ 
	function actionchkEmail($type=NULL)
	{
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{
			
			if($type != NULL)
			{
				$userObj = new User();
				$userId='-1';
				if(isset(Yii::app()->session['userId']))
				{
					$userId=Yii::app()->session['userId'];	
				}

				$result=$userObj->chkemail($_REQUEST['email'],$userId);
				
				if($result!='')
				{				
					echo true;
				}
				else
				{
					echo false;
				}
			}
		}
		
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
			{
	    		echo $error['message'];
			}
			else
			{
	        	$this->render('error', $error);
				exit;
			}
		}
		$this->render('error', $error);
	}
	
	public function actionMerror()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('merror', $error);
	    }
	}

	public function actionAbout()
	{

			$this->render('about');

	}	
	
	public function actionSms()
	{

			$this->render('sms');

	}	
	
	public function actionMobile()
	{

			$this->render('mobile');
		
	}	
	
	public function actionTos()
	{
			
			$this->render('termscondition');
		
	}	
	
	
	public function actionPrivacy()
	{
		
			$this->render('privacy');
			
	}
	
	public function actionSignin()
	{
		$this->loginRedirect();
		$model=new Login();
		if(isset(Yii::app()->session['loginId']))
		{
				$this->redirect($this->createUrl("user/index"));
				exit;
		}
		if(isset($_POST['LoginForm']))
		{
			$this->actionlogin();		
		}
		Yii::app()->session['loginflag']	=	1;
		$this->render('signin',array('model'=>$model));
	}
	
	public function actionSupport()
	{
		if(isset(Yii::app()->session['userId']))
		{
			$this->redirect($this->createUrl("user/index"));
				exit;
		}
			$this->render('help');
			
	}
	
	public function actionHelpType()
	{
		if(isset($_POST['help']) && $_POST['help']=="forgot_password")
		{		
			$data = array('loginId'=>'');
			$this->render('forgot_password',$data);	
		}
		else if(isset($_POST['help']) && $_POST['help']=="activate")
		{
			$data = array('loginId'=>'');
			$this->render('activate',$data);
		}
		else if(isset($_POST['help']) && $_POST['help']=="faq")
		{
			$data = array('loginId'=>'');
			$this->render('faq',$data);
		}
		else
		{
			$data = array('name'=>'','email'=>'','comment'=>'','ajax'=>'');
			$this->render('contactus',$data);
		}
	}
	
	/**
	 * Displays the contact page
	 */
	
	/*********** 	Employer Seeker email verification  function  ***********/ 
	public function actionVerifyAccount($key,$id,$lng='eng')
	{
		global $msg;
		
		
		Yii::app()->session['prefferd_language']=$lng;
		if($key=='' || $id=='')
		{	
			Yii::app()->user->setFlash('error', $msg['MISSING_PARAMETER']);
			$this->redirect($this->createUrl("user/index"));
		}
		
	 	$userObj	=	new Users();
		$loginObj	=	new Login();
		$status	=	$userObj->verifyaccount($key,$id);
		if($status == 1)
		{
			$algoObj= new Algoencryption();
			$pid=$algoObj->decrypt($id);
			
			//$result_user = $userObj->getLoginId($pid);
			unset(Yii::app()->session['key']);
			unset(Yii::app()->session['id']);
			unset(Yii::app()->session['form1']);
			unset(Yii::app()->session['form2']);
			Yii::app()->user->setFlash('success', $msg['VERIFY_LOG_MSG']);
			$this->redirect(array("site/signin"));
			
		}
		else if($status == 2)
		{
			Yii::app()->user->setFlash('error', $msg['LOGIN_MSG']);
			$this->redirect(array("site/index"));
		} 
		else if($status == 3)
		{
			Yii::app()->user->setFlash('error', $msg['FAIL_MSG']);
			$this->redirect(array("site/index"));
		}
		else
		{
			Yii::app()->user->setFlash('error', $msg['_ACTIVATION_LINK_EXPIRE_']);
			$this->redirect(array("site/index"));
		}
	}
	
	function actionregisterFirstSlap()
	{
		
		
		$algoObj = new Algoencryption();
		Yii::app()->session['key'] = $_GET['key'];
		Yii::app()->session['email'] = $_GET['email'];
		Yii::app()->session['id'] = $algoObj->decrypt($_GET['id']);
		if(isset($_GET['companyName']))
		{
			Yii::app()->session['companyName'] =  $_GET['companyName'];
		}
		if(isset($_GET['phoneNumber']))
		{
			Yii::app()->session['phoneNumber'] = $_GET['phoneNumber'];
		}
		$userObj = new Users();
		$result = $userObj->getVerifiedUser($_GET['email']);
		
		if(empty($result))
		{
			$userObj = new Users();
			$result = $userObj->getUserIdByLoginId($_GET['email']);
			$dbTime = strtotime(date("Y-m-d H:i:s", strtotime($result['createdAt'])) . " +2 days");
			$nowTime = strtotime(date("Y-m-d H:i:s"));
			
			if($dbTime > $nowTime)
			{
				
				$currObj = new Currency();
				$currencyData = $currObj->getCurrencyList();
				$countryObj = new Country();
				$countryData = $countryObj->getCountryList();
				$bussNatureObj = new BusinessNature();
				$bussNatureData = $bussNatureObj->getBusinessNatureList();
		
				$this->render("registration",array("countryData"=>$countryData,"currencyData"=>$currencyData,"bussNatureData"=>$bussNatureData));
								
				
			}
			else
			{
				Yii::app()->user->setFlash('error',Yii::app()->params->msg['_LINK_EXPIRED_']);
				$this->redirect(Yii::app()->params->base_path."site");
			}
		}
		else
		{
			Yii::app()->user->setFlash('error',Yii::app()->params->msg['_LINK_EXPIRED_']);
			$this->redirect($this->createUrl("site/index"));
		}
	}
	
	function actioncallBackToAdmin()
	{
		 
								 
		Yii::app()->session['phoneNumber'] = $_REQUEST['phonenumber'];
		Yii::app()->session['companyName'] = base64_encode($_REQUEST['companyReqCall']); 
		Yii::app()->session['contactPersonFirstName'] =  $_REQUEST['contactpersonFirstNameReqCall'];
		Yii::app()->session['contactPersonLastName'] =  $_REQUEST['contactpersonLastNameReqCall'];
		
		
		if(isset(Yii::app()->session['email']) && Yii::app()->session['email'] != "")
		{
			$Yii = Yii::app();	
			$email = Yii::app()->session['email'];							
			$subject= 'Kwexc will be calling you shortly';
			
			
			
			
			$userObj = new Users();
			$data = $userObj->getUserIdByLoginId($email);
			
			if(isset($data['id']) && $data['id'] != "")
			{
				if($data['callback'] == 0)
				{
					
				
					$callback = array();
					$callback['comapanyNameTemp'] = $_REQUEST['companyReqCall'];
					$callback['phoneNumberTemp'] = Yii::app()->session['phoneNumber'];
					$callback['firstName'] = Yii::app()->session['contactPersonFirstName'];
					$callback['lastName'] = Yii::app()->session['contactPersonLastName'] ;
					$callback['callback'] = 1;
					$userObj = new Users();
					$userObj->setData($callback);
					$userObj->insertData($data['id']);
				
					$Yii = Yii::app();
					
					$message = file_get_contents(Yii::app()->params->base_url."templatemaster/accountCallBack");
					$subject = "Kwexc will be calling you shortly";
					
					$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->base_url,$message);
					$message = str_replace("_FIRSTNAME_",$_REQUEST['contactpersonFirstNameReqCall'],$message);
					
					
					$helperObj = new Helper();
					$mailResponse=$helperObj->sendMail($email,$subject,$message);
					unset(Yii::app()->session['email']);
					
					
					$rational = array();
					$rational['first_name'] = $_REQUEST['contactpersonFirstNameReqCall'];
					$rational['last_name'] = $_REQUEST['contactpersonLastNameReqCall'];
					$rational['email'] = $email;
					$rational['company'] = $_REQUEST['companyReqCall'];
					$rational['phone'] = $_REQUEST['phonenumber'];
					
					$rational['oid'] = '00Db0000000Jjhw';
					$rational['retURL'] = 'http://www.kwexc.com';
					$rational['00Nb0000001Uwee '] = 'Corporate';
					$rational['lead_source '] = 'Inbound Web request';
					$rational['Web_Form_Source__c'] = 'KWEXC';
					$rational['00Nb0000001VDbP'] = 'A0731 KWEXC';
					
					
					$rational['debug'] = 1;
					$rational['debugEmail'] = "jim.warner@rationalfx.com";
					
					//$rational['00N20000002s0TB'] = 
					
					$str = http_build_query($rational);
					
					
					
					$base_url = "https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8";
					$fields_string="";	
					$result = $this->rest($base_url,$str);	
					
					if($mailResponse!=true)
					{
						Yii::app()->user->setFlash('error', Yii::app()->params->msg['_EMAIL_SEND_ERROR_']);
						$this->redirect($this->createUrl("site/index"));
					}
					else
					{	
					
						Yii::app()->user->setFlash('success', Yii::app()->params->msg['_CALLBACK_']);
						
						$currObj = new Currency();
						$currencyData = $currObj->getCurrencyList();
						$countryObj = new Country();
						$countryData = $countryObj->getCountryList();
						$bussNatureObj = new BusinessNature();
						$bussNatureData = $bussNatureObj->getBusinessNatureList();
				
						$this->render("registration_after_callback",array("countryData"=>$countryData,"currencyData"=>$currencyData,"bussNatureData"=>$bussNatureData));
						
						//$this->redirect(Yii::app()->params->base_path."site/index");
					}
				}
				else
				{
					
					Yii::app()->user->setFlash('error', Yii::app()->params->msg['_CALL_REQUEST_ALREADY_SUBMIT_']);
					$currObj = new Currency();
					$currencyData = $currObj->getCurrencyList();
					$countryObj = new Country();
					$countryData = $countryObj->getCountryList();
					$bussNatureObj = new BusinessNature();
					$bussNatureData = $bussNatureObj->getBusinessNatureList();
			
					$this->render("registration",array("countryData"=>$countryData,"currencyData"=>$currencyData,"bussNatureData"=>$bussNatureData));
					//$this->redirect(Yii::app()->params->base_path."site/index");
					exit;
				}
			}else{
				
					Yii::app()->user->setFlash('error', Yii::app()->params->msg['_CALL_REQUEST_ALREADY_SUBMIT_']);
					$currObj = new Currency();
					$currencyData = $currObj->getCurrencyList();
					$countryObj = new Country();
					$countryData = $countryObj->getCountryList();
					$bussNatureObj = new BusinessNature();
					$bussNatureData = $bussNatureObj->getBusinessNatureList();
			
					$this->render("registration",array("countryData"=>$countryData,"currencyData"=>$currencyData,"bussNatureData"=>$bussNatureData));
					//$this->redirect(array("site/index"));
				}
		}else{
					Yii::app()->user->setFlash('error', Yii::app()->params->msg['_CALL_REQUEST_ALREADY_SUBMIT_']);
					$currObj = new Currency();
					$currencyData = $currObj->getCurrencyList();
					$countryObj = new Country();
					$countryData = $countryObj->getCountryList();
					$bussNatureObj = new BusinessNature();
					$bussNatureData = $bussNatureObj->getBusinessNatureList();
					
					$this->render("registration",array("countryData"=>$countryData,"currencyData"=>$currencyData,"bussNatureData"=>$bussNatureData));
			//$this->redirect(array("site/index"));
		}
	}
	
	function actionafterCallBack()
	{
			$currObj = new Currency();
			$currencyData = $currObj->getCurrencyList();
			$countryObj = new Country();
			$countryData = $countryObj->getCountryList();
			$bussNatureObj = new BusinessNature();
			$bussNatureData = $bussNatureObj->getBusinessNatureList();
			$this->render("registration",array("countryData"=>$countryData,"currencyData"=>$currencyData,"bussNatureData"=>$bussNatureData));
	}
		
	
	function actionSubmitDetails()
	{
		error_reporting(0);
		$algoObj	=	new Algoencryption();
		$data = array();
		$data = $_POST;
		
		$_POST['userId'] = Yii::app()->session['id'];
		
		$businessDetails = array();
		$businessDetails['companyName'] = htmlentities($_POST['companyName']);
		$businessDetails['regNumber'] = $_POST['regNumber'];
		if(isset($_POST['sales_turnover']) && is_numeric($_POST['sales_turnover']))
		{
			$businessDetails['sales_turnover'] = $_POST['sales_turnover'];
		}
		else
		{
			//VE15116EN/B/W  2.50 i5 500 4 GB 1 GB 8/11 15.5
			$currObj = new Currency();
			$currencyData = $currObj->getCurrencyList();
			$countryObj = new Country();
			$countryData = $countryObj->getCountryList();
			$bussNatureObj = new BusinessNature();
			$bussNatureData = $bussNatureObj->getBusinessNatureList();
			Yii::app()->user->setFlash("error",$result['message']);
			$this->render("registration_after_callback",array('data'=>$data,"countryData"=>$countryData,"currencyData"=>$currencyData,"bussNatureData"=>$bussNatureData));
			exit;
			
		}
		
		if(isset($_POST['incorporation_date']) && $_POST['incorporation_date'] != "")
		{
			$businessDetails['incorporation_date'] =  date("Y-m-d",strtotime($_POST['incorporation_date']));
		}
		$businessDetails['companyType'] = $_POST['companyType'];
		$businessDetails['specify'] = $_POST['specify'];
		$businessDetails['nature'] = $_POST['nature'];
		$businessDetails['website'] = $_POST['website'];
		$businessDetails['phoneNumber'] = $_POST['phoneNumber'];
		$businessDetails['bus_country'] = $_POST['bus_country'];
		$businessDetails['bus_postal_code'] = $_POST['bus_postal_code'];
		$businessDetails['bus_address'] = htmlentities($_POST['bus_address1']." , ".$_POST['bus_address2']);
		$businessDetails['bus_address2'] = htmlentities($_POST['bus_address2']);
		
		$businessDetails['bus_city'] = htmlentities($_POST['bus_city']);
		if(isset($_POST['bus_reg_add']) && $_POST['bus_reg_add'] != "on")
		{
			$businessDetails['bus_reg_add'] = 1 ;
		}
		$businessDetails['trd_coutry'] = $_POST['trd_country'];
		$businessDetails['trd_postal_code'] = $_POST['trd_postal_code'];
		$businessDetails['trd_address'] = $_POST['trd_address1']." ".$_POST['trd_address2'];
		$businessDetails['trd_city'] = $_POST['trd_city'];
		$businessDetails['userId'] = $_POST['userId'];
		$businessDetails['created'] = date('Y-m-d H:i:s');
		
		
		$personDetails = array();
		$personDetails['title'] = htmlentities($_POST['title']);
		$personDetails['firstName'] = htmlentities($_POST['firstName']);
		//$personDetails['middleName'] = $_POST['middleName'];
		$personDetails['lastName'] = htmlentities($_POST['lastName']);
		$personDetails['birthDate'] =  date("Y-m-d",strtotime($_POST['birthDate']));
		$personDetails['passport_no'] = htmlentities($_POST['passport_no']);
		
		$personDetails['userId'] = $_POST['userId'];
		$personDetails['created'] = date('Y-m-d H:i:s');
		
		$CallBack = array();
		$CallBack['callback'] = 2;
		$userObj = new Users();
		$userObj->setData($CallBack);
		$userObj->insertData($_POST['userId']);
		
		$otherDetails = array();
		$otherDetails['reason'] = htmlentities($_POST['why']);
		$otherDetails['paymentFrom'] = $_POST['paymentFrom'];
		$otherDetails['paymentTo'] = $_POST['paymentTo'];
		$otherDetails['volume'] = $_POST['volume'];
		$otherDetails['currency'] = $_POST['currency'];
		$otherDetails['referralCode'] = $_POST['referralCode'];
		$otherDetails['hearFrom'] = $_POST['hearFrom'];
		$otherDetails['securityQuetion'] = $_POST['securityQuetion'];
		$otherDetails['answer'] = htmlentities($_POST['answer']);
		
		if(isset($_POST['checkbox1']) && $_POST['checkbox1'] != "on")
		{
			$otherDetails['checkbox1'] = 1 ;
		}
		if(isset($_POST['checkbox2']) && $_POST['checkbox2'] != "on")
		{
			$otherDetails['checkbox2'] = 1 ;
		}
		
		$otherDetails['userId'] = $_POST['userId'];
		
		$validationOBJ = new Validation();
		$result = $validationOBJ->register_first($businessDetails);
		if($result['status']!=0)
		{
			//VE15116EN/B/W  2.50 i5 500 4 GB 1 GB 8/11 15.5
			$currObj = new Currency();
			$currencyData = $currObj->getCurrencyList();
			$countryObj = new Country();
			$countryData = $countryObj->getCountryList();
			$bussNatureObj = new BusinessNature();
			$bussNatureData = $bussNatureObj->getBusinessNatureList();
			Yii::app()->user->setFlash("error",$result['message']);
			$this->render("registration_after_callback",array('data'=>$data,"countryData"=>$countryData,"currencyData"=>$currencyData,"bussNatureData"=>$bussNatureData));
			exit;
			
		}
		
		$validationOBJ = new Validation();
		$result = $validationOBJ->register_second($personDetails);
		if($result['status']!=0)
		{
			
			$currObj = new Currency();
			$currencyData = $currObj->getCurrencyList();
			$countryObj = new Country();
			$countryData = $countryObj->getCountryList();
			$bussNatureObj = new BusinessNature();
			$bussNatureData = $bussNatureObj->getBusinessNatureList();
			Yii::app()->user->setFlash("error",$result['message']);
			$this->render("registration_after_callback",array('data'=>$data,'countryData'=>$countryData,"currencyData"=>$currencyData,"bussNatureData"=>$bussNatureData));
			exit;
		}
		
		$validationOBJ = new Validation();
		$result = $validationOBJ->register_third($data);
		if($result['status']!=0)
		{
			$currObj = new Currency();
			$currencyData = $currObj->getCurrencyList();
			$countryObj = new Country();
			$countryData = $countryObj->getCountryList();
			$bussNatureObj = new BusinessNature();
			$bussNatureData = $bussNatureObj->getBusinessNatureList();
			Yii::app()->user->setFlash("error",$result['message']);
			$this->render("registration_after_callback",array('data'=>$data,'countryData'=>$countryData,"currencyData"=>$currencyData,"bussNatureData"=>$bussNatureData));
			exit;
		}
		
		$bussObj = new BusinessDetails();
		$bussObj->setData($businessDetails);
		$bussObj->insertData();
		
		
		$personObj = new PersonAccount();
		$personObj->setData($personDetails);
		$personObj->insertData();
		
		$otherObj = new PersonOtherInfo();
		$otherObj->setData($otherDetails);
		$otherObj->insertData();
		
		
		$fxDetailsObj = new FxDetails();
		$fxDetails = $fxDetailsObj->getAllFx();
		foreach($fxDetails as $row)
		{
			$fxRel['userId'] = Yii::app()->session['id'];
			$fxRel['fxId'] = $row['fx_id'];
			$fxRel['status'] = 0;
			$fxRel['created'] = date("Y-m-d H:i:s");
			$UserFxRelation = new UserFxRelation();
			$UserFxRelation->setData($fxRel);
			$UserFxRelation->insertData();
		}
		
		$directorObj = new Directors();
		$shareHolder = $directorObj->getUsersDirectorList(Yii::app()->session['id']);
		
		$rational = array();
		$rational['company'] = $businessDetails['companyName'];
		$rational['00Nb0000001Uwa2'] = date('d-m-Y',strtotime($businessDetails['incorporation_date']));
		
		$rational['00Nb0000001UwUE'] = $businessDetails['regNumber'];
		$rational['00Nb0000003ePgZ'] = $businessDetails['companyType'];
		$rational['00Nb0000001Uwa7'] = $businessDetails['nature'];
		$rational['00Nb0000001UwZn'] = $otherDetails['paymentTo'];
		$rational['00N20000002rvVO'] = $otherDetails['currency'] ;
		$rational['00Nb0000001Uvpp'] = $_POST['sales_turnover'];
		$rational['00Nb0000003eKVO'] = $_POST['why'];
		$rational['00Nb0000001UwBM'] = $otherDetails['volume'];
		$rational['00Nb0000003fcnl'] = $otherDetails['currency'];
		
		$rational['street'] = $businessDetails['bus_address'].', '.$businessDetails['bus_address2'].', '.$businessDetails['bus_city'].', '.$businessDetails['bus_postal_code'];
		
		if(isset($businessDetails['trd_address']) && trim($businessDetails['trd_address']) != '')
		{
			
			$rational['00Nb0000003eL5U'] = $businessDetails['trd_address'].', '.$businessDetails['trd_city'].', '.$businessDetails['trd_postal_code'];
		}
		
		$rational['phone'] = $businessDetails['phoneNumber'];
		$rational['fax'] = 0;
		$rational['URL'] = $businessDetails['website'];
		$rational['salutation'] = $personDetails['title'];
		$rational['first_name'] = $personDetails['firstName'];
		$rational['last_name'] = $personDetails['lastName'];
		
		$rational['00Nb0000003eKgN'] =  date("d-m-Y",strtotime($_POST['birthDate']));
		$rational['mobile'] = $businessDetails['phoneNumber'];
		$rational['email'] = Yii::app()->session['email'];
		$rational['00Nb0000003eRI3'] = $personDetails['passport_no'];
		
		$i=1;
		$personDetails['shareholder1'] = '';
		$personDetails['shareholder2'] = '';
		$personDetails['shareholder3'] = '';
		$personDetails['shareholder4'] = '';

		
		foreach($shareHolder as $row)
		{
			$personDetails['shareholder'.$i] = $row['firstName']." ".$row['lastName'];
			$personDetails['shareholderOwnership'.$i] = $row['ownership'];
			$i++;
		}
		if($personDetails['shareholder1'] != '')
		{
			$rational['00Nb0000003eZjj'] =  $personDetails['shareholder1'];
			$rational['00Nb0000003eZrJ'] =  $personDetails['shareholderOwnership1'];
			
		}
		if($personDetails['shareholder2'] != '')
		{
			$rational['00Nb0000003eZjo'] =  $personDetails['shareholder2'];
			$rational['00Nb0000003eZv1'] =  $personDetails['shareholderOwnership2'];
		}
		if($personDetails['shareholder3'] != '')
		{
			$rational['00Nb0000003eZjt'] =  $personDetails['shareholder3'];
			$rational['00Nb0000003eZv6'] =  $personDetails['shareholderOwnership3'];
		}
		if($personDetails['shareholder4'] != '')
		{
			$rational['00Nb0000003eZjy'] =  $personDetails['shareholder4'];
			$rational['00Nb0000003eZvB'] =  $personDetails['shareholderOwnership4'];
		}
		
		
		$rational['oid'] = '00Db0000000Jjhw';
		$rational['retURL'] = 'http://www.kwexc.com';
		$rational['Web_Form_Source__c'] = 'KWEXC';
		$rational['00Nb0000001VDbP'] = 'A0731 KWEXC';
		$rational['00Nb0000001Uwee'] = 'Corporate';
		$rational['lead_source'] = 'Inbound Web request';
		$rational['debug'] = 1;
		$rational['debugEmail'] = "jim.warner@rationalfx.com";
		
		//$rational['00N20000002s0TB'] = 
		
		$str = http_build_query($rational);
		
		$base_url = "https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8";
		$fields_string="";	
		$result = $this->rest($base_url,$str);
		
		
		$userObj = new Users();
		$data11['firstName'] = $personDetails['firstName'];
		$data11['lastName'] = $personDetails['lastName'];
		$data11['isVerified']=1;
		
		$userObj = new Users();
		$userObj->setData($data11);
		$userObj->insertData(Yii::app()->session['id']);
		
		$this->actionraiseProfilePdf(Yii::app()->session['id']);
		
		Yii::app()->session['userId']=Yii::app()->session['id'];
		Yii::app()->session['loginId']=Yii::app()->session['id'];
		Yii::app()->session['email']=$rational['email'];
		
		Yii::app()->session['fullname'] =$personDetails['firstName'].'&nbsp;'.$personDetails['lastName'];
		Yii::app()->session['firstName']=$personDetails['firstName'];
		
		Yii::app()->session['status'] =  0;
		$this->redirect("index.php?r=user/index");
		exit;
		
	}
	
	function actionraiseProfilePdf($id)
	{
		$userObj = new Users();
		$userData = $userObj->getAllProfileData($id);
		
		$securityObj =  new SecurityQuestions();
		$securityData = $securityObj->getSecurityQuestionById($userData['securityQuetion']);
		
		
		$directorObj = new Directors();
		$shareHolder = $directorObj->getUsersDirectorList(Yii::app()->session['id']);
		
		$i=1;
		$personDetails['shareholder1'] = '';
		$personDetails['shareholder2'] = '';
		$personDetails['shareholder3'] = '';
		$personDetails['shareholder4'] = '';

		foreach($shareHolder as $row)
		{
			$personDetails['shareholder'.$i] = $row['firstName']." ".$row['lastName'];
			$message .='<tr>
		 	<td align="center"><span>Share Holder '.$i.' </span></td>
			<td align="center">'.$personDetails['shareholder'.$i].'</td>
		  </tr>';
			
			$i++;
		}
		
		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		<style type="text/css">
		body,td,th {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		
		.border
		{
		   border-left:1px;
		   border-bottom:1px;
		   border-top:1px;
		   border-right:1px;
		}
		
		.noborder
		{
		
		   border-left:0px;
		   border-bottom:0px;
		}
		
		.noborder1
		{
		
		   border-left:0px;
		   border-bottom:0px;
		   border-top:0px;
		}
		</style>
		</head>
		<body>
		<h1 align="center">User Profile</h1>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right">DATE: '. date('F d, Y').'</td>
		  </tr>
		</table>
		<p>&nbsp;</p>
		
		<table width="100%" border="1" cellpadding="5"  cellspacing="0">
		  <tr align="center" valign="middle">
		    <td align="center"><strong>Field Name</strong></td>
			<td  align="center"><strong>Value</strong></td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Company Name</span></td>
			<td align="center">'.$userData['companyName'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Register No</span></td>
			<td align="center">'.$userData['regNumber'].'</td>
		  </tr>
		   <tr>
		 	<td align="center"><span>Incorporation Date</span></td>
			<td align="center">'.$userData['incorporation_date'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Company Type</span></td>
			<td align="center">'.$userData['companyType'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Nature</span></td>
			<td align="center">'.$userData['nature'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Sales Turnover</span></td>
			<td align="center">'.$userData['sales_turnover'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Reason</span></td>
			<td align="center">'.$userData['reason'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Website</span></td>
			<td align="center">'.$userData['website'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Phone No</span></td>
			<td align="center">'.$userData['phoneNumber'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Bussiness Country</span></td>
			<td align="center">'.$userData['bus_country'].'</td>
		  </tr>
		  
		   <tr>
		 	<td align="center"><span>Postal Code</span></td>
			<td align="center">'.$userData['bus_postal_code'].'</td>
		  </tr>
		   <tr>
		 	<td align="center"><span>Bus Address</span></td>
			<td align="center">'.$userData['bus_address'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Bussiness City</span></td>
			<td align="center">'.$userData['bus_city'].'</td>
		  </tr>
		  
		 
		  <tr>
		 	<td align="center"><span>First Name</span></td>
			<td align="center">'.$userData['firstName'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Last Name</span></td>
			<td align="center">'.$userData['lastName'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Email Id</span></td>
			<td align="center">'.$userData['loginId'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Birth Date</span></td>
			<td align="center">'.$userData['birthDate'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Passport Number</span></td>
			<td align="center">'.$userData['passport_no'].'</td>
		  </tr>
		  
		   '.$message.'
		  
		  
		  <tr>
		 	<td align="center"><span>PaymentFrom</span></td>
			<td align="center">'.$userData['paymentFrom'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>PaymentTo</span></td>
			<td align="center">'.$userData['paymentTo'].'</td>
		  </tr>
		   <tr>
		 	<td align="center"><span>Volume</span></td>
			<td align="center">'.$userData['volume'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>Currency</span></td>
			<td align="center">'.$userData['currency'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>HearFrom</span></td>
			<td align="center">'.$userData['hearFrom'].'</td>
		  </tr>
		    <tr>
		 	<td align="center"><span>ReferralCode</span></td>
			<td align="center">'.$userData['referralCode'].'</td>
		  </tr>
		  <tr>
		 	<td align="center"><span>SecurityQuetion</span></td>
			<td align="center">'.$securityData['question'].'</td>
		  </tr>
		   <tr>
		 	<td align="center"><span>Answer</span></td>
			<td align="center">'.$userData['answer'].'</td>
		  </tr>
		</table>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p align="center">
		<strong>Thank you for using kwexc.</strong>
		</p>
		</body>
		</html>';	
		
		
		//$mpdf = new mPDF();
		//$mpdf->SetProtection(array('copy','print'), '123456', '111111');
		//$mpdf->WriteHTML($html);
		//$mpdf->Output(FILE_PATH."assets/upload/userProfile/userProfile".$id.".pdf", 'F');
		
		$subject = "You have a new lead via Kwexc";
		
 		$fxDetailsObj = new FxDetails(); 
		$fxData = $fxDetailsObj->getAllFx();
		
		foreach($fxData as $row)
		{
			
			$mpdf = new mPDF();
			$mpdf->SetProtection(array('copy','print'), $row['rawPassword'], $row['rawPassword']);
			$mpdf->WriteHTML($html);
			$mpdf->Output(FILE_PATH."assets/upload/userProfile/userProfile".$id.".pdf", 'F');
		
			
			$message = file_get_contents(Yii::app()->params->base_url."templatemaster/sendUserProfileToAdmin");
			$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->base_url,$message);
			$message = str_replace("_FXNAME_",$row['fx_name'],$message);
			$mail = new PHPMailer(); // defaults to using php "mail()"
			$mail->SetFrom('support@kwexc.com', 'Kwexc Team');
			$mail->AddReplyTo("support@kwexc.com","Kwexc Team");
			$mail->AddAddress($row['person_email'], $row['person_email']);
			$mail->Subject    = "You have a new lead via Kwexc";
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			$mail->MsgHTML($message);
			$mail->AddAttachment("assets/upload/userProfile/userProfile".$id.".pdf");      // attachment
			if(!$mail->Send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
				//echo "Message sent!";
			
			}
		
		}
		return true;
		
		
	}
	
	function rest($url,$fields_string)
	{
		//open connection
		$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,count($fields_string));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
		//execute post
		$result = curl_exec($ch);
		//close connection
		curl_close($ch);
		return $result;

	}
		
	function actionPrefferedLanguage($lang='eng')
	{
		if(isset(Yii::app()->session['userId']) && Yii::app()->session['userId']>0)
		{
			$userObj=new User();
			$userObj->setPrefferedLanguage(Yii::app()->session['userId'],$lang);
		}
		
		Yii::app()->session['prefferd_language']=$lang;

		$this->redirect($this->createUrl("site/index"));
	}
	
	
	/*********** 	Redirecting to Main signUp page   ***********/ 
	function actionsignUpMain($type='Seeker',$admin=NULL)
	{
		global $msg;
		
		$Yii=Yii::app();
		if($this->isLogin())
		{
			header("location:".BASE_PATH);
			exit;
		}
		if(isset($_GET['userId']) && $_GET['userId'] != '' && isset($_GET['listId']) && $_GET['listId'] != '')
		{
			Yii::app()->session['userIdForNetwork'] = $_GET['userId'];
			Yii::app()->session['listId'] = $_GET['listId'];
			
		}
		$userObj=new Users();
		$algObj = new Algoencryption();	
		$_POST['agreementAccepted']= $algObj->encrypt(1);
		if($type=="Employer")
		{
			$userObj=new Users();
			$statelist['stats']=$userObj->getEmployerRegisterData();			
			if(isset($admin))
			{
				$_POST['admin'] = $admin;
			}
			$_POST	=	$_POST;
			$this->render("employersignup",array_merge($res,$statelist,$_POST));
		}
		else
		{
			if((isset($_POST['fName'])) && $_POST['fName']==$msg['_FIRST_NAME_'])
			{
				$_POST['fName']='';
			}			
			if((isset($_POST['lName'])) && $_POST['lName']==$msg['_LAST_NAME_'])
			{
				$_POST['lName']='';
			}
			if((isset($_POST['email'])) && $_POST['email']==$msg['_EMAIL_'])
			{
				$_POST['email']='';
			}
			if((isset($_POST['phoneNumber'])) && $_POST['phoneNumber']==$msg['_PHONE_NUMBER_'])
			{
				$_POST['phoneNumber']='';
			}
			if(isset($admin))
			{
				$_POST['admin'] = $admin;
			}
		
			$countryObj = new Country();
			$countryData = $countryObj->getCountryList();
			$this->render("index",array("countryData"=>$countryData,'post'=>$_POST));	
		}	
	}
	
	/*********** 	Submiting User data   ***********/ 
	function actionSignUp()
	{
		//error_reporting(E_ALL);
		global $msg;	
		$userObj=new Users();
		$validator = new FormValidator();	
		if(!empty($_POST))
		{
			$generalObj	=	new General();
		
			/*$password_flag = $generalObj->check_password($_POST['password'], $_POST['cpassword']);
			switch ($password_flag) {
				case 0:
					$pass_flag = 0;
	
					break;
				case 1:
	
					Yii::app()->user->setFlash("error", "Please don't blank password.");
					$pass_flag = 1;
					break;
				case 2:
	
					Yii::app()->user->setFlash("error", "Password minimum length need to Eight character.");
					$pass_flag = 1;
					break;
				case 3:
					Yii::app()->user->setFlash("error", "Password must contain one letter and number.");
	
					$pass_flag = 1;
					break;
				case 5:
					Yii::app()->user->setFlash("error", "Password must contain one letter and number.");
					$pass_flag = 1;
					break;
				//case 4:
					Yii::app()->user->setFlash("error", "Password minimum need to one upercase.");
					$pass_flag = 1;
					break;
				case 5:
					Yii::app()->user->setFlash("error", "Password minimum need to one digit number.");
					$pass_flag = 1;
					break;
				case 6:
					Yii::app()->user->setFlash("error", "Password minimum need to one special character.");
					$pass_flag = 1;
					break;//
				case 7:
					Yii::app()->user->setFlash("error", "Password is not match with confirm password.");
					$pass_flag = 1;
					break;
			}
			if($password_flag!=0)
			{
				$this->actionsignUpMain();exit;
			}
			else
			{*/
			
			
			if(isset($_POST['companyName']))
			{
				$_POST['companyName'] = htmlentities($_POST['companyName']);
			}
			if(isset($_POST['password']))
			{
				$_POST['password'] = htmlentities($_POST['password']);
			}
			
				$validationOBJ = new Validation();
				$result = $validationOBJ->signup($_POST);
				
				if($result['status'] == 0)
				{
					if(isset($_POST['phoneNumber']) && strlen($_POST['phoneNumber']) >14  && strlen($_POST['phoneNumber']) < 15 )	{
						Yii::app()->user->setFlash('success','Phone number is minimum 14 digits and maximum 15 digits.');
						$this->redirect($this->createUrl("site/signUpMain"));
					}
					
					//Add user entry
					$userResponse	=	$userObj->addRegisterUser($_POST);
					$algoObj = new Algoencryption();
					if($userResponse['status'] == 0)
					{
						unset(Yii::app()->session['userId']);
						Yii::app()->session['verifyEmail'] = 1;
						$this->redirect(Yii::app()->params->base_path."site/verifyEmail/email/".$_POST['email']);	
					}
					else
					{	
						$resMessage = array();
						$resMessage = $_POST;
						$result['status'] = 0;
						$resMessage['message'] = $userResponse['message'];
						
						$this->render("index",$resMessage);
						exit;
					}	
				}
				else
				{
					$resMessage = array();
					$result['status'] = 0;
					$resMessage = $_POST;
					$resMessage['message'] = $result['message'];
					$this->render("index",$resMessage);
					//$this->actionsignUpMain();exit;
				}
			//}
		}
		else
		{
			if(isset($_POST['admin']) && $_POST['admin']=='admin'){
				$this->redirect($this->createUrl("site/signUpMain/type/Seeker/admin"));
				exit;
			}
			else
			{
				$this->redirect($this->createUrl("site/signUpMain"));
				exit;
			}
		}
	}
	
	function actionverifyPhone()
	{
		
		if(isset(Yii::app()->session['userId']))
		{
			$this->redirect($this->createUrl("user/index"));
				exit;
		}
		$this->render("verify_phone");
	}
	
	function actionverifyEmail()
	{
		Yii::app()->session['verifyEmail'] = Yii::app()->session['verifyEmail'] + 1;
		$this->render("verify_phone",$_GET);
	}
	
	function actionstorePassword()
	{
		if(isset(Yii::app()->session['userId']))
		{
			$this->redirect($this->createUrl("user/index"));
				exit;
		}
		$this->render("storePassword");
	}
		
	function actionLogin()
	{
		$this->loginRedirect();
		/***********		Login		************/
		if(isset($_POST['submit_login']))
		{
			
			$remember=0;
			if(isset($_POST['remenber']))
			{
				$remember=1;
			}
			
			$email_login = mysql_real_escape_string($_POST['email_login']);
			$password_login = mysql_real_escape_string($_POST['password_login']);
			
			$Userobj=new Users();		
			$result = $Userobj->login(trim($email_login),$password_login,$remember);
			
			if($result['status'] == 0)
			{
				$time = time();
				
				//if($remember==1)
				//{
					setcookie("email_login", $_POST['email_login'], $time + 3600);
					//setcookie("password_login", base64_encode($_POST['password_login']), $time + 3600);
        			
				//}
				//check rec_type
				if(isset(Yii::app()->session['rec_type']) && Yii::app()->session['rec_type'] == 'paybtn')
				{
					header("Location: ".$this->createUrl("user/getInvoiceDataForPayment/ptype/button"));
					exit;
				}
				else
				{
					$this->redirect(Yii::app()->params->base_path.'user/index');
					exit;
				}
			}
			else
			{
				Yii::app()->user->setFlash("error", $result['message']);
				header('location:'.$this->createUrl("site/signin"));
			}
		}
		else
		{
			header('location:'.$this->createUrl("site/index"));
		}
	
		exit;
	}
	
	function actionContactus($ajax=0)
	{	
		$result['message']='';	
		if(isset($_POST['FormSubmit']))
		{			
					$validationOBJ = new Validation();
					$result = $validationOBJ->contactUs($_POST);
					if($result['status']==0)
					{
						
						$userObj=new Users();
						$result=$userObj->contactus($_POST,0,Yii::app()->session['prefferd_language']);
						
						if($result['status']==0)
						{
							Yii::app()->user->setFlash('success', $result['message']);
						}else{
							Yii::app()->user->setFlash('error', $result['message']);
							$this->render("contactus");
							exit;
						}
					}
					else
					{
						Yii::app()->user->setFlash('error', $result['message']);
						$data = array('name'=>$_POST['name'],'email'=>$_POST['email'],'comment'=>$_POST['comment'],'message'=>$result['message']);
						$this->render("contactus",$data);
						exit;
					}
				
		}		
		$data = array('name'=>'','email'=>'','comment'=>'','message'=>$result['message']);
		if(!$this->isLogin())
		{
			$this->render('contactus',$data);
		}
		else
		{
			$this->render('contactus',$data);
		}
	}
	
	function loginRedirect()
	{
		if(isset(Yii::app()->session['loginId']))
		{
			$this->redirect($this->createUrl("user"));
			exit;
		}
	}

	
	/*********** 	Cheking if is login  ***********/ 
	function isLogin()
	{
		if(isset(Yii::app()->session['userId']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function actiongetVerifyCode()
	{
		$jsonarray= array();
		if(isset($_POST['phone']))
		{
			$userObj=new User();
			if(!is_numeric($_POST['phone'])){
				$algoencryptionObj	=	new Algoencryption();
				$_POST['phone']	=	$algoencryptionObj->decrypt($_POST['phone']);
			}
			$result=$userObj->getVerifyCodeById($_POST['phone'],'-1');
			$jsonarray['status']=$result['status'];
			$jsonarray['message']=$result['message'];
		}
		else
		{
			$message=$this->msg['ONLY_PHONE_VALIDATE'];
			$jsonarray['status']='false';
			$jsonarray['message']=$message;
		}
		echo $jsonarray['message'];
	}
	
	function actiongetActiveVerifyCode()
	{
		$jsonarray= array();
		if(isset($_POST['phone']))
		{	
			$loginObj=new Login();
			$result=$loginObj->getVerifyCode($_POST['phone'],'-1');
			$jsonarray['status']=$result[0];
			$jsonarray['message']=$result[1];
			
		}
		else
		{
			$message=$this->msg['ONLY_PHONE_VALIDATE'];
			$jsonarray['status']='false';
			$jsonarray['message']=$message;
		}
		echo $jsonarray['status'].'**'.$jsonarray['message']; 
	}
	
	function actionHowItWorks()
	{
		$this->render('HowItWorks');
	}
	
	function actionforgotPassword()
	{
		if(isset(Yii::app()->session['userId']))
		{
			$this->redirect(Yii::app()->params->base_path."user/index");
				exit;
		}
			$result['message'] = '';
			if(isset(Yii::app()->session['userId']))
			{
				header("Location: ".Yii::app()->params->base_path);
				exit;
			}
			
			if(isset($_POST['loginId']) && $_POST['loginId'] != '')
			{
				$validationOBJ = new Validation();
				$res = $validationOBJ->forgot_password($_POST);
				if($res['status']==0)
				{
					$userObj = new Users();
					$result=$userObj->forgot_password($_POST['loginId'],0,Yii::app()->session['prefferd_language']);
					if($result['status']==0)
					{
						Yii::app()->user->setFlash('success', $result['message']);
						$data = array('message'=>$result['message']);
						$data['loginId'] = $_POST['loginId'];
						Yii::app()->session['data'] = $data;
						Yii::app()->session['cnt'] = 1;
						//$this->render('forgot_password_after',$data);	
						$this->redirect(array("site/AfterForgotPassword"));
					}else{
						Yii::app()->user->setFlash('error', $result['message']);
						$data = array('loginId'=>$_POST['loginId'],'message'=>$result['message']);
						$this->render('forgot_password',$data);	
					}
				}
				else
				{
					Yii::app()->user->setFlash('error',$res['message']);
					$this->redirect(array("site/forgotpassword"));
					exit;
				}
			}
			else
			{
				$data = array('loginId'=>'','message'=>'');
				Yii::app()->user->setFlash('error',Yii::app()->params->msg['_CONTACT_US_EMAIL_VALIDATE_']);
				$this->render('forgot_password',$data);	
			}
			
		
	}
	
	function actionAfterForgotPassword()
	{
		$data =array();
		Yii::app()->session['cnt'] = Yii::app()->session['cnt'] + 1;
		$data = Yii::app()->session['data'];
		unset(Yii::app()->session['data']);
		if(Yii::app()->session['cnt'] == 2) { 
		$this->render('forgot_password_after',$data);
		}else{
		
		$this->redirect(array("site/index"));	
		}
		
	}
	
	function actionF_password()
	{
		if(isset(Yii::app()->session['userId']))
		{
			$this->redirect($this->createUrl("user/index"));
				exit;
		}
		$this->render('forgot_password');
	}
	
	function actionfpassword1()
	{
		$data['loginId'] = "djgoswami@gmail.com";
		$this->render('forgot_password_after',$data);	
	}
	
	public function actionRpassword1()
	{
		$data['token'] = "djgoswami@gmail.com";
		$this->render('password_confirm',$data);	
	}
	
	public function actionResetPassword()
	{
		if(isset(Yii::app()->session['userId']))
		{
			$this->redirect($this->createUrl("user/index"));
				exit;
		}
		$message='';
		$data=array();
		$data['token'] = $_GET['token'];
		$userObj = new Users();
		$res = $userObj->getIdByfpasswordConfirm($_GET['token']);
		if(!empty($res) && isset($res['id']))
		{
			$this->render('password_confirm',$data);	
		}
		else
		{
			Yii::app()->user->setFlash("error",Yii::app()->params->msg['_INVALID_TOKEN_']);
			$this->render('forgot_password');
		}
		
		
	}
	
	public function actionsetResetPassword()
	{
		global $msg;
			if($_POST['new_password'] != $_POST['confirm_password'])
			{
				Yii::app()->user->setFlash('error', $msg['_CONFIRM_PASSWORD_NOT_MATCH_']);
				$this->render('password_confirm',array("$_POST"=>$_POST));
				exit;
			}
			$validationOBJ = new Validation();
			$res = $validationOBJ->resetpassword($_POST);
			if($res['status']==0)
			{
				$userObj=new Users();
				$result=$userObj->resetpassword($_POST);
				$message=$result['message'];
				if($result['status']==0)
				{					
					Yii::app()->user->setFlash('success', $result['message']);
					header("Location: ".$this->createUrl("site/index"));
					exit;
				}
				$data = array('message'=>$result['message']);
			}else
			{
				Yii::app()->user->setFlash('error', $res['message']);
				$this->render('password_confirm',array("$_POST"=>$_POST));
				exit;
			}
		
		if($message!='')
		{
			Yii::app()->user->setFlash('error', $result['message']);
		}
	}
	
	/*********** 	Activation page redirect  ***********/ 
	public function actionActivate()
	{ 
	if(isset(Yii::app()->session['userId']))
		{
			$this->redirect($this->createUrl("user/index"));
				exit;
		}
		
		if(isset($_POST['activation_email']) && $_POST['activation_email'] == '')
		{
			Yii::app()->user->setFlash('error',"Please enter email address.");
			$this->render('activate',$data);
			exit;
		}
		$result['message'] = '';
		$captcha = Yii::app()->getController()->createAction('captcha');
		$code = $captcha->verifyCode;
		
		if(isset($_POST['activation_email']))
		{ 
			if(isset($_POST['verifyCode']) && ($code!=$_POST['verifyCode']))
			{
				Yii::app()->user->setFlash('error', Yii::app()->params->msg['_INVALID_CAPTCHA_']);
				$data = array('message'=>Yii::app()->params->msg['_INVALID_CAPTCHA_']);
				$this->render('activate',$data);
				exit;
			}
			$userObj=new Users();
			$result=$userObj->reSendactivation($_POST['activation_email']);	
			
		
			if($result['status']==0)
			{
				Yii::app()->user->setFlash('success', $result['message']);
				$data = array('message'=>$result['message']);
				$this->render('activate',$data);
			}
			else
			{
				Yii::app()->user->setFlash('error', $result['message']);
				$data = array('message'=>$result['message']);
				$this->render('activate',$data);	
			}
		}
		else
		{
			$data = array('loginId'=>'','message'=>'');
			$this->render('activate',$data);	
		}
	}
	
	
	public function actionxeroAuthentication()
	{
		
			/**
				 * An example script for the XeroOAuth class
				 *
				 * @author Ronan Quirke <network@xero.com>
				 */
				require 'xero/XeroOAuth.php';
				require_once('xero/_config.php');
				$oauthObject = new OAuthSimple();
				
				// As this is an example, I am not doing any error checking to keep 
				// things simple.  Initialize the output in case we get stuck in
				// the first step.
				session_start();
				$output = 'Authorizing...';
				
				
				# Set some standard curl options....
						$options[CURLOPT_VERBOSE] = 1;
						$options[CURLOPT_RETURNTRANSFER] = 1;
						$options[CURLOPT_SSL_VERIFYHOST] = 0;
						$options[CURLOPT_SSL_VERIFYPEER] = 0;
						

						$useragent = (isset($useragent)) ? (empty($useragent) ? 'XeroOAuth-PHP' : $useragent) : 'XeroOAuth-PHP'; 
						$options[CURLOPT_USERAGENT] = $useragent;
				
									 
				switch (XRO_APP_TYPE) {
					case "Private":
						$xro_settings = $xro_private_defaults;
						$_GET['oauth_verifier'] = 1;
						$_COOKIE['oauth_token_secret'] =  $signatures['shared_secret'];
						$_GET['oauth_token'] =  $signatures['consumer_key'];
						break;
					case "Public":
						$xro_settings = $xro_defaults;
						break;
					case "Partner":
						$xro_settings = $xro_partner_defaults;
						break;
					case "Partner_Mac":
						$xro_settings = $xro_partner_mac_defaults;
						break;
				}
						  
				// bypass if we have an active session
				if ($_SESSION&&$_REQUEST['start']==1) {
				
					$signatures['oauth_token'] = $_SESSION['access_token'];
					$signatures['oauth_secret'] = $_SESSION['access_token_secret'];
					$signatures['oauth_session_handle'] = $_SESSION['oauth_session_handle'];
					//////////////////////////////////////////////////////////////////////
					
					 if (!empty($_REQUEST['endpoint'])){
					// Example Xero API Access:
					$oauthObject->reset();
					$result = $oauthObject->sign(array(
						'path'      => $xro_settings['xero_url'].'/'.$_REQUEST['endpoint'].'/',
						'parameters'=> array(
							'order' => urlencode($_REQUEST['order']),
							'oauth_signature_method' => $xro_settings['signature_method']),
						'signatures'=> $signatures));
					$ch = curl_init();
					curl_setopt_array($ch, $options);
					curl_setopt($ch, CURLOPT_URL, $result['signed_url']);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
					$r = curl_exec($ch);
					curl_close($ch);
					
					parse_str($r, $returned_items);		   
					$oauth_problem = $returned_items['oauth_problem'];
						if($oauth_problem){
							session_destroy();
						}
					
					echo 'CURL RESULT5: ' . $r . '';
					}
					
					if (!empty($_REQUEST['put'])){
					// Example Xero API PUT:
					$oauthObject->reset();
					$result = $oauthObject->sign(array(
						'path'      => $xro_settings['xero_url'].'/Invoices/',
						'action'	=> 'PUT',
						'parameters'=> array(
							'oauth_signature_method' => $xro_settings['signature_method']),
						'signatures'=> $signatures));
						
					$xml = "<Invoices>
				  <Invoice>
					<Type>ACCREC</Type>
					<Contact>
					  <Name>Martin Hudson</Name>
					</Contact>
					<Date>2011-10-01T00:00:00</Date>
					<DueDate>2011-10-08T00:00:00</DueDate>
					<InvoiceNumber>ORC1042</InvoiceNumber>
					<LineAmountTypes>Exclusive</LineAmountTypes>
					<LineItems>
					  <LineItem>
						<Description>Monthly rental for property at 56a Wilkins Avenue</Description>
						<Quantity>4.3400</Quantity>
						<UnitAmount>395.00</UnitAmount>
						<AccountCode>200</AccountCode>
					  </LineItem>
					</LineItems>
				  </Invoice>
				</Invoices>";
					$fh  = fopen('php://memory', 'w+');
					fwrite($fh, $xml);
					rewind($fh);
					$ch = curl_init();
					curl_setopt_array($ch, $options);
					curl_setopt($ch, CURLOPT_PUT, true);
					curl_setopt($ch, CURLOPT_INFILE, $fh);
					curl_setopt($ch, CURLOPT_INFILESIZE, strlen($xml));
					curl_setopt($ch, CURLOPT_URL, $result['signed_url']);
					$r = curl_exec($ch);
					curl_close($ch);
					
					parse_str($r, $returned_items);		   
					$oauth_problem = $returned_items['oauth_problem'];
						if($oauth_problem){
							session_destroy();
						}
					
					echo 'CURL RESULT4: ' . $r . '';
					}
					
					if (!empty($_REQUEST['post'])){
					// Example Xero API Post - update invoice to Authorised status
					 $xml = "<Invoices>
				  <Invoice>
					<Type>ACCREC</Type>
					<Contact>
					  <Name>Martin Hudson</Name>
					</Contact>
					<Date>2011-10-10T00:00:00</Date>
					<DueDate>2011-10-17T00:00:00</DueDate>
					<InvoiceNumber>ORC1044</InvoiceNumber>
					 <Status>AUTHORISED</Status>
					<LineAmountTypes>Exclusive</LineAmountTypes>
					<LineItems>
					  <LineItem>
						<Description>Monthly rental for property at 56a Wilkins Avenue</Description>
						<Quantity>4.3400</Quantity>
						<UnitAmount>395.00</UnitAmount>
						<AccountCode>200</AccountCode>
					  </LineItem>
					</LineItems>
				  </Invoice>
				</Invoices>";
				
					$oauthObject->reset();
					$result = $oauthObject->sign(array(
						'path'      => $xro_settings['xero_url'].'/Invoices/',
						'action'	=> 'POST',
						'parameters'=> array(
							'oauth_signature_method' => $xro_settings['signature_method'],
							'xml' => $xml),
						'signatures'=> $signatures));
						
					$ch = curl_init();
					curl_setopt_array($ch, $options);
					curl_setopt($ch, CURLOPT_POST, true);
					$post_body = urlencode($xml);
					curl_setopt($ch, CURLOPT_POSTFIELDS, "xml=" . $post_body);
				
					$url = $result['signed_url'];
					curl_setopt($ch, CURLOPT_URL, $url);
					$r = curl_exec($ch);
					curl_close($ch);
					
					parse_str($r, $returned_items);		   
					$oauth_problem = $returned_items['oauth_problem'];
						if($oauth_problem){
							//session_destroy();
						}
					
					echo 'CURL RESULT3: ' . $r . '';
					}
					
					// Example Xero API AccessToken swap:
					if (!empty($_REQUEST['action'])){
						$oauthObject->reset();
						$result = $oauthObject->sign(array(
							'path'      => $xro_settings['site'].$xro_consumer_options['access_token_path'],
							'parameters'=> array(
							'scope'         => $xro_settings['xero_url'],
							'oauth_session_handle'	=> $signatures['oauth_session_handle'],
							'oauth_token'	=> $signatures['oauth_token'],
							'oauth_signature_method' => $xro_settings['signature_method']),
						'signatures'=> $signatures));
					$ch = curl_init();
					curl_setopt_array($ch, $options);
					curl_setopt($ch, CURLOPT_URL, $result['signed_url']);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
					$r = curl_exec($ch);
					parse_str($r, $returned_items);		   
					$_SESSION['access_token'] = $returned_items['oauth_token'];
					$_SESSION['access_token_secret']   = $returned_items['oauth_token_secret'];
					$_SESSION['oauth_session_handle']   = $returned_items['oauth_session_handle'];
					if($returned_items['oauth_token']){
						echo "Refresh successful - new token: " . $returned_items['oauth_token'] . "<br/>";
						}
					curl_close($ch);
					}
					
				}else{
				
				// In step 3, a verifier will be submitted.  If it's not there, we must be
				// just starting out. Let's do step 1 then.
				if (!isset($_GET['oauth_verifier'])) { 
					///////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
					// Step 1: Get a Request Token
					//
					// Get a temporary request token to facilitate the user authorization 
					// in step 2. We make a request to the OAuthGetRequestToken endpoint,
					// submitting the scope of the access we need (in this case, all the 
					// user's calendars) and also tell Google where to go once the token
					// authorization on their side is finished.
					//
					$result = $oauthObject->sign(array(
						'path'      => $xro_settings['site'].$xro_consumer_options['request_token_path'],
						'parameters'=> array(
							'scope'         => $xro_settings['xero_url'],
							'oauth_callback'	=> OAUTH_CALLBACK,
							'oauth_signature_method' => $xro_settings['signature_method']),
						'signatures'=> $signatures));
				
					// The above object generates a simple URL that includes a signature, the 
					// needed parameters, and the web page that will handle our request.  I now
					// "load" that web page into a string variable.
					$ch = curl_init();
					
					curl_setopt_array($ch, $options);
				
					if(isset($_GET['debug'])){
						echo 'signed_url: ' . $result['signed_url'] . '<br/>';
					}
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
					curl_setopt($ch, CURLOPT_URL, $result['signed_url']);
					
					$r = curl_exec($ch);
					
					if(isset($_GET['debug'])){
					echo 'CURL ERROR: ' . curl_error($ch) . '<br/>';
					}
				
					curl_close($ch);
				
					if(isset($_GET['debug'])){
					echo 'CURL RESULT2: ' . print_r($r) . '';
					}
					// We parse the string for the request token and the matching token
					// secret. Again, I'm not handling any errors and just plough ahead 
					// assuming everything is hunky dory.
					parse_str($r, $returned_items);
					$request_token = $returned_items['oauth_token'];
					$request_token_secret = $returned_items['oauth_token_secret'];
				
					 if(isset($_GET['debug'])){
					echo 'request_token: ' . $request_token . '<br/>';
					}
					
					// We will need the request token and secret after the authorization.
					// Google will forward the request token, but not the secret.
					// Set a cookie, so the secret will be available once we return to this page.
					setcookie("oauth_token_secret", $request_token_secret, time()+3600);
					//
					//////////////////////////////////////////////////////////////////////
					
					///////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
					// Step 2: Authorize the Request Token
					//
					// Generate a URL for an authorization request, then redirect to that URL
					// so the user can authorize our access request.  The user could also deny
					// the request, so don't forget to add something to handle that case.
					$result = $oauthObject->sign(array(
						'path'      => $xro_settings['authorize_url'],
						'parameters'=> array(
							'oauth_token' => $request_token,
							'oauth_signature_method' => $xro_settings['signature_method']),
						'signatures'=> $signatures));
				
					// See you in a sec in step 3.
					if(isset($_GET['debug'])){
					echo 'signed_url: ' . $result[signed_url];
					}else{
					header("Location:$result[signed_url]");
					}
					exit;
					//////////////////////////////////////////////////////////////////////
				}
				else {
					///////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
					// Step 3: Exchange the Authorized Request Token for an
					//         Access Token.
					//
					// We just returned from the user authorization process on Google's site.
					// The token returned is the same request token we got in step 1.  To 
					// sign this exchange request, we also need the request token secret that
					// we baked into a cookie earlier. 
					//
				
					// Fetch the cookie and amend our signature array with the request
					// token and secret.
					$signatures['oauth_secret'] = $_COOKIE['oauth_token_secret'];
					$signatures['oauth_token'] = $_GET['oauth_token'];
					
					// only need to do this for non-private apps
					if(XRO_APP_TYPE!='Private'){
					// Build the request-URL...
					$result = $oauthObject->sign(array(
						'path'		=> $xro_settings['site'].$xro_consumer_options['access_token_path'],
						'parameters'=> array(
							'oauth_verifier' => $_GET['oauth_verifier'],
							'oauth_token'	 => $_GET['oauth_token'],
							'oauth_signature_method' => $xro_settings['signature_method']),
						'signatures'=> $signatures));
				
					// ... and grab the resulting string again. 
					$ch = curl_init();
					curl_setopt_array($ch, $options);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
					curl_setopt($ch, CURLOPT_URL, $result['signed_url']);
					$r = curl_exec($ch);
				
					// Voila, we've got an access token.
					parse_str($r, $returned_items);		   
					$access_token = $returned_items['oauth_token'];
					$access_token_secret = $returned_items['oauth_token_secret'];
					$oauth_session_handle = $returned_items['oauth_session_handle'];
					}else{
					$access_token = $signatures['oauth_token'];
					$access_token_secret = $signatures['oauth_secret'];
					}
					
					// We can use this long-term access token to request Google API data,
					// for example, a list of calendars. 
					// All Google API data requests will have to be signed just as before,
					// but we can now bypass the authorization process and use the long-term
					// access token you hopefully stored somewhere permanently.
					$signatures['oauth_token'] = $access_token;
					$signatures['oauth_secret'] = $access_token_secret;
					$signatures['oauth_session_handle'] = $oauth_session_handle;
					//////////////////////////////////////////////////////////////////////
					
					// Example Xero API Access:
					// This will build a link to an RSS feed of the users calendars.
					$oauthObject->reset();
					$result = $oauthObject->sign(array(
						'path'      => $xro_settings['xero_url'].'/Organisation/',
						//'parameters'=> array('Where' => 'Type%3d%3d%22BANK%22'),
						'parameters'=> array(
							'oauth_signature_method' => $xro_settings['signature_method']),
						'signatures'=> $signatures));
				
					// Instead of going to the list, I will just print the link along with the 
					// access token and secret, so we can play with it in the sandbox:
					// http://googlecodesamples.com/oauth_playground/
					//
					$ch = curl_init();
					curl_setopt_array($ch, $options);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
					curl_setopt($ch, CURLOPT_URL, $result['signed_url']);
				
					$r = curl_exec($ch);
					//echo "REQ URL" . $result['signed_url'];
					// start a session to show how we could use this in an app
					$_SESSION['access_token'] = $access_token;
					$_SESSION['access_token_secret']   = $access_token_secret;
					$_SESSION['oauth_session_handle']   = $oauth_session_handle;
					$_SESSION['time']     = time();
				
					$output = "<p>Access Token: ". $_SESSION['access_token'] ."<BR>
								  Token Secret: ". $_SESSION['access_token_secret'] . "<BR>
								  Session Handle: ". $_SESSION['oauth_session_handle'] ."</p>
							   <p><a href=''>GET Accounts</a></p>";
							   //echo 'CURL RESULT1: ' . $r . '';
							   $xml = simplexml_load_string($r);
							   $obj =  json_encode($xml); 	
					curl_close($ch);
					
					$userObj =  new Users();
					$userData['xero'] = 1;
					$userObj->setData($userData);
					$userObj->insertData(Yii::app()->session['userId']);
					
					$obj = json_decode($obj);
					$xeroOrganizationObj =  new XeroOrganization();
					$xeroOrganizationObj->provider = $obj->ProviderName;
					$xeroOrganizationObj->companyName = $obj->Organisations->Organisation->Name;
					$xeroOrganizationObj->orgStatus = $obj->Organisations->Organisation->OrganisationStatus;
					$xeroOrganizationObj->regNumber = $obj->Organisations->Organisation->RegistrationNumber;
					$xeroOrganizationObj->OrganisationType = $obj->Organisations->Organisation->RegistrationNumber;
					$xeroOrganizationObj->BaseCurrency = $obj->Organisations->Organisation->BaseCurrency;
					$xeroOrganizationObj->CountryCode = $obj->Organisations->Organisation->CountryCode;
					$xeroOrganizationObj->TaxNumber = $obj->Organisations->Organisation->TaxNumber;
					$xeroOrganizationObj->userId = Yii::app()->session['userId'];
					$xeroOrganizationObj->save();
					
					$xeroOrganizationObj =  new XeroOrganization();
					$xeroOrgData = $xeroOrganizationObj->getXeroOrgDetails(Yii::app()->session['userId']);
					$this->render('xero_details',array('obj'=>$xeroOrgData));
				}     
				
				}
		
	}
	
	public function actionchecknumeric($input_value)
	{
		$bret= $this->test_datatype($input_value,'/^[0-9]*$/');
		return $bret;		
	}
	
	public function test_datatype($input_value,$reg_exp)
	{
		if(!preg_match($reg_exp,$input_value))
		{
			return false;
		}
		return true;
	}	
	
	function actionregistration()
	{
		if(isset(Yii::app()->session['userId']))
		{
			$this->redirect($this->createUrl("user/index"));
				exit;
		}
		$currObj = new Currency();
		$currencyData = $currObj->getCurrencyList();
		$countryObj = new Country();
		$countryData = $countryObj->getCountryList();
		$bussNatureObj = new BusinessNature();
		$bussNatureData = $bussNatureObj->getBusinessNatureList();
		
		$this->render("registration",array("countryData"=>$countryData,"currencyData"=>$currencyData,"bussNatureData"=>$bussNatureData));
		
	}
	
	function actionsubmitDirector()
	{
		$data['firstName'] = $_REQUEST['dfirstName'];
		$data['lastName'] = $_REQUEST['dlastName'];
		//$data['phone'] = $_REQUEST['dphoneNumber'];
		//$data['title'] = $_REQUEST['dtitle'];
		$data['ownership'] = $_REQUEST['ownership'];
		$data['userId'] = Yii::app()->session['id'];
		$data['status'] = 0 ;
		$data['created'] = date("Y:m:d H:m:s") ;
		
		if(isset($_REQUEST['id']) && $_REQUEST['id'] != "" )
		{
			$directorsObj = new Directors();
			$directorsObj->setData($data);
			$directorsObj->insertData($_REQUEST['id']);
		}
		else
		{
			$directorsObj = new Directors();
			$directorsObj->setData($data);
			$directorsObj->insertData();	
		}
		
		$this->renderPartial("directorslist",array('data'=>$data));
	}
	
	function actiondeleteDirector()
	{
		$directorsObj =  new Directors();
		$result = $directorsObj->findByPk($_REQUEST['id']);
		$result->delete();
		$this->renderPartial("directorslist");
	}
	
	
	public function actiongetAddress()
	{
		
		$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($_REQUEST['postal_code'])."&sensor=true";
		
		$result = file_get_contents($url);
		$res = json_decode($result);
		
		
		if($res->status == "ZERO_RESULTS")
		{
			echo 0 ; 
			exit;		
		}
				
		
		$cnt =  count($res->results[0]->address_components);
		$data = array();
		$i = 0; 
		foreach($res->results as $row) 
		{
			 foreach($row->address_components as $components)
			 {
				 foreach($components->types as $col)
				 {
					if($col == 'country')
					{
						$data[$i]['country'] = $components->long_name;
						//break;
					}
					else if($col == 'administrative_area_level_2')
					{
						$data[$i]['city'] = $components->long_name;
						//break;
					}	
					if(isset($data[$i]['city']) && $data[$i]['city'] == '')
					{
							if($col == 'administrative_area_level_1')
							{
								$data[$i]['city'] = $components->long_name;
							}
					} 
				 }
				
			}
			$data[$i]['location'] = $row->formatted_address;
		$i++;
		}
		
		if(isset($_REQUEST['trade']) && $_REQUEST['trade'] == 1 )
		{
			$this->renderPartial("trade_address_lookup",array('data'=>$data));
			exit;	
		}
	
		$this->renderPartial("address_lookup",array('data'=>$data));	
	}
	
	
	public function actiongetCompanyDetails()
	{
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL =>'http://api.duedil.com/sandbox/v2/company/'.urlencode($_REQUEST['company_code']).'.json?fields=get_all&api_key=vpqk7gem45yzgf2cw8qrd47d',
			CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		
		$res = json_decode($resp);
		
		if(isset($res->status_code) && $res->status_code == 404)
		{
			echo 0 ; 
			exit;	
		}
		
		
		$data = array();
		$data['companyName'] = $res->response->name ;
		if(isset($res->response->incorporationDate) && $res->response->incorporationDate != "" )
		{
			$data['incorporationDate'] = date("m/d/Y",strtotime($res->response->incorporationDate));
		}
		$data['regAddressPostcode'] = $res->response->regAddressPostcode;
		$data['regPhone'] = $res->response->regPhone;
		$data['regWeb'] = $res->response->regWeb;
		if(isset($res->response->tradingAddress3))
		{
			$data['tradingAddress3'] = $res->response->tradingAddress3;
		}
		if(isset($res->response->tradingAddress4))
		{
			$data['tradingAddress4'] = $res->response->tradingAddress4;
		}
		
		// Close request to clear up some resources
		curl_close($curl);
		
		echo json_encode($data);

	}
	
	function actiongetCurrencyForCountry()
	{
		
		$countryObj = new Country();
		$countryData = $countryObj->getCurrencyFromCountry($_POST['val']);
		echo $countryData;
		exit;
	}
	
	function actionnewOrder()
	{
		$currObj = new Currency();
						$currencyData = $currObj->getCurrencyList();
						$countryObj = new Country();
						$countryData = $countryObj->getCountryList();
						$bussNatureObj = new BusinessNature();
						$bussNatureData = $bussNatureObj->getBusinessNatureList();
				
						$this->render("registration_after_callback",array("countryData"=>$countryData,"currencyData"=>$currencyData,"bussNatureData"=>$bussNatureData));
		//$this->render("request_call_back");
	}
	
	// For Kwex pay Button 
	
	//p.k_change from 27/08/2013
	
	//p.k_change_kwexc7_usecase_4,5 from 27/08/2013
	
	function actionkwexcPayButton()
	{
		$gen_details['amt'] = htmlentities($_REQUEST['amt']);
		$gen_details['cur'] = htmlentities($_REQUEST['cur']);
		$gen_details['user'] = htmlentities($_REQUEST['user']);
		
				
		$currObj = new Currency();
		$currencyData = $currObj->getCurrencyList();

		//$amount= $_POST['amt'];
		$damount=base64_decode($gen_details['amt']);
		//$curr=$_POST['cur'];
		$dcurr=base64_decode($gen_details['cur']);
		$duser= base64_decode($gen_details['user']);
		//$userId = Yii::app()->session['userId'];
		$gen_details['ocode']=$damount;
		$gen_details['ocode1']=$dcurr;
		$gen_details['user']=$duser;
		Yii::app()->session['rec_amt'] = $damount;
		Yii::app()->session['rec_curr'] = $dcurr;
		Yii::app()->session['rec_user'] = $duser;
		Yii::app()->session['rec_type'] = 'paybtn';
		
		
		$userObj = new Users();
		$userData = $userObj->getUserById($gen_details['user']);
		$gen_details['phoneNumberTemp']= $userData['phoneNumberTemp']; 
		$gen_details['comapanyNameTemp']= $userData['comapanyNameTemp']; 
		$gen_details['lastName']= $userData['lastName']; 
		$gen_details['firstName']= $userData['firstName']; 
		$gen_details['loginId']= $userData['loginId']; 
		
		
		// p.k_change_kwexc7 17-9-13
		 
		$personalObj = new PersonAccount();
		$personalData = $personalObj->getPersonById($gen_details['user']);
		$gen_details['reference']= $personalData['reference'];
	/*	print_r($gen_details);
		
		die;
		*/
		
		if(isset(Yii::app()->session['userId']) && Yii::app()->session['userId'] != "")
		{
			
			header("Location: ".Yii::app()->params->base_path."user/getInvoiceDataForPayment/ptype/button");
		}
		else
		{
			$this->render("kwexcpaybutton_notlogin",array('genData'=>$gen_details));
		}
	}
	// p.k_change End
	
	
	function actionerror1()
	{
		$this->render("error1");
	}
	
	
	
}