<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginLog extends CI_Model {

	private $id;
    private $user;
    private $session;
    private $created;

    public function __construct()
    {
    	parent::__construct();
    }

    public function save()
    {
        $result = null;

        $data = array(
            "user" => $this->user,
            "session" => $this->session
        );

        $result = $this->db->set($data)->insert('login_log');
        return $result;
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getUser(){ return $this->user; }
    public function setUser($user){ $this->user = $user; }

    public function getSession(){ return $this->session; }
    public function setSession($session){ $this->session = $session; }

    public function getCreated(){ return $this->created; }
    public function setCreated($created){ $this->created = $created; }
}