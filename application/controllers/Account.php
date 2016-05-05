<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/core/MY_RESTController.php';

class Account extends MY_RESTController {

	function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->model('module');
        $this->load->model('accessUser');

		$this->load->library('session');
    }

    public function index_get()
    {
    	$responseMessage = array('status'=>TRUE, 'message'=>':: Cronos Service ::');
    	$this->response($responseMessage, MY_RESTController::HTTP_OK);
    }

    public function menu_get()
    {
    	$responseMessage = array('status'=>'', 'message'=>'');

		$key = $this->post('txt-key');

		$sessionID = $this->session->session_id;

		if($key != $sessionID)
		{
			$responseMessage['status'] = FALSE;
			$responseMessage['message'] = 'Session Inactive';
			$this->response($responseMessage, MY_RESTController::HTTP_BAD_REQUEST);
		}

    	$userID = $this->session->userdata('user');

    	$responseMessage = array('status'=>TRUE, 'message'=>$userID);
    	$this->response($responseMessage, MY_RESTController::HTTP_OK);
    }
}