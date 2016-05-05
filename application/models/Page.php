<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Model {

	private $id;
    private $site;
    private $name;
    private $title;
    private $description;

    public function __construct()
    {
    	parent::__construct();
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getSite(){ return $this->site; }
    public function setSite($site){ $this->site = $site; }

    public function getName(){ return $this->name; }
    public function setName($name){ $this->name = $name; }

    public function getTitle(){ return $this->title; }
    public function setTitle($title){ $this->title = $title; }

    public function getDescription(){ return $this->description; }
    public function setDescription($description){ $this->description = $description; }
}