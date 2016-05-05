<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Key extends CI_Model {

	public $id;
    public $key;
    public $level;
    public $ignoreLimits;
    public $isPrivateKey;
    public $ipAddresses;
    public $dateCreated;

    public function __construct()
    {
    	parent::__construct();
    }

    public function generateKey()
    {
        do
        {
            // Generate a random salt
            $salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);
            // If an error occurred, then fall back to the previous method
            if ($salt === FALSE)
            {
                $salt = hash('sha256', time() . mt_rand());
            }
            $newKey = substr($salt, 0, 40); //config_item('rest_key_length'));
        }
        while ($this->keyExists($newKey));
        
        return $newKey;
    }

    public function getKey($key)
    {
        return $this->db->where('key', $key)->get('keys')->row();
    }

    public function keyExists($key)
    {
        return $this->db->where('key', $key)->count_all_results('keys') > 0;
    }

    public function insertKey($key, $data)
    {
        $data['key'] = $key;
        $data['date_created'] = function_exists('now') ? now() : time();
        $result = $this->db->set($data)->insert('keys');
        $this->id = $this->db->insert_id();

        return $result;
    }

    public function updateKey($key, $data)
    {
        return $this->db->where('key', $key)->update('keys', $data);
    }

    public function deleteKey($key)
    {
        return $this->db->where('key', $key)->delete('keys');
    }

    // Getters & Setters
    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }
}