<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Model {

	private $id;
    private $name;
    private $description;

    public function __construct()
    {
    	parent::__construct();
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getName(){ return $this->name; }
    public function setName($name){ $this->name = $name; }

    public function getDescription(){ return $this->description; }
    public function setDescription($description){ $this->description = $description; }
}