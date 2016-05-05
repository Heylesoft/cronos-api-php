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
		$responseMessage = array('status'=>'', 'message'=>'');

		$login = $this->post('txt-login');
		$password = $this->post('txt-password');

		if ($login === NULL)
		{
			$responseMessage['status'] = FALSE;
			$responseMessage['message'] = 'Field login is required';
			$this->response($responseMessage, MY_RESTController::HTTP_NOT_FOUND);
		}

		if ($password === NULL)
		{
			$responseMessage['status'] = FALSE;
			$responseMessage['message'] = 'Field password is required';
			$this->response($responseMessage, MY_RESTController::HTTP_NOT_FOUND);
		}

		$this->user->setEmail($login);
		$this->user->validate();

		if($this->user->getId() == "")
		{
			$responseMessage['status'] = FALSE;
			$responseMessage['message'] = 'Login/Password incorrect';
			$this->response($responseMessage, MY_RESTController::HTTP_BAD_REQUEST);
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
							$responseMessage['key'] = $sessionID;
							$this->response($responseMessage, MY_RESTController::HTTP_OK);	
						}		        		
						else
						{
							$this->sessionKey->deleteByKey();
							$this->key->deleteKey($key);

		        			$responseMessage['status'] = FALSE;
							$responseMessage['message'] = 'System Error';
							$this->response($responseMessage, MY_RESTController::HTTP_INTERNAL_SERVER_ERROR);
						}
		        	}
		        	else
		        	{
		        		$this->key->deleteKey($key);

		        		$responseMessage['status'] = FALSE;
						$responseMessage['message'] = 'System Error';
						$this->response($responseMessage, MY_RESTController::HTTP_INTERNAL_SERVER_ERROR);
		        	}
		        }
		        else
		        {
		        	$responseMessage['status'] = FALSE;
					$responseMessage['message'] = 'Could not save the key';
		            $this->response($responseMessage, MY_RESTController::HTTP_INTERNAL_SERVER_ERROR);
		        }
			} 
			else 
			{
			    $responseMessage['status'] = FALSE;
				$responseMessage['message'] = 'Login/Password incorrect';
				$this->response($responseMessage, MY_RESTController::HTTP_BAD_REQUEST);
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
