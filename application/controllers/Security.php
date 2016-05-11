<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/core/MY_RESTController.php';

class Security extends MY_RESTController {

	function __construct()
    {
        parent::__construct();

        $this->load->database();
		
		$this->load->model('user');
		$this->load->model('key');
		$this->load->model('sessionKey');
		$this->load->model('loginLog');
		$this->load->model('lenguage');

		$this->load->library('encryption');
		$this->load->library('session');
    }

    public function index_get()
    {
		$passDefault = password_hash("123456", PASSWORD_BCRYPT, [ 'cost' => 12 ]);

		//$hash = '$2y$10$MkSJSVRePEY40WO4T44gT.kkpPIs2ovQv9caGxvUAqcf8oBN4hble';
		//$decripDefault = password_verify('12345', $hash);

		//echo $passDefault;

    	$responseMessage = array('status'=>TRUE, 'message'=>':: Cronos Service ::');
    	$this->response($responseMessage, MY_RESTController::HTTP_OK);
    }

	public function login_post()
	{
		$responseMessage = array('status'=>'', 'data'=>'');

		$login = $this->post('login');
		$password = $this->post('password');
		$location = $this->post('location');

		if($location === NULL){
			$this->lang->load('security','english');
			$this->lang->load('general','english');
	    } else {
	    	$this->lenguage->setLocation($location);
	    	$this->lenguage = $this->lenguage->getByLocation();
	    	$this->lang->load('security',$this->lenguage->getName());
	    	$this->lang->load('general',$this->lenguage->getName());
	    }

		if ($login === NULL)
		{
			$responseMessage['status'] = FALSE;
			$responseMessage['data'] = sprintf($this->lang->line('msg_field_required'), "Email");
			$this->response($responseMessage, MY_RESTController::HTTP_OK);
		}

		if ($password === NULL)
		{
			$responseMessage['status'] = FALSE;
			$responseMessage['data'] = sprintf($this->lang->line('msg_field_required'), "Password");
			$this->response($responseMessage, MY_RESTController::HTTP_OK);
		}

		$this->user->setEmail($login);
		$this->user->validate();

		if($this->user->getId() == "")
		{
			$responseMessage['status'] = FALSE;
			$responseMessage['data'] = $this->lang->line('login_incorrect_data');
			$this->response($responseMessage, MY_RESTController::HTTP_OK);
		} 
		else 
		{
			if (password_verify($password, $this->user->getPassword())){
			    $key = $this->key->generateKey();

		        $level = 1;
		        $ignore_limits = 1;

		        if ($this->key->insertKey($key, ['level' => $level, 'ignore_limits' => $ignore_limits]))
		        {
		        	$userData = array(
						'user' => $this->user->getId(),
						'key' => $key
					);

					$this->session->set_userdata($userData);
		        	$sessionID = $this->session->session_id;

		        	$this->sessionKey->setKey($this->key->getId());
		        	$this->sessionKey->setSession($sessionID);

		        	if($this->sessionKey->save())
		        	{
		        		$this->loginLog->setUser($this->user->getId());
		        		$this->loginLog->setSession($sessionID);

						if($this->loginLog->save())
						{
							$responseMessage['status'] = TRUE;
							$responseMessage['data'] = $sessionID;
							$this->response($responseMessage, MY_RESTController::HTTP_OK);	
						}		        		
						else
						{
							$this->sessionKey->deleteByKey();
							$this->key->deleteKey($key);

		        			$responseMessage['status'] = FALSE;
							$responseMessage['data'] = $this->lang->line('system_error');
							$this->response($responseMessage, MY_RESTController::HTTP_INTERNAL_SERVER_ERROR);
						}
		        	}
		        	else
		        	{
		        		$this->key->deleteKey($key);

		        		$responseMessage['status'] = FALSE;
						$responseMessage['data'] = $this->lang->line('system_error');
						$this->response($responseMessage, MY_RESTController::HTTP_INTERNAL_SERVER_ERROR);
		        	}
		        }
		        else
		        {
		        	$responseMessage['status'] = FALSE;
					$responseMessage['data'] = $this->lang->line('dont_save_key');
		            $this->response($responseMessage, MY_RESTController::HTTP_INTERNAL_SERVER_ERROR);
		        }
			} 
			else 
			{
			    $responseMessage['status'] = FALSE;
				$responseMessage['data'] = $this->lang->line('login_incorrect_data');
				$this->response($responseMessage, MY_RESTController::HTTP_OK);
			}			
		}
	}

	public function validate_post()
	{
		$responseMessage = array('status'=>'', 'message'=>'');

		$key = $this->post('txt-key');

		$sessionID = $this->session->session_id;

		if($key == $sessionID)
		{
			$responseMessage['status'] = TRUE;
			$responseMessage['key'] = $sessionID;
			$this->response($responseMessage, MY_RESTController::HTTP_OK);	
		}
		else
		{
			$responseMessage['status'] = FALSE;
			$responseMessage['message'] = 'Session Inactive';
			$this->response($responseMessage, MY_RESTController::HTTP_BAD_REQUEST);
		}
	}
}
