<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CI_Model {

	private $id;
    private $name;
    private $height;
    private $width;
    private $type;
    private $size;

    public function __construct()
    {
    	parent::__construct();
    }

    public function getById()
    {
        $this->db->where('id', $this->id);
        $query = $this->db->get('image');
        $rowImage = $query->row();

        $this->id = $rowImage->id;
        $this->name = $rowImage->category;
        $this->height = $rowImage->height;
        $this->width = $rowImage->width;
        $this->type = $rowImage->type;
        $this->size = $rowImage->size;

        return $this;
    }

    public function save()
    {
        $this->db->set('name', $this->category);
        $this->db->set('height', $this->height);
        $this->db->set('width', $this->width);
        $this->db->set('type', $this->type);
        $this->db->set('size', $this->size);

        $result = $this->db->insert('image');
        return $result;
    }

    public function deleteByName()
    {
        $this->db->where('name', $this->name);
        return $this->db->delete('image');
    }

    public function deleteById()
    {
        // Delete images to files
        

        $this->db->where('id', $this->id);
        return $this->db->delete('image');
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getName(){ return $this->name; }
    public function setName($name){ $this->name = $name; }

    public function getHeight(){ return $this->height; }
    public function setHeight($height){ $this->height = $height; }

    public function getWidth(){ return $this->width; }
    public function setWidth($width){ $this->width = $width; }

    public function getType(){ return $this->type; }
    public function setType($type){ $this->type = $type; }

    public function getSize(){ return $this->size; }
    public function setSize($size){ $this->size = $size; }
}