<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Domain extends CI_Model {

	private $id;
    private $site;
    private $value;

    public function __construct()
    {
    	parent::__construct();
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getSite(){ return $this->site; }
    public function setSite($site){ $this->site = $site; }

    public function getValue(){ return $this->value; }
    public function setValue($value){ $this->value = $value; }
}