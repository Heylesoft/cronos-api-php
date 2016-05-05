<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductCategoryImage extends CI_Model {

	private $id;
    private $productCategory;
    private $image;

    public function __construct()
    {
    	parent::__construct();

        $this->load->model('image');
    }

    public function getByCategory()
    {
        $result = array();

        $this->db->where('product_category', (int) $this->productCategory);
        $query = $this->db->get('product_category_image');
        $rowCategory = $query->row();

        foreach ($query->result() as $row) 
        {
            $ProductCategoryImage = new ProductCategoryImage();
            $ProductCategoryImage->id = $rowCategory->id;
            $ProductCategoryImage->productCategory = $rowCategory->productCategory;
            $ProductCategoryImage->image = $rowCategory->image;

            array_push($result, $ProductCategoryImage);
        }

        return $result;
    }

    public function save()
    {
        $result = null;

        $this->db->set('product_category', (int) $this->productCategory);
        $this->db->set('image', $this->image);  

        $result = $this->db->insert('product_category_image');
        return $result;
    }

    public function deleteByImage()
    {
        $this->image->setId($this->image);
        $this->image->deleteById();

        $this->db->where('image', $this->image);
        return $this->db->delete('product_category_image');
    }

    public function deleteByCategory()
    {
        $this->db->where('product_category', $this->productCategory);
        $query = $this->db->get('product_category_image');
        $rowCategory = $query->row();

        foreach ($query->result() as $row) 
        {
            $this->image->setId($row->image);
            $this->image->deleteById();
        }

        $this->db->where('product_category', $this->productCategory);
        return $this->db->delete('product_category_image');
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getProductCategory(){ return $this->productCategory; }
    public function setProductCategory($productCategory){ $this->productCategory = $productCategory; }

    public function getImage(){ return $this->image; }
    public function setImage($image){ $this->image = $image; }
}