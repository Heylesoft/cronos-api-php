<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lenguage extends CI_Model {

	var $id;
    var $name;
    var $location;

    public function __construct()
    {
    	parent::__construct();
    }

    public function getByLocation()
    {
        $this->db->where('location', $this->location);
        $row = $this->db->get('lenguage')->row();

        $this->id = $row->id;
        $this->name = $row->name;
        $this->location = $row->location;

        return $this;
    }

    public function getLocationById()
    {
        $this->db->where('id', $this->id);
        $row = $this->db->get('lenguage')->row();

        return $row->location;
    }

    public function getAll()
    {
        $result = array();

        $query = $this->db->get('lenguage');

        foreach ($query->result() as $row)
        {
            $lenguage = new Lenguage();
            $lenguage->setId($row->id);
            $lenguage->setName($row->name);
            $lenguage->setLocation($row->location);
            array_push($result, $lenguage);
        }

        return $result;
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getName(){ return $this->name; }
    public function setName($name){ $this->name = $name; }

    public function getLocation(){ return $this->location; }
    public function setLocation($location){ $this->location = $location; }
}