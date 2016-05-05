<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session extends CI_Model {

	private $id;
    private $ipAddress;
    private $timestamp;
    private $data;

    public function __construct()
    {
    	parent::__construct();
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getIpAddress(){ return $this->ipAddress; }
    public function setIpAddress($ipAddress){ $this->ipAddress = $ipAddress; }

    public function getTimestamp(){ return $this->timestamp; }
    public function setTimestamp($timestamp){ $this->timestamp = $timestamp; }

    public function getData(){ return $this->data; }
    public function setData($data){ $this->data = $data; }
}