<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SessionKey extends CI_Model {

	private $id;
    private $key;
    private $session;

    public function __construct()
    {
    	parent::__construct();
    }

    public function save()
    {
        $result = null;

        $this->db->set('key', $this->key);
        $this->db->set('session', $this->session);

        $result = $this->db->insert('session_key');
        return $result;
    } 

    public function deleteByKey()
    {
        return $this->db
            ->where('key', $this->key)
            ->delete('session_key');
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getKey(){ return $this->key; }
    public function setKey($key){ $this->key = $key; }

    public function getSession(){ return $this->session; }
    public function setSession($session){ $this->session = $session; }
}