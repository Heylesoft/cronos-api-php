<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rol extends CI_Model {

	private $id;
    private $name;

    public function __construct()
    {
    	parent::__construct();

        $this->load->model('textValue');
        $this->load->library('session');
    }

    public function getById()
    {
        $this->db->where('id', $this->id);
        $query = $this->db->get('rol');
        $rowRol = $query->row();

        if(isset($rowRol))
        {
            $this->textValue->setKey($rowRol->name);

            $location = $this->session->userdata('location');
            
            if($location != null)
                $this->name = $this->textValue->getByKeyAndLenguage($location);

            return $this;
        }

        //TODO: Return error by ID
        return null;

    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getName(){ return $this->name; }
    public function setName($name){ $this->name = $name; }
}