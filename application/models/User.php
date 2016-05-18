<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {

	private $id;
    private $name;
    private $lastName;
    private $email;
    private $password;
    private $birthday;
    private $rol;

    public function __construct()
    {
    	parent::__construct();
    }

    public function validate()
    {
    	$strQuery = "";
    	$strQuery .= "SELECT id, password";
    	$strQuery .= " FROM user";
    	$strQuery .= " WHERE email='" . $this->email ."'";;

		$query = $this->db->query($strQuery);
		$row = $query->row();

		if (isset($row))
		{
	        $this->id = $row->id;
            $this->password = $row->password;
		}

		return $this;
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getName(){ return $this->name; }
    public function setName($name){ $this->name = $name; }

    public function getLastName(){ return $this->lastName; }
    public function setLastName($lastName){ $this->lastName = $lastName; }

    public function getEmail(){ return $this->email; }
    public function setEmail($email){ $this->email = $email; }

    public function getPassword(){ return $this->password; }
    public function setPassword($password){ $this->password = $password; }

    public function getBirthday(){ return $this->birthday; }
    public function setBirthday($birthday){ $this->birthday = $birthday; }
}