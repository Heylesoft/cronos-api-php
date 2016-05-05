<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/core/MY_RESTController.php';

class Category extends MY_RESTController {

    private $userID;

	function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->model('productCategory');
        $this->load->model('productCategoryImage');

		$this->load->library('session');

        $this->lang->load('general','english');
        $this->lang->load('ecommerce','english');
    }

    /*
     * Manage Categories
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
            $responseMessage['status'] = FALSE;
            $responseMessage['message'] = sprintf($this->lang->line('msg_field_required'), "id");
            $this->response($responseMessage, REST_Controller::HTTP_BAD_REQUEST);
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

    public function index_post()
    {
        if(!$this->_validateSession())
        {
            $responseMessage['status'] = FALSE;
            $responseMessage['message'] = $this->lang->line('session_inactive');
            $this->response($responseMessage, MY_RESTController::HTTP_BAD_REQUEST);
        }

        $parentInput = $this->post('parent');
        $nameInput = $this->post('name');
        $descriptionInput = $this->post('description');

        if ($nameInput === NULL)
        {
            $responseMessage['status'] = FALSE;
            $responseMessage['message'] = sprintf($this->lang->line('msg_field_required'), "Name");
            $this->response($responseMessage, MY_RESTController::HTTP_BAD_REQUEST);
        }

        $this->productCategory->setParent($parentInput);
        $this->productCategory->setName($nameInput);
        $this->productCategory->setDescription($descriptionInput);

        $responseData = $this->productCategory->save();

        $responseMessage = array('status'=>TRUE, 'message'=>$responseData);
        $this->response($responseMessage, MY_RESTController::HTTP_OK);
    }

    public function index_put()
    {
        if(!$this->_validateSession())
        {
            $responseMessage['status'] = FALSE;
            $responseMessage['message'] = $this->lang->line('session_inactive');
            $this->response($responseMessage, MY_RESTController::HTTP_BAD_REQUEST);
        }

        $idInput = $this->get('id');
        $parentInput = $this->put('parent');
        $nameInput = $this->put('name');
        $descriptionInput = $this->put('description');

        if ($idInput === NULL)
        {
            $responseMessage['status'] = FALSE;
            $responseMessage['message'] = sprintf($this->lang->line('msg_field_required'), "Id");
            $this->response($responseMessage, MY_RESTController::HTTP_BAD_REQUEST);
        }

        if ($nameInput === NULL)
        {
            $responseMessage['status'] = FALSE;
            $responseMessage['message'] = sprintf($this->lang->line('msg_field_required'), "Name");
            $this->response($responseMessage, MY_RESTController::HTTP_BAD_REQUEST);
        }

        $this->productCategory->setId($idInput);
        $this->productCategory->setParent($parentInput);
        $this->productCategory->setName($nameInput);
        $this->productCategory->setDescription($descriptionInput);

        $responseData = $this->productCategory->modify();

        $responseMessage = array('status'=>TRUE, 'message'=>$responseData);
        $this->response($responseMessage, MY_RESTController::HTTP_OK);
    }

    public function index_delete()
    {
        if(!$this->_validateSession())
        {
            $responseMessage['status'] = FALSE;
            $responseMessage['message'] = $this->lang->line('session_inactive');
            $this->response($responseMessage, MY_RESTController::HTTP_BAD_REQUEST);
        }

        $idInput = $this->get('id');

        if ($idInput === NULL)
        {
            $responseMessage['status'] = FALSE;
            $responseMessage['message'] = sprintf($this->lang->line('msg_field_required'), "Id");
            $this->response($responseMessage, MY_RESTController::HTTP_BAD_REQUEST);
        }
        else
        {
            $id = (int) $idInput;
            
            $this->productCategory->setId($id);

            $responseData = $this->productCategory->delete();
            
            $responseMessage = array('status'=>TRUE, 'message'=>$responseData);
            $this->response($responseMessage, MY_RESTController::HTTP_OK);
        }
    }

    public function images_post()
    {
        if(!$this->_validateSession())
        {
            $responseMessage['status'] = FALSE;
            $responseMessage['message'] = $this->lang->line('session_inactive');
            $this->response($responseMessage, MY_RESTController::HTTP_BAD_REQUEST);
        }

        $categoryInput = $this->get('category');

        $msg = "";
        $file_element_name = 'userfile';

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|doc|txt';
        $config['max_size'] = 1024 * 8;
        $config['encrypt_name'] = TRUE;
 
        $this->load->library('upload', $config);
 
        if (!$this->upload->do_upload($file_element_name))
        {
            $status = 'error';
            $msg = $this->upload->display_errors('', '');
        }
        else
        {
            $data = $this->upload->data();
            //$file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
            if($data)
            {
                $status = "success";
                $msg = "File successfully uploaded";
            }
            else
            {
                unlink($data['full_path']);
                $status = "error";
                $msg = "Something went wrong when saving the file, please try again.";
            }
        }

        @unlink($_FILES[$file_element_name]);

        $responseMessage['status'] = TRUE;
        $responseMessage['message'] = $msg;
        $this->response($responseMessage, MY_RESTController::HTTP_BAD_REQUEST);
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