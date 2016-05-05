<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AccessUser extends CI_Model {

	private $id;
    private $user;
    private $module;
    private $permissions;

    public function __construct()
    {
    	parent::__construct();
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getUser(){ return $this->user; }
    public function setUser($user){ $this->user = $user; }

    public function getModule(){ return $this->module; }
    public function setModule($module){ $this->module = $module; }

    public function getPermissions(){ return $this->permissions; }
    public function setPermissions($permissions){ $this->permissions = $permissions; }
}