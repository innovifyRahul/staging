<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $firstName
 * @property string $lastName
 * @property string $avata0
 r]
 * @property string $linkedinLink
 * @property string $facebookLink
 * @property string $twitterLink
 * @property string $createdAt
 * @property string $modifiedAt
 * @property string $deletedAt
 */
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	 
	public $msg;
	public $errorCode;
	
	public function __construct()
	{
		$this->msg = Yii::app()->params->msg;
		$this->errorCode = Yii::app()->params->errorCode;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('firstName, lastName, avatar, linkedinLink, facebookLink, twitterLink, createdAt, modifiedAt, deletedAt', 'required'),
			array('firstName, lastName', 'length', 'max'=>50),
			array('avatar, linkedinLink, facebookLink, twitterLink', 'length', 'max'=>255),
			array('deletedAt', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, firstName, lastName, avatar, linkedinLink, facebookLink, twitterLink, createdAt, modifiedAt, deletedAt', 'safe', 'on'=>'search'),*/
		);
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'firstName' => 'First Name',
			'lastName' => 'Last Name',
			'avatar' => 'Avatar',
			'linkedinLink' => 'Linkedin Link',
			'facebookLink' => 'Facebook Link',
			'twitterLink' => 'Twitter Link',
			'createdAt' => 'Created At',
			'modifiedAt' => 'Modified At',
			'deletedAt' => 'Deleted At',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('firstName',$this->firstName,true);
		$criteria->compare('lastName',$this->lastName,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('linkedinLink',$this->linkedinLink,true);
		$criteria->compare('facebookLink',$this->facebookLink,true);
		$criteria->compare('twitterLink',$this->twitterLink,true);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('modifiedAt',$this->modifiedAt,true);
		$criteria->compare('deletedAt',$this->deletedAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	// set the user data
	function setData($data)
	{
		$this->data = $data;
	}
	
	// insert the user
	function insertData($id=NULL)
	{
		if($id!=NULL)
		{
			$transaction=$this->dbConnection->beginTransaction();
			try
			{
				$post=$this->findByPk($id);
				if(is_object($post))
				{
					$p=$this->data;
					
					foreach($p as $key=>$value)
					{
						$post->$key=$value;
					}
					$post->save(false);
				}
				$transaction->commit();
			}
			catch(Exception $e)
			{						
				$transaction->rollBack();
			}
			
		}
		else
		{
			$p=$this->data;
			foreach($p as $key=>$value)
			{
				$this->$key=$value;
			}
			$this->setIsNewRecord(true);
			$this->save(false);
			return Yii::app()->db->getLastInsertID();
		}
		
	}
	
	/*
	DESCRIPTION : USER LOGIN
	*/
	function login($email,$password,$remember=0,$apiLogin=0)
	{
		global $msg;
		$isSuccess=0;
		$successType='seeker';
		if($remember==1)
		{		
			setcookie("password_login", $password, time()+60*60*24*500, "/");
			setcookie("email_login",$email, time()+60*60*24*500, "/");
		}
		$generalObj=new General;
		if($generalObj->validate_phoneUS($email))
		{
			$email=$generalObj->clearPhone($email);
			
		}
		$userObj	=	new Users();
		$users = $userObj->getVerifiedUser($email);
		
		
		
		$err_msg = NULL;
		if(!empty($users))
		{
			$users = $users[0];
			
			if($users['isVerified'] != 1)
			{
				$err_msg = 'ERROR_VERIFICATION_MSG';
			}
			elseif($users['status'] == 2)
			{
				$err_msg = 'ERROR_STATUS_MSG_0';
			}
			elseif(false==$generalObj->validate_password($password, $users['password']))
			{
				$err_msg	=	'EMAIL_PHONE_MSG';
				
			}
			else
			{
				
				$isSuccess=1;
				$algoObj = new Algoencryption();
				$fullname	=	$this->getUserById($users['id']);
				
				Yii::app()->session['userId']=$users['id'];
				Yii::app()->session['loginId']=$users['id'];
				Yii::app()->session['tcc_loginId']=$users['tcc_loginId'];
				Yii::app()->session['tcc_key']=$users['tcc_key'];
				Yii::app()->session['induction']=$users['induction'];
				if(!empty($fullname))
				{
					Yii::app()->session['fullname'] =$fullname['firstName'].'&nbsp;'.$fullname['lastName'];
					Yii::app()->session['firstName']=$fullname['firstName'];
					
				}
				else
				{
					Yii::app()->session['fullname']='Username';
				}
				
				Yii::app()->session['loginIdType'] =  $users['loginIdType'];
				Yii::app()->session['email'] =  $users['loginId'];
				Yii::app()->session['status'] =  $users['status'];
				
				if(isset(Yii::app()->session['email_login']))
				{
					unset(Yii::app()->session['email_login']);
				}
			}
		}
		else
		{
			$userObj	=	new Users();
			$users = $userObj->getUserIdByLoginId($email);
			
			if(empty($users))
			{
				$err_msg = 'EMAIL_PHONE_MSG';
			}
			else
			{
				$err_msg = 'EMAIL_NOT_VERIFY_MSG';
			}
		}
		
		if($isSuccess==1)
		{	
			if($apiLogin==1)
			{
				$algoObj= new Algoencryption();
				$oauthObj=new Oauth();
				
				$oauthDetail=$oauthObj->getAuthDetailsByclientId(Yii::app()->session['userId'],'userId');
				
				if(empty($oauthDetail) || $oauthDetail['client_id']==NULL || $oauthDetail['client_id']=='')
				{
					$oauthDetail=$oauthObj->addClient(Yii::app()->session['userId']);
				}
					$token=$oauthObj->createAccessToken($oauthDetail['client_id']);
					$returnData['client_id']=$oauthDetail['client_id'];
					$returnData['client_secret']=$oauthDetail['client_secret'];
					$returnData['oauth_token']=$token['access_token'];
					$returnData['userId']=$algoObj->encrypt(Yii::app()->session['userId']);
					return array("status"=>0,"message"=>$this->msg['_LOGIN_MESSAGE_'],"outhDetails"=>$returnData);
			
			}
			Yii::app()->session['firstLoadFlag']=1;
			return array("status"=>0,"message"=>$successType);
			
		}
		else
		{
			
			Yii::app()->session['email_login']=$email;
			return array('status'=>$this->errorCode['_LOGIN_ERROR_'],'message'=>$this->msg[$err_msg]);
			
		}
	}
	

	/*
	DESCRIPTION : GET VERIFIED USER
	*/
	function getVerifiedUser($loginId)
	{
		$result	=	Yii::app()->db->createCommand()
					->select('*')
					->from($this->tableName())
					->where('loginId=:loginId and isVerified=:isVerified',
							 array(':loginId'=>$loginId,':isVerified'=>'1'))	
					->queryAll();
		
		return $result;
	}
	
	
	function forgot_password($loginId,$mobile=0,$lng='eng')
	{
		error_reporting(E_ALL);
		$generalObj=new General();
		
		$id = $this->getUserIdByLoginId($loginId);
		
			if(!empty($id))
			{
				
				$new_password = $this->genPassword();
				$userObj=Users::model()->findByPk($id['id']);
				$userObj->fpasswordConfirm=$new_password;	
				$res = $userObj->save();				
				
				if (preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$loginId)) 
				{
					
					$url=Yii::app()->params->base_path.'templatemaster/job';
					$message = file_get_contents(Yii::app()->params->base_path.'templatemaster/job');
					$recipients = $loginId;							
					$email =$loginId;
					$subject = "Confirm password reset for your Kwexc account";
					$message = str_replace("_BASEPATHLOGO_",Yii::app()->params->base_url,$message);
					
					if($mobile==1)
					{
						$message = str_replace("_BASEPATH_",BASE_PATH.'m',$message);
					}
					else
					{
						$message = str_replace("_BASEPATH_",Yii::app()->params->base_path,$message);
					}
					$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->base_url,$message);
					$message = str_replace("_FIRST_NAME_",$id['firstName'],$message);
					//$message = str_replace("_PASSWORD_CODE_",$new_password,$message);
					$message = str_replace("_TOKEN_",$new_password,$message);
					$message = str_replace("_EMAIL_",$loginId,$message);
										
					$mail=new Helper();
					$mailResponse=$mail->sendMail($email,$subject,$message);
					
					if($mailResponse!=true) {		
						$msg= $mailResponse;
						return array('status'=>"200","message"=>"Email sending error".$msg);
					} 
					else
					{
						return  array('status'=>0,"message"=>"Reset password token successfully sent to your mail.",'token'=>$new_password);
					}
				} 
				else 
				{
					
					error_log("Forgot password message sending to ".$loginId);
					
					$twilio_helper = new TwilioHelper();		
					// Instantiate a new Twilio Rest Client
					$twilio = new Twilio();
					$client = new TwilioRestClient($twilio->AccountSid, $twilio->AuthToken);
					$message =$this->msg['_TEXT_TO_FORGOT_PASS_SMS_'];
					$response = $client->request("/$twilio->ApiVersion/Accounts/$twilio->AccountSid/SMS/Messages", 
						"POST", array(
						"To" => $loginId,
						"From" => SMS_NUMBER,
						"Body" => $message
						));
						
					if($response->IsError)
					{
						error_log("Forgot password message sent Error: {$response->ErrorMessage}");
						$message=$this->msg['FPASS_SEND_SMS_ERROR'];
						return array("status"=>$this->errorCode['FPASS_SEND_SMS_ERROR'],"message"=>$message);
					}
					else
					{			
						error_log("INFO Forgot password message sent successfully to ".$loginId);
						error_log("INFO SMS INFO:".$message);
						$message=$this->msg['FPASS_SEND_SMS_SUCCESS'];
						return array('status'=>'0',"message"=>$message,'token'=>$new_password);
					}
				}
				if($res == 1)
				{
					return array('status'=>0,"message"=>"Successfully Changed");
				}
				else
				{
					return array("status"=>1,"message"=>"Some Problem in Forgot Password.");	
				}
			}
			else
			{
				return array('status'=>"2","message"=>"No registered user is available in our records with this
is/email address");
			}
	}
	
	public function getUserIdByLoginId($loginId)
	{
		$result = Yii::app()->db->createCommand()
    	->select('*')
    	->from($this->tableName())
   	 	->where('loginId=:loginId', array(':loginId'=>$loginId))	
   	 	->queryRow();
		return $result;
	}
	
	function genPassword()
	{
		$pass_char = array();
		$password = '';
		for($i=65 ; $i < 91 ; $i++)
		{
			$pass_char[] = chr($i);
		}
		for($i=97 ; $i < 123 ; $i++)
		{
			$pass_char[] = chr($i);
		}
		for($i=48 ; $i < 58 ; $i++)
		{
			$pass_char[] = chr($i);
		}
		for($i=0 ; $i<8 ; $i++)
		{
			$password .= $pass_char[rand(0,61)];
		}
		return $password;
	}
	
	//reset password confirmation
	function resetpassword($data)
	{
		if($data['token']!='')
		{
			if(strlen($data['new_password'])>=6)
			{
				
					$generalObj = new General();
					$loginObj=new Users();
					$id=$this->getIdByfpasswordConfirm($data['token']);
					
					$new_password =$generalObj->encrypt_password($data['new_password']);
					$User_field['password'] = $data['new_password'];
					
					$userObj=Users::model()->findByPk($id['id']);
					if(isset($userObj) && $userObj != '')
					{
						$userObj->fpasswordConfirm = '';
						$userObj->password = $new_password;	
						$res = $userObj->save();	
					}
					return array("status"=>'0',"message"=>"Your password changed successfully.");						
						
				
			}
			else
			{
				return array('status'=>$this->errorCode['_VALIDATE_PASSWORD_GT_6_'],"message"=>$this->msg['_VALIDATE_PASSWORD_GT_6_']);
			}
		}
		else
		{
			return array('status'=>$this->errorCode['VALIDATE_TOKEN'],"message"=>$this->msg['VALIDATE_TOKEN']);
		}
	}
	
	function getIdByfpasswordConfirm($token)
	{
		$result = Yii::app()->db->createCommand()
		->select('id')
		->from($this->tableName())
		->where('fpasswordConfirm=:fpasswordConfirm', array(':fpasswordConfirm'=>$token))
		->queryRow();
		return $result;
	}
	
	function activate($loginId,$mobile=0)
	{
		$result = $this->getUserIdByLoginId($loginId);
		
		if(count($result) && $result!='')
		{
			if($result['isVerified']==1)
				{			
					$msgmsg=$this->msg['NAEMAIL_MSG'];
					$responceArray=array("status"=>$this->errorCode['NAEMAIL_MSG'],"message"=>$msgmsg);
					return $responceArray;	
				}
				else
				{
					$generalObj = new General();
					$algoObj = new Algoencryption();
					$everify_code=$result['isVerified'];
					$userArray=array();
					$userArray['isVerified']=$everify_code;
					$userArray['expiry']=time()+ACTIVATION_LINK_EXPIRY_TIME;
					$loginObj	=	new Users();					
					$loginObj->setData($userArray);
					$loginObj->insertData($result['id']);
					$emailLink = Yii::app()->params->base_path."site/verifyaccount/&key=".$everify_code.'&id='.$algoObj->encrypt($result['id']).'&lng=eng';	
					
					
					
					$Yii = Yii::app();	
					$url=$Yii->params->base_path.'templatemaster/userConfirm';
					$message = file_get_contents($url);
		
					$recipients = $loginId;							
					$email =$loginId;
					$subject = "KWEXC account confirmation";	
					$message = str_replace("_BASEPATHLOGO_",Yii::app()->params->image_path,$message);
					
					if($mobile==1)
					{
						$message = str_replace("_BASEPATH_",BASE_PATH.'m/',$message);
					}
					else
					{
						$message = str_replace("_BASEPATH_",BASE_PATH,$message);
					}
					 
					$message = str_replace("_FIRST_NAME_",$result['firstName'],$message);
					$message = str_replace("_USER_NAME_",$email,$message);
					$message = str_replace("_EMAIL_LINK_",$emailLink,$message);
					$message = str_replace("_USER_CONFIRMATION_VERIFY_LINK_",$emailLink ,$message);
					$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
				
					$mail=new Helper();
					$mailResponse=$mail->sendMail($email,$subject,$message);
				
					if($mailResponse!=true) {
						
						$msg= $mailResponse;
						return array('status'=>$this->errorCode['_USER_MAIL_ERROR_'],"message"=>$this->msg['_USER_MAIL_ERROR_'].$msg);
					} 
					else
					{						
						return  array('status'=>0,"message"=>$this->msg['ACT_MSG']);
					}		
				}
		}
		else
		{
			$msgmsg=$this->msg['AEMAIL_MSG'];
			$responceArray=array("status"=>$this->errorCode['AEMAIL_MSG'],"message"=>$msgmsg);
			return $responceArray;	
		}
	}
	
	
	function reSendactivation($loginId,$mobile=0)
	{
		$result = $this->getUserIdByLoginId($loginId);
		
		if(count($result) && $result!='')
		{
			if($result['isVerified']==1)
				{			
					$msgmsg=$this->msg['NAEMAIL_MSG'];
					$responceArray=array("status"=>$this->errorCode['NAEMAIL_MSG'],"message"=>$msgmsg);
					return $responceArray;	
				}
				else
				{
					$generalObj = new General();
					$algoObj = new Algoencryption();
					$everify_code=$result['isVerified'];
					$userArray=array();
					$userArray['isVerified']=$everify_code;
					$userArray['expiry']=time()+ACTIVATION_LINK_EXPIRY_TIME;
					$loginObj	=	new Users();					
					$loginObj->setData($userArray);
					$loginObj->insertData($result['id']);
					$Yii = Yii::app();	
					//$emailLink = Yii::app()->params->base_path."site/verifyaccount/&key=".$everify_code.'&id='.$algoObj->encrypt($result['id']).'&lng=eng';	
					$emailLink = $Yii->params->base_path."site/registerFirstSlap/key/".$everify_code.'/id/'.$algoObj->encrypt($result['id']).'/lng/eng/email/'.$result['loginId'].'/companyName/'.base64_encode($result['comapanyNameTemp']).'/phoneNumber/'.$result['phoneNumberTemp'];
				
					
					
					$Yii = Yii::app();	
					$url=$Yii->params->base_path.'templatemaster/userConfirm';
					$message = file_get_contents($url);
		
					$recipients = $loginId;							
					$email =$loginId;
					$subject = "KWEXC ACCOUNT CONFIRMATION";	
					$message = str_replace("_BASEPATHLOGO_",Yii::app()->params->image_path,$message);
					
					if($mobile==1)
					{
						$message = str_replace("_BASEPATH_",BASE_PATH.'m/',$message);
					}
					else
					{
						$message = str_replace("_BASEPATH_",BASE_PATH,$message);
					}
					 
					$message = str_replace("_FIRST_NAME_",$result['firstName'],$message);
					$message = str_replace("_USER_NAME_",$email,$message);
					$message = str_replace("_EMAIL_LINK_",$emailLink,$message);
					$message = str_replace("_USER_CONFIRMATION_VERIFY_LINK_",$emailLink ,$message);
					$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
				
					$mail=new Helper();
					$mailResponse=$mail->sendMail($email,$subject,$message);
				    if($mailResponse!=true) {
						
						$msg= $mailResponse;
						return array('status'=>$this->errorCode['_USER_MAIL_ERROR_'],"message"=>$this->msg['_USER_MAIL_ERROR_'].$msg);
					} 
					else
					{						
						return  array('status'=>0,"message"=>$this->msg['ACT_MSG']);
					}		
				}
		}
		else
		{
			$msgmsg=$this->msg['AEMAIL_MSG'];
			$responceArray=array("status"=>$this->errorCode['AEMAIL_MSG'],"message"=>$msgmsg);
			return $responceArray;	
		}
	}
	
	function contactUs($data,$mobile=0,$lng='eng')
	{		
		$recipients = $data['email'];							
		$email =$data['email'];							
		$name =$data['name'];
		$comment = htmlentities($data['comment']);
		$Yii = Yii::app();	
		
		$url=Yii::app()->params->base_path.'templatemaster/contact';
		
		$message = file_get_contents($url);
		$message = str_replace("_BASEPATH_",BASE_PATH,$message);
		$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->image_path,$message);
		$message = str_replace("_NAME_",$name,$message);
		$message = str_replace("_COMMENT_",$comment,$message);
		$message = str_replace("_EMAIL_",$email,$message);
		$subject = "Contact Us";
		$mail=new Helper();
		$mailResponse=$mail->sendMail($email,$subject,$message);
		
		if($mailResponse!=true) {	
				$msg= $mailResponse;
				return array('status'=>-1,'message'=>"error in mail sending");
		} else {
		   return array('status'=>0,'message'=>"Successfully send.");
		}		
		
	}
	
	/*
	DESCRIPTION : GET USER BY ID
	*/
	public function getUserById($id=NULL, $fields='*')
	{
		$result = Yii::app()->db->createCommand()
    	->select($fields)
    	->from($this->tableName())
   	 	->where('id=:id', array(':id'=>$id))	
   	 	->queryRow();
		
		return $result;
	}	
	/*
	DESCRIPTION : GET USER BY ID
	*/
	public function getUserDetail($id=NULL, $fields='*')
	{
		
		$algoencryptionObj = new Algoencryption();	
		if(!is_numeric($id))
		{	
			$id=$algoencryptionObj->decrypt($id);
		}
		$userObj =  new Users();
		$loginArr = $userObj->getUserId($id);
		
		$result = Yii::app()->db->createCommand()
    	->select($fields)
    	->from($this->tableName())
   	 	->where('id=:id', array(':id'=>$loginArr['userId']))	
   	 	->queryRow();
		
		if(!empty($loginArr))
		{
			$result['loginId']=$loginArr['loginId'];
			$result['password']=$loginArr['password'];
			$result['loginIdType']=$loginArr['loginIdType'];
			$result['isVerified']=$loginArr['isVerified'];
			$result['status']=$loginArr['status'];
			$res = array("status"=>0,"result"=>$result);
		}
		else
		{
			$res=array("status"=>"-1","message"=>"No Data Found.","result"=>"no data");
		}
		return $res;
	}
	
	public function getUserId($id=NULL)
	{
		//echo "userId".$id;
		$result = Yii::app()->db->createCommand()
    	->select('*')
    	->from($this->tableName())
   	 	->where('id=:id', array(':id'=>$id))	
   	 	->queryRow();
		
		//print_r($result);
		return $result;
	}
	
	/*
	DESCRIPTION : ADD USER
	*/
	function addRegisterUser($data,$mobile=0,$fromApi=1)
	{
		
		$generalObj	=	new General();
		$algoObj	=	new Algoencryption();
		$loginObj	=	new Login();
		$flagerroremail	=	0;
		$flagsuccessemail	=	0;
		$flagsuccessmsg	=	0;	
		$flagerrormsg	=	0;
		$Password	=	$generalObj->encrypt_password($data['password']);
		if(isset(Yii::app()->session['adminUser']) && Yii::app()->session['adminUser']!='' && isset($data['admin']) && $data['admin']!='')
		{			
			$everify_code=1;
			$User_value['modified'] = date('Y-m-d H:i:s');
		}
		else
		{			
			$everify_code=$generalObj->encrypt_password(rand(0,99).rand(0,99).rand(0,99).rand(0,99));
		}
		//Insert multiple entries in users table
		$User_value['isVerified']=$everify_code;//1;
		//$User_value['expiry']=time();//+ACTIVATION_LINK_EXPIRY_TIME;
		$User_value['createdAt'] = date('Y-m-d H:i:s');
		//$User_value['password'] = $Password;
		
		if(isset($data['email']) && $data['email']!='' && $data['email']!=$this->msg['_EMAIL_'])
		{
			$data['email']	=	$data['email'];
		}
		else
		{
			$data['email']	=	'';
		}
		$fullname=$data['companyName'];
		$email=$data['email'];
		$helperObj = new Helper();
		// for with mail in without api 
		
		/*if($fromApi==0)
		{
			
			$email_admin =	$this->msg['_ADMIN_EMAIL_'];	
			$subject_admin = $this->msg['_SIGNUP_SEEKER_DETAIL_ADMIN_MSG_SUBJECT_'];
						
			$serverPara='Web';	
			if($mobile==1)
			{
				$serverPara='Mobile web';
			}
			if(isset($_POST['inServer']))
			{
				if($_POST['inServer']==3)
				{
					$serverPara='Android';
				}
				else if($_POST['inServer']==4)
				{
					$serverPara='Iphone';
				}
				else
				{
					$serverPara='Web';	
				}
			}
			$Yii = Yii::app();	
			$url=$Yii->params->base_path.'templatemaster/setTemplate/lng/eng/file/'.$this->msg['_ET_SIGNUP_SEEKER_DETAIL_ADMIN_MSG_TPL_'].'';
			$message_admin = file_get_contents($url);
			
			$message_admin = str_replace("_BASEPATH_",Yii::app()->params->image_path,$message_admin);			
			$message_admin = str_replace("_FULL_NAME_",$fullname,$message_admin);
			$message_admin = str_replace("_PHONE_NUMBER_",$phonenumber,$message_admin);
			$message_admin = str_replace("_EMAIL_",$email,$message_admin);
			$message_admin = str_replace("_USING_",$serverPara,$message_admin);
			
			
			$helperObj->mailSetup($email_admin,$subject_admin,$message_admin);
		}
		*/
		if($data['email'] != "" && $data['email'] != $this->msg['_EMAIL_'] )
		{
			if($generalObj->isValidEmail($data['email']))
			{
				$userData['loginId']	=	$data['email'];
				$userData['loginIdType']	=	'0';
				$userData['status']	=	0;
				$userData['isVerified'] =   $everify_code;
				$userData['firstName']	=	$data['companyName'];
				$userData['comapanyNameTemp']	=	$data['companyName'];
				$userData['phoneNumberTemp']	=	$data['phoneNumber'];
				$userData['lastName']	=	$data['companyName'];
				$userData['password']   =  $Password;
				$userData['modifiedAt']	=	date('Y-m-d H:i:s');
				$userData['createdAt']	=	date('Y-m-d H:i:s');
				$userData['modifiedAt']	=	date('Y-m-d H:i:s');
				$this->setData($userData);
				$this->setIsNewRecord(true);
				$userId=$this->insertData();
				
				
				$Yii = Yii::app();	
				
				$emailLink = $Yii->params->base_path."site/registerFirstSlap/key/".$everify_code.'/id/'.$algoObj->encrypt($userId).'/lng/eng/email/'.$data['email'].'/companyName/'.base64_encode($data['companyName']).'/phoneNumber/'.$data['phoneNumber'];
				
				
				
				$recipients = $data['email'];							
				$email =$data['email'];							
				$fullname=$data['companyName'].' '.$data['companyName'];
				$subject= 'Please confirm your email to open Kwexc account';
				
				$Yii = Yii::app();	
				if(isset(Yii::app()->session['adminUser']) && Yii::app()->session['adminUser']!=''  && isset($data['admin']) && $data['admin']!='')
				{
					$url=$Yii->params->base_path.'templatemaster/setTemplate/lng/eng/file/useradmin-confirmation-link';
				}
				else
				{
					$url=$Yii->params->base_path.'templatemaster/userConfirm';
				}
				$message = file_get_contents($url);
				$message = str_replace("_LOGOBASEPATH_",Yii::app()->params->base_url.'images',$message);
				
				if($mobile==1)
				{
					$message = str_replace("_BASEPATH_",BASE_PATH.'m/',$message);
				}
				else
				{
					$message = str_replace("_BASEPATH_",BASE_PATH,$message);
				}	
				
				$message = str_replace("_FIRST_NAME_",$userData['firstName'],$message);
											
				$message = str_replace("_EMAIL_LINK_",$emailLink,$message);
				
				$message = str_replace("_LOGINID_",$data['email'],$message);
				$message = str_replace("_USER_CONFIRMATION_VERIFY_LINK_",$emailLink,$message);
			//	$message = str_replace("_PASSWORD_",$data['password'],$message);
				
				$helperObj = new Helper();
				$mailResponse=$helperObj->sendMail($email,$subject,$message);
				
				if($mailResponse!=true)
				{
				  $flagerroremail=1;
				}
				else
				{	  $flagsuccessemail=1;
					if(isset(Yii::app()->session['userId']))
					{
						unset(Yii::app()->session['userId']);
					}
				}	
			}
		}
		
		if($flagerrormsg==1 && $flagerroremail==1)
		{
			return array('status'=>$this->errorCode['EMAIL_SMS_SEND_ERROR'],'message'=>$this->msg['EMAIL_SMS_SEND_ERROR']);
		}
		else if($flagerrormsg==1)
		{
			return array('status'=>$this->errorCode['SMS_SEND_ERROR'],'message'=>$this->msg['SMS_SEND_ERROR']);
		}
		else if($flagerroremail==1)
		{
			return array('status'=>$this->errorCode['_EMAIL_SEND_ERROR_'],'message'=>$this->msg['_EMAIL_SEND_ERROR_']);
		}
		else
		{
		
			if($flagsuccessmsg==1 && $flagsuccessemail==1)
			{
				$msgmsg=$this->msg['SUCCESS_MSG_BOTH'];
				$message = str_replace("_token_",$token,$msgmsg);	
				return array('status'=>0,'message'=>$message,'token'=>$token);
			}
			else if($flagsuccessmsg==1)
			{
				$msgmsg=$this->msg['SUCCESS_MSG_SMS'];
				$message = str_replace("_token_",$token,$msgmsg);	
				return array('status'=>0,'message'=>$message,'token'=>$token);
			}
			else
			{
				$msgmsg=$this->msg['SUCCESS_MSG_EMAIL'];
				return array('status'=>0,'message'=>$msgmsg);
			}
		}	
	
	}
	
	function verifyaccount($key,$id,$by='WEB')
	{
		if(!is_numeric($id))
		{
			$algoObj= new Algoencryption();
			$pid=$algoObj->decrypt($id);
		}
		else
		{
			$pid=$id;
		}
		
		$result = Yii::app()->db->createCommand()
		->select('*')
		->from($this->tableName())
		->where('id=:id', array(':id'=>$pid))
		->queryRow();
		
		if(!empty($result))
		{
			/*if(time() > $result['expiry'] )
			{
				return 4;
			}
			else*/ if($result['isVerified'] == '1')
			{
		 		return 2;
			}
			else if($result['isVerified'] == $key)
			{
				$modifieddate= date('Y-m-d h:m:s');
				$UserArray['isVerified']='1';
				$UserArray['modifiedAt']=$modifieddate;
				
				$this->setData($UserArray);
				$this->insertData($pid);
				return 1;
			}
			else
			{	
				return 3;
			}
		}
		else
		{		
			return 3;
		}
	}
	
	/*
	DESCRIPTION : CHECK OTHER SAME EMAIL EXISTS OR NOT
	*/
	function checkOtherEmail($email,$chkUserId='-1',$type=NULL)
	{
		$condition='loginId=:loginId';
		$params=array(':loginId'=>$email);
		
		
		$result = Yii::app()->db->createCommand()
		->select('loginId')
		->from($this->tableName())
		->where($condition,$params)
		->order('id asc')
		->queryScalar();
	
		return $result;
	}
	
	/*
	DESCRIPTION : GET USER/AUTHOR PROFILE DETAILS FUNCTION
	PARAMS : $id -> USER/AUTHOR id
	*/
	function getProfileDetails($sessionArray, $type='user')
	{
		
		$algoencryptionObj=new Algoencryption();	
		if(isset($sessionArray['userId']) && !is_numeric($sessionArray['userId']))
		{
			$sessionArray['userId']=$algoencryptionObj->decrypt($sessionArray['userId']);	
		}
		
		if(isset($sessionArray['userId']) && !is_numeric($sessionArray['userId']))
		{
			$sessionArray['userId']=$algoencryptionObj->decrypt($sessionArray['userId']);
		}
		
		$details['loginDetails']	=	$this->getLoginId($sessionArray['userId']);
		
		
		$details['userDetails']	=	$this->getUserDetailsByLoginId($sessionArray['userId'], $type);
		$details['avatarDir']	=	$algoencryptionObj->encrypt("USER_".$details['loginDetails']['id']);
		$accountType	=	0;
		
		
		//$details['vPhone']	=	$this->getVerifiedPhone($details['loginDetails']['id'], $accountType);
		//$details['nvPhone']	=	$details['vPhone']==false?0:1;
		//$details['uPhone']	=	$this->getUnVerifiedPhone($details['loginDetails']['id'], $accountType);
		//$details['nuPhone']	=	$details['uPhone']==false?0:1;;
		//$details['verifiedEmail']	=	$this->getUserVerifiedEmail($details['loginDetails']['id'], $accountType);
		/*$details['allPhones']	=	$this->getAllPhones($id);*/
		return array("status"=>0,"result"=>$details);
	}
	
	function getLoginId($id = NULL)
	{		
	
		$result_user	=	Yii::app()->db->createCommand()
							->select("*")
							->from($this->tableName())
							->where('id=:id', array(':id'=>$id))
							->queryRow();
			
		return $result_user;
	}
	
	function getUserDetailsByLoginId($id=NULL, $type='user')
	{
		$login	=	$this->getLoginId($id);
		$usersObj	=	new Users();
		$userDetails	=	$usersObj->getUserById($login['id']);
		$userDetails['name']=$userDetails['firstName'].' '.$userDetails['lastName'];
		$userDetails['loginId']=$login['loginId'];
		$userDetails['id']=$login['id'];
		return $userDetails;
	}
	
	function getRecordByEmail($email = NULL)
	{		
	
		$id	=	Yii::app()->db->createCommand()
							->select("id")
							->from($this->tableName())
							->where('loginId=:loginId', array(':loginId'=>$email))
							->queryScalar();
		return $id;

	}
	
	function uploadAvatar($POST=array(),$FILES=array(),$stat=NULL)
	{
		$_POST = $POST;
		$_FILES = $FILES;
		
		if(isset($_POST['userId']))
		{
			if(!is_numeric($_POST['userId']))
			{
				$algObj = new Algoencryption();					
				$_POST['userId'] = $algObj->decrypt($_POST['userId']);
			}
		}
		else
		{
			$result['status'] = $this->errorCode['_INVALID_PARAMETERS_'];
			$result['message'] = $this->msg['_INVALID_PARAMETERS_'];
			return $result;
		}
		if($stat != NULL && $stat == "update")
		{
			
				if(isset($_POST['file_name']) && $_POST['file_name'] != "" && isset($_POST['userId']) && $_POST['userId']!='')
				{
					$this->setData(array('avatar'=>$_POST['file_name']));
					$this->insertData($_POST['userId']);
						
					//Deleting other file
					$algo=new Algoencryption();
					$newdir=$algo->encrypt("USER_".$_POST['userId']);
					
					$uploaddir = FILE_UPLOAD.'avatar/'.trim($newdir);
					if(is_dir($uploaddir))
					{
						if ($handle = opendir($uploaddir)) 
						{
							while (false !== ($file = readdir($handle))) 
							{
								
								$filepath=$uploaddir.'/'.$file;
								if(strlen($file)>6)
								{
									
									if(file_exists($filepath))
									{
										
										if($file!=$_POST['file_name'])
										{
												unlink($filepath);
										}
									}
								}
							}
						}
					}
					$response_data['status']=0;
					$response_data['dir']=$newdir;
					$response_data['result']=$_POST['file_name'];
					$response_data['message']=$this->msg['_AVATAR_UPLOAD_'];
					return $response_data;
				}
				else
				{
					$response_data['status']=$this->errorCode['_INVALID_PARAMETERS_'];
					$response_data['message']=$this->msg['_INVALID_PARAMETERS_'];
					$response_data['result']='';
					return $response_data;
				}
			
		}
		else
		{
		
        if(isset($_FILES['avatar']))
        {
            $uploaddir = FILE_UPLOAD.'avatar/';
			$extArray=unserialize(IMAGE_EXT);
			$filedata=explode('.',$_FILES['avatar']['name']);
           
			$fileext=$filedata[count($filedata)-1];
			
			if(in_array($fileext,$extArray))
			{
				
				//create new dir
				$algo=new Algoencryption();	
				$newdir=$algo->encrypt("USER_".$_POST['userId']);
				if(!is_dir($uploaddir.$newdir))
				{
					
					$oldmask = umask(0);
					mkdir($uploaddir.$newdir,0777);
					umask($oldmask);
					
					
				}
				
				//checking if file name is exist or not
				$filename=md5(rand()).'.'.$fileext;
				$file = $uploaddir.$newdir.'/'.$filename;
				while(file_exists($file))
				{
					$filename=md5(rand()).'.'.$fileext;
					$file = $uploaddir.$newdir.'/'.$filename;
				}
				if (move_uploaded_file($_FILES['avatar']['tmp_name'], $file))
				{
					chmod($file, 0777);
					list($width,$height) = getimagesize($file);
					if($width > 90 || $height > 90)
					{
						$generalObj=new General();
						$generalObj->resizeImage($file, $file, 90, 90);
					}
					
					$response_data['status']=0;
					$response_data['result']=$filename;
					$response_data['dir']=$newdir;
					$response_data['message']='Success';
					return $response_data;
				}
				else
				{
					$response_data['status']=$this->errorCode['_INVALID_PARAMETERS_'];
					$response_data['message']=$this->msg['_FILE_UPLOAD_ERROR_'];
					$response_data['result']=$this->msg['_FILE_UPLOAD_ERROR_'];
					return $response_data;
				}
			}
			else
			{
				
				$response_data['status']=$this->errorCode['_INVALID_EXTENSION_'];
				$response_data['message']=$this->msg['_INVALID_EXTENSION_'];
				$response_data['result']=$this->msg['_INVALID_EXTENSION_'];
				return $response_data;
			}
        }
		}
		
	}
	
	public function getAllPaginatedUsers($limit=5,$sortType="desc",$sortBy="u.id",$keyword=NULL,$startDate=NULL,$endDate=NULL)
	{
		
 		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (p.firstName like '%".$keyword."%' or p.lastName like '%".$keyword."%' or p.email like '%".$keyword."%')";	
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			$dateSearch = " and u.createdAt > '".date("Y-m-d",strtotime($startDate))."' and u.createdAt < '".date("Y-m-d",strtotime($endDate))."'";	
		}
		
		   $sql_users = "select u.id as user_id,u.*,b.* from users u LEFT JOIN person_account p ON ( p.userId = u.id ) LEFT JOIN business_details b ON ( b.userId = u.id ) where (u.status=0 or u.status=1 or u.status=2) ".$search." ".$dateSearch." GROUP BY u.id order by ".$sortBy." ".$sortType." " ;
		$sql_count = "select u.id as user_id,u.*,b.* from users u LEFT JOIN person_account p ON ( p.userId = u.id ) LEFT JOIN business_details b ON ( b.userId = u.id ) where (u.status=0 or u.status=1 or u.status=2) ".$search." ".$dateSearch." GROUP BY u.id order by ".$sortBy." ".$sortType."  ";
		$count	=	Yii::app()->db->createCommand($sql_count)->queryAll();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>count($count),
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'users'=>$item->getData());
	}
	
	public function getAllCallbackRequestedUsers($limit=5,$sortType="desc",$sortBy="id",$keyword=NULL,$startDate=NULL,$endDate=NULL)
	{
 		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (firstName like '%".$keyword."%' or lastName like '%".$keyword."%' or loginId like '%".$keyword."%')";	
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			$dateSearch = " and createdAt > '".date("Y-m-d",strtotime($startDate))."' and createdAt < '".date("Y-m-d",strtotime($endDate))."'";	
		}
		
		 $sql_users = "select * from users  where callback = 1 " .$search." ".$dateSearch." order by ".$sortBy." ".$sortType." " ;
		 $sql_count = "select count(*) from users  where  callback = 1  ".$search." ".$dateSearch." ";
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'users'=>$item->getData());
	}
	
	public function getAllApprovedUsersByFx($fx_Id,$limit=5,$sortType="desc",$sortBy="u.id",$keyword=NULL,$startDate=NULL,$endDate=NULL)
	{
 		$criteria = new CDbCriteria();
		$search = '';
		$dateSearch = '';
		if(isset($keyword) && $keyword != NULL )
		{
			$search = " and (p.firstName like '%".$keyword."%' or p.lastName like '%".$keyword."%' or p.email like '%".$keyword."%')";	
		}
		if(isset($startDate) && $startDate != NULL && isset($endDate) && $endDate != NULL)
		{
			$dateSearch = " and u.createdAt > '".date("Y-m-d",strtotime($startDate))."' and u.createdAt < '".date("Y-m-d",strtotime($endDate))."'";	
		}
		
		$sql_users = "select u.id as user_id,u.*,p.*,b.* from users u LEFT JOIN person_account p ON ( p.userId = u.id ) LEFT JOIN business_details b ON ( b.userId = u.id ) LEFT JOIN user_fx_relation uf ON ( uf.userId = u.id ) where (u.isVerified=0 or u.isVerified=1 or u.isVerified=2) and uf.fxId = 1 and uf.status = 1 ".$search." ".$dateSearch." order by ".$sortBy." ".$sortType." " ;
		 $sql_count = "select count(*) from users u LEFT JOIN person_account p ON ( p.userId = u.id ) LEFT JOIN user_fx_relation uf ON ( uf.userId = u.id ) where (u.isVerified=0 or u.isVerified=1 or u.isVerified=2) and uf.fxId = 1 and uf.status = 1  ".$search." ".$dateSearch." ";
		$count	=	Yii::app()->db->createCommand($sql_count)->queryScalar();
		
		$item	=	new CSqlDataProvider($sql_users, array(
						'totalItemCount'=>$count,
						'pagination'=>array(
							'pageSize'=>LIMIT_10,
						),
					));
		$index = 0;	
		return array('pagination'=>$item->pagination, 'users'=>$item->getData());
	}
	
	function changePassword($data = array())
	{
		
		if(!empty($data))
		{
			$data['newpassword'] = htmlentities($data['newpassword']);
			$data['confirmpassword'] = htmlentities($data['confirmpassword']);
			if($data['newpassword']=='' || strlen($data['newpassword'])<8)
			{
				return array(false,Yii::app()->params->msg['_PASSWORD_LENGTH_ERROR_'],68);
			}
			if($data['newpassword']!=$data['confirmpassword'])
			{
				return array(false,Yii::app()->params->msg['_BOTH_PASSWORD_NOT_METCH_'],70);
			}
			if($data['oldpassword']==$data['newpassword'])
			{
				return array(false,Yii::app()->params->msg['_OLD_NEW_PASSWORD_SAME_'],114);
			}
			
			if(!is_numeric($data['id'])){
				$algoencryptionObj	=	new Algoencryption();
				$data['id']	=	$algoencryptionObj->decrypt($data['id']);
			}
			$res = $this->getUserDetail($data['id']);
			$userData = $res['result'];
			$generalObj = new General();
			
			if($generalObj->validate_password($data['oldpassword'],$userData['password']))
			{
				$res = true;
			}
			else
			{
				$res = false;
			}
			if($res==true)
			{
				
				$userObj=Users::model()->findbyPk($data['id']);
				$password = $generalObj->encrypt_password($data['newpassword']);
				$arr = array();
				$arr['password'] = $password;
				$userObj->setData($arr);
				$userObj->insertData($data['id']);
				return array(true,Yii::app()->params->msg['_PASSWORD_CHANGE_SUCCESS_'],0);
			}
			else
			{
				return array(false,Yii::app()->params->msg['_OLD_PASSWORD_NOT_METCH_'],69);
			}
		}
		else
		{
			echo "<pre>";
			print_r($data);
			exit;	
		}
	}
	
	function getAllProfileData($id)
	{
		$result	=	Yii::app()->db->createCommand()
					->select("u.id as user_id,u.*,p.*,b.*,pa.*")
					->from('users u')
					->leftjoin('person_account p','p.userId=u.id')
					->leftjoin('business_details b','b.userId=u.id')
					->leftjoin('person_other_info pa','pa.userId=u.id')
					->where('u.id=:id', array(':id'=>$id))
					->queryRow();
					
		return $result;
	}
	
}