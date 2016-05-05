<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends CI_Model {

	private $id;
    private $name;
    private $privateKey;
    private $created;
    private $validity;

    public function __construct()
    {
    	parent::__construct();
    }

    // Core Methods
    public function validate()
    {
        $query = $this->db;
        $query->where('name', $this->name);
        $row = $query->get('application')->row();

        if (isset($row))
        {
            $this->id = $row->id;
            $this->created = $row->created;
            $this->privateKey = '1234';
            $this->validity = $row->validity;
        }

        return $this;
    }

    public function add()
    {
        $data['name'] = $this->name;
        $data['privateKey'] = $this->privateKey;
        $data['created'] = function_exists('now') ? now() : time();
        $data['validity'] = 0;

        return $this->db->set($data)->insert('application');
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getName(){ return $this->name; }
    public function setName($name){ $this->name = $name; }

    public function getPrivateKey(){ return $this->privateKey; }
    public function setPrivateKey($privateKey){ $this->privateKey = $privateKey; }

    public function getCreated(){ return $this->created; }
    public function setCreated($created){ $this->created = $created; }

    public function getValidity(){ return $this->validity; }
    public function setValidity($validity){ $this->validity = $validity; }
}