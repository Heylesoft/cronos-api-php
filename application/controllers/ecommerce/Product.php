<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/core/MY_RESTController.php';

class Product extends MY_RESTController {

    private $userID;

	function __construct()
    {
        parent::__construct();
    }

    /*
     * Magane Products
     */
    public function index_get()
    {
        if(!$this->_validateSession())
        {
            $responseMessage['status'] = FALSE;
            $responseMessage['message'] = $this->lang->line('session_inactive');
            $this->response($responseMessage, MY_RESTController::HTTP_BAD_REQUEST);
        }

        $id = $this->get('id');
        $location = $this->get('location');

        if ($id === NULL)
        {
            if($location === NULL)
            {
                $responseData = $this->productCategory->getAll();
            }
            else
            {
                $responseData = $this->productCategory->getAll($location);
            }

            $responseMessage = array('status'=>TRUE, 'message'=>$responseData);
            $this->response($responseMessage, MY_RESTController::HTTP_OK);
        }

        $id = (int) $id;

        if ($id <= 0)
        {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }
        else
        {
            $this->productCategory->setId($id);

            if($location === NULL)
            {
                $responseData = $this->productCategory->getById();
            }
            else
            {
                $responseData = $this->productCategory->getById($location);
            }

            $responseMessage = array('status'=>TRUE, 'message'=>$responseData);
            $this->response($responseMessage, MY_RESTController::HTTP_OK);
        }
    }

    private function _validateSession()
    {
        $key = $this->get('k');
        $sessionID = $this->session->session_id;

        if($key != $sessionID)
        {
            return TRUE;
            // return FALSE;
        }

        $this->userID = $this->session->userdata('user');

        return TRUE;
    }
}