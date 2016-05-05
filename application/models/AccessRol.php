<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AccessRol extends CI_Model {

	private $id;
    private $rol;
    private $module;
    private $permissions;

    public function __construct()
    {
    	parent::__construct();
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getRol(){ return $this->rol; }
    public function setRol($rol){ $this->rol = $rol; }

    public function getModule(){ return $this->module; }
    public function setModule($module){ $this->module = $module; }

    public function getPermissions(){ return $this->permissions; }
    public function setPermissions($permissions){ $this->permissions = $permissions; }
}