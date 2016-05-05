<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TextValue extends CI_Model {

	var $id;
    var $lenguage;
    var $value;
    var $key;

    public function __construct()
    {
    	parent::__construct();

        $this->load->model('Lenguage');
    }

    public function getByKey()
    {
        $result = array();
        
        $this->db->where('key', $this->key);
        $query = $this->db->get('text_value');

        foreach ($query->result() as $row)
        {
            $textValue = new TextValue();
            $textValue->setId($row->id);

            $this->Lenguage->setId($row->lenguage);
            $textValue->setLenguage($this->Lenguage->getLocationById());

            $textValue->setValue($row->value);
            $textValue->setKey($row->key);
            array_push($result, $textValue);
        }

        return $result;
    }

    public function getByKeyAndLenguage($location)
    {   
        $this->db->select('*');
        $this->db->from('text_value');
        $this->db->join('lenguage', 'lenguage.id = text_value.lenguage');
        $this->db->where('text_value.key', $this->key);
        $this->db->where('lenguage.location', $location);

        $row = $this->db->get()->row();

        if($row)
        {
            $this->setId($row->id);
            $this->setLenguage($row->lenguage);
            $this->setValue($row->value);
            $this->setKey($row->key);
            return $this;
        }
        else
        {
            return NULL;
        }
    }    

    public function save($location)
    {
        $this->Lenguage->setLocation($location);
        $lenguageID = (int) $this->Lenguage->getByLocation()->getId();

        $this->db->set('lenguage', $lenguageID);
        $this->db->set('value', $this->value);
        $this->db->set('key', $this->key);     

        $result = $this->db->insert('text_value');

        return $result;
    }

    public function modify()
    {
        $this->db->set('value', $this->value); 
        $this->db->where('id', $this->id);

        $result = $this->db->update('text_value');

        return $result;
    }

    public function delete()
    {
        $this->db->where('key', $this->key);
        return $this->db->delete('text_value');
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getLenguage(){ return $this->lenguage; }
    public function setLenguage($lenguage){ $this->lenguage = $lenguage; }

    public function getValue(){ return $this->value; }
    public function setValue($value){ $this->value = $value; }

    public function getKey(){ return $this->key; }
    public function setKey($key){ $this->key = $key; }
}