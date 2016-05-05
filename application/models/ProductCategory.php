<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductCategory extends CI_Model {

    var $id;
    var $parent;
    var $name;
    var $description;
    var $chields;
    var $images;

    public function __construct()
    {
    	parent::__construct();

        $this->load->model('textValue');
        $this->load->model('productCategoryImage');

        $this->lang->load('ecommerce','english');
    }

    public function getById($location = null)
    {
        $this->db->where('id', $this->id);
        $query = $this->db->get('product_category');
        $rowCategory = $query->row();

        if($rowCategory)
        {
            $this->id = (int) $rowCategory->id;
            $this->parent = (int) $rowCategory->parent;

            $this->textValue->setKey($rowCategory->name);

            if($location == null)
                $this->name = $this->textValue->getByKey();
            else
                $this->name = $this->textValue->getByKeyAndLenguage($location);

            $this->textValue->setKey($rowCategory->description);

            if($location == null)
                $this->description = $this->textValue->getByKey();
            else
                $this->description = $this->textValue->getByKeyAndLenguage($location);

            $this->productCategoryImage->setProductCategory($this->id);
            $this->images = $this->productCategoryImage->getByCategory();

            return $this;
        } 
        else
        {
            return sprintf($this->lang->line('error_get_category'), $this->id);
        }
    }

    public function getAllByParent($location = null)
    {
        $result = array();

        $this->db->where('parent', (int) $this->id);
        $query = $this->db->get('product_category');

        foreach ($query->result() as $row)
        {
            $productCategory = new ProductCategory();
            $productCategory->setId((int) $row->id);
            $productCategory->setParent((int) $row->parent);

            $productCategory->setChields($productCategory->getAllByParent($location));

            $this->textValue->setKey($row->name);

            if($location == null)
                $productCategory->setName($this->textValue->getByKey());
            else
                $productCategory->setName($this->textValue->getByKeyAndLenguage($location));

            $this->textValue->setKey($row->description);

            if($location == null)
                $productCategory->setDescription($this->textValue->getByKey());
            else
                $productCategory->setDescription($this->textValue->getByKeyAndLenguage($location));

            $this->productCategoryImage->setProductCategory($row->id);
            $productCategory->images = $this->productCategoryImage->getByCategory();

            array_push($result, $productCategory);
        }

        return $result;
    }

    public function getAll($location = null)
    {
        $result = array();

        $this->db->where('parent', 0);
        $query = $this->db->get('product_category');

        foreach ($query->result() as $row)
        {
            $productCategory = new ProductCategory();
            $productCategory->setId((int) $row->id);
            $productCategory->setParent((int) $row->parent);

            $productCategory->setChields($productCategory->getAllByParent($location));

            $this->textValue->setKey($row->name);

            if($location == null)
                $productCategory->setName($this->textValue->getByKey());
            else
                $productCategory->setName($this->textValue->getByKeyAndLenguage($location));

            $this->textValue->setKey($row->description);

            if($location == null)
                $productCategory->setDescription($this->textValue->getByKey());
            else
                $productCategory->setDescription($this->textValue->getByKeyAndLenguage($location));

            $this->productCategoryImage->setProductCategory($row->id);
            $productCategory->images = $this->productCategoryImage->getByCategory();

            array_push($result, $productCategory);
        }

        return $result;
    }

    public function save()
    {
        $result = null;

        $keyName = "NAME_CATEGORY_" . time();
        $keyDescription = "DESCRIPTION_CATEGORY_" . time();

        foreach ($this->name as $name)
        {
            $this->textValue->setKey($keyName);
            $this->textValue->setValue($name['value']);
            $this->textValue->save($name['location']);
        }

        foreach ($this->description as $description)
        {
            $this->textValue->setKey($keyDescription);
            $this->textValue->setValue($description['value']);
            $this->textValue->save($description['location']);
        }

        $this->db->set('parent', (int) $this->parent);
        $this->db->set('name', $keyName);
        $this->db->set('description', $keyDescription);     

        $result = $this->db->insert('product_category');
        return $result;
    }

    public function modify()
    {
        $result = null;

        foreach ($this->name as $name)
        {
            $this->textValue->setId((int) $name['id']);
            $this->textValue->setValue($name['value']);
            $this->textValue->modify();
        }

        foreach ($this->description as $description)
        {
            $this->textValue->setId((int) $description['id']);
            $this->textValue->setValue($description['value']);
            $this->textValue->modify();
        }

        $this->db->set('parent', (int) $this->parent);    
        $this->db->where('id', (int) $this->id);

        $result = $this->db->update('product_category');
        return $result;
    }

    public function delete()
    {
        $this->db->where('id', (int) $this->id);
        $query = $this->db->get('product_category');
        $rowCategory = $query->row();

        // Delete chields
        $this->db->where('parent', (int) $this->id);
        $query = $this->db->get('product_category');

        foreach ($query->result() as $row)
        {
            $productCategory = new ProductCategory();
            $productCategory->setId((int) $row->id);
            $productCategory->delete();
        }

        // Delete category
        $this->db->where('id', (int) $this->id);
        $returnDelete = $this->db->delete('product_category');

        // Delete names
        $this->textValue->setKey($rowCategory->name);
        $this->textValue->delete();

        // Delete descriptions
        $this->textValue->setKey($rowCategory->description);
        $this->textValue->delete();

        // Delete images
        // $this->productCategoryImage->setCategory($this->id);
        // $this->productCategoryImage->deleteByCategory();

        return $returnDelete;
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getParent(){ return $this->parent; }
    public function setParent($parent){ $this->parent = $parent; }

    public function getName(){ return $this->name; }
    public function setName($name){ $this->name = $name; }

    public function getDescription(){ return $this->description; }
    public function setDescription($description){ $this->description = $description; }

    public function getChields(){ return $this->chields; }
    public function setChields($chields){ $this->chields = $chields; }

    public function getImages(){ return $this->images; }
    public function setImages($images){ $this->images = $images; }
}