<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductCategory extends CI_Model {

    var $id;
    var $category;
    var $name;
    var $detail;
    var $information;
    var $price;

    public function __construct()
    {
    	parent::__construct();

        $this->load->model('textValue');
        $this->lang->load('ecommerce','english');
    }

    public function getById($location = null)
    {
        $this->db->where('id', $this->id);
        $query = $this->db->get('product');
        $rowProduct = $query->row();

        if($rowProduct)
        {
            $this->id = (int) $rowProduct->id;
            $this->category = (int) $rowProduct->parent;

            $this->textValue->setKey($rowProduct->name);

            if($location == null)
                $this->name = $this->textValue->getByKey();
            else
                $this->name = $this->textValue->getByKeyAndLenguage($location);

            $this->textValue->setKey($rowProduct->description);

            if($location == null)
                $this->description = $this->textValue->getByKey();
            else
                $this->description = $this->textValue->getByKeyAndLenguage($location);

            return $this;
        } 
        else
        {
            return sprintf($this->lang->line('error_get_category'), $this->id);
        }
    }

    public function getByCategory($location = null)
    {
        
    }

    public function getAll($location = null)
    {
        
    }

    public function save($location = null)
    {
        
    }

    public function modify($location = null)
    {

    }

    public function delete()
    {

    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getCategory(){ return $this->category; }
    public function setCategory($category){ $this->category = $category; }

    public function getName(){ return $this->name; }
    public function setName($name){ $this->name = $name; }

    public function getDetail(){ return $this->detail; }
    public function setDetail($detail){ $this->detail = $detail; }

    public function getInformation(){ return $this->information; }
    public function setInformation($information){ $this->information = $information; }

    public function getPrice(){ return $this->price; }
    public function setPrice($price){ $this->price = $price; }
}